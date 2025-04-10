<?php
    
    namespace App\Http\Helpers;
    
    use App\Http\Services\StockReturnService;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\Stock;
    use App\Models\StockReturn;
    use Illuminate\Support\Carbon;
    
    class AdjustmentService {
        
        /**
         * --------------
         * @return mixed
         * get all stocks
         * --------------
         */
        
        public function all ( $type = 'adjustment-increase' ) {
            return Stock ::ByBranch () -> with ( [
                                                     'vendor',
                                                     'customer'
                                                 ] ) -> where ( [ 'stock_type' => $type ] ) -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save stocks
         * --------------
         */
        public function save ( $request ) {
            return Stock ::create ( [
                                        'user_id'     => auth () -> user () -> id,
                                        'vendor_id'   => $request -> has ( 'vendor-id' ) ? $request -> input ( 'vendor-id' ) : null,
                                        'customer_id' => $request -> has ( 'customer-id' ) ? $request -> input ( 'customer-id' ) : null,
                                        'branch_id'   => $request -> input ( 'branch-id' ),
                                        'invoice_no'  => $request -> input ( 'invoice-no' ),
                                        'type'        => 'product',
                                        'stock_date'  => Carbon ::createFromFormat ( 'Y-m-d', $request -> input ( 'stock-date' ) ),
                                        'discount'    => $request -> input ( 'net-discount', 0 ),
                                        'total'       => $request -> input ( 'grand-total', 0 ),
                                        'stock_type'  => 'adjustment-increase',
                                        'description' => $request -> has ( 'description' ) ? $request -> input ( 'description' ) : null
                                    ] );
        }
        
        /**
         * --------------
         * @param $stock_id
         * @param $request
         * @return void
         * save product stock
         * --------------
         */
        
        public function save_stock_products ( $stock_id, $request ) {
            $products = $request -> input ( 'product' );
            if ( count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    $info = array (
                        'product_id'  => $product_id,
                        'stock_id'    => $stock_id,
                        'branch_id'   => $request -> input ( 'branch-id' ),
                        'batch_no'    => $request -> input ( 'invoice-no' ) . '-' . ( new GeneralHelper ) -> generateRandomString (),
                        'expiry_date' => Carbon ::now () -> addYears ( 10 ),
                        'box_qty'     => $request -> input ( 'box-qty.' . $key ),
                        'pack_size'   => $request -> input ( 'pack-size.' . $key ),
                        'quantity'    => $request -> input ( 'quantity.' . $key ),
                        'tp_box'      => $request -> input ( 'tp-box.' . $key ),
                        'stock_price' => $request -> input ( 'stock-price.' . $key ),
                        'discount'    => $request -> input ( 'discount.' . $key ),
                        'sale_tax'    => $request -> input ( 'sales-tax.' . $key ),
                        'net_price'   => $request -> input ( 'net-price.' . $key ),
                        'cost_box'    => $request -> input ( 'cost-box.' . $key ),
                        'tp_unit'     => $request -> input ( 'tp-unit.' . $key ),
                        'sale_box'    => $request -> input ( 'sale-box.' . $key ),
                        'sale_unit'   => $request -> input ( 'sale-unit.' . $key ),
                    );
                    ProductStock ::create ( $info );
                }
            }
        }
        
        /**
         * --------------
         * @param $request
         * @param $stock
         * @return void
         * update stocks
         * --------------
         */
        
        public function edit ( $request, $stock ) {
            $stock -> user_id    = auth () -> user () -> id;
            $stock -> discount   = $request -> input ( 'net-discount' );
            $stock -> total      = $this -> sum_net_price ();
            $stock -> return_net = 0;
            $stock -> update ();
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * update product stock
         * --------------
         */
        
        public function update_stock_products ( $request ) {
            $stocks = $request -> input ( 'stocks' );
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $key => $stock_id ) {
                    if ( is_numeric ( $stock_id ) and $stock_id > 0 ) {
                        $stock = ProductStock ::find ( $stock_id );
                        if ( $stock ) {
                            $stock -> box_qty     = $request -> input ( 'box-qty.' . $key );
                            $stock -> pack_size   = $request -> input ( 'pack-size.' . $key );
                            $stock -> quantity    = $request -> input ( 'quantity.' . $key );
                            $stock -> tp_box      = $request -> input ( 'tp-box.' . $key );
                            $stock -> stock_price = $request -> input ( 'stock-price.' . $key );
                            $stock -> discount    = $request -> input ( 'discount.' . $key );
                            $stock -> sale_tax    = $request -> input ( 'sales-tax.' . $key );
                            $stock -> net_price   = $request -> input ( 'net-price.' . $key );
                            $stock -> cost_box    = $request -> input ( 'cost-box.' . $key );
                            $stock -> tp_unit     = $request -> input ( 'tp-unit.' . $key );
                            $stock -> sale_box    = $request -> input ( 'sale-box.' . $key );
                            $stock -> sale_unit   = $request -> input ( 'sale-unit.' . $key );
                            
                            if ( $request -> has ( 'return-unit' ) && count ( $request -> input ( 'return-unit' ) ) && $request -> has ( 'sale-unit.' . $key ) )
                                $stock -> return_unit = $request -> input ( 'return-unit.' . $key );
                            
                            $stock -> update ();
                        }
                    }
                }
            }
        }
        
        /**
         * --------------
         * @return int|mixed
         * sum total stock price
         * --------------
         */
        
        public function sum_net_price () {
            $total = 0;
            if ( count ( request ( 'net-price' ) ) > 0 ) {
                $net = request ( 'net-price' );
                foreach ( $net as $price ) {
                    $total += $price;
                }
            }
            return $total;
        }
        
        /**
         * --------------
         * @return int|mixed
         * sum total stock return price
         * --------------
         */
        
        public function sum_return_net_price () {
            $total = 0;
            if ( request () -> has ( 'return-unit' ) && count ( request ( 'return-unit' ) ) > 0 ) {
                $net      = request ( 'return-unit' );
                $quantity = request ( 'quantity' );
                foreach ( $net as $key => $price ) {
                    $total += ( $price * $quantity[ $key ] );
                }
            }
            return $total;
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * add adjustment decrease
         * --------------
         */
        
        public function add_adjustment_decrease ( $request ) {
            $total = ( new StockReturnService() ) -> get_return_total ( $request );
            $info  = array (
                'user_id'      => auth () -> user () -> id,
                'reference_no' => $request -> input ( 'reference-no' ),
                'net_price'    => $total,
                'type'         => 'adjustment-decrease',
                'description'  => $request -> input ( 'description' ),
            );
            
            return StockReturn ::create ( $info );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * add damage stock
         * --------------
         */
        
        public function add_damage_stock ( $request ) {
            $total = ( new StockReturnService() ) -> get_return_total ( $request );
            $info  = array (
                'user_id'      => auth () -> user () -> id,
                'reference_no' => $request -> input ( 'reference-no' ),
                'net_price'    => $total,
                'type'         => 'damage-loss-stock',
                'description'  => $request -> input ( 'description' ),
            );
            
            return StockReturn ::create ( $info );
        }
    }
