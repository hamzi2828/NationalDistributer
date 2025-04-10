<?php
    
    namespace App\Http\Services;
    
    use App\Http\Helpers\GeneralHelper;
    use App\Models\Attribute;
    use App\Models\CustomerProductPrice;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\Stock;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    
    class StockService {
        /**
         * --------------
         * @return mixed
         * get all stocks
         * --------------
         */
        
        public function all ( $type = 'vendor' ) {
            return Stock ::ByBranch () -> with ( [
                                                     'vendor',
                                                     'customer',
                                                     'branch',
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
            $return_net = $this -> sum_return_net_price ();
            $return_net = $return_net - ( $return_net * ( $request -> input ( 'net-discount' ) / 100 ) );
            $return_net = $return_net - $request -> input ( 'flat-return-discount' );
            
            return Stock ::create ( [
                                        'user_id'       => auth () -> user () -> id,
                                        'vendor_id'     => $request -> has ( 'vendor-id' ) ? $request -> input ( 'vendor-id' ) : null,
                                        'customer_id'   => $request -> has ( 'customer-id' ) ? $request -> input ( 'customer-id' ) : null,
                                        'branch_id'     => $request -> input ( 'branch-id' ),
                                        'invoice_no'    => $request -> input ( 'invoice-no' ),
                                        'type'          => 'product',
                                        'stock_date'    => Carbon ::createFromFormat ( 'Y-m-d', $request -> input ( 'stock-date' ) ),
                                        'discount'      => $request -> input ( 'net-discount' ),
                                        'flat_discount' => $request -> input ( 'flat-return-discount' ),
                                        'total'         => $request -> input ( 'grand-total' ),
                                        'return_net'    => $return_net,
                                        'stock_type'    => $request -> has ( 'customer-id' ) ? 'customer-return' : 'vendor',
                                        'description'   => $request -> has ( 'description' ) ? $request -> input ( 'description' ) : null
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
            $products = $request -> input ( 'product', [] );
            if ( count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    if ( is_numeric ( $product_id ) and $product_id > 0 ) {
                        $product = Product ::find ( $product_id );
                        if ( $product ) {
                            
                            $customer_price = $request -> input ( 'return-unit.' . $key );
                            
                            $customerProductPrice = CustomerProductPrice ::where ( [ 'customer_id' => $request -> input ( 'customer-id' ), 'product_id' => $product_id ] ) -> first ();
                            
                            if ( !empty( $customerProductPrice ) )
                                $customer_price = $customerProductPrice -> price;
                            
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
                                'return_unit' => $customer_price,
                            );
                            ProductStock ::create ( $info );
                        }
                    }
                }
            }
        }
        
        public function add_more_stock_products ( $stock, $request ) {
            $products = $request -> input ( 'product' );
            if ( count ( $products ) > 0 ) {
                foreach ( $products as $product_id ) {
                    if ( is_numeric ( $product_id ) and $product_id > 0 ) {
                        $product = Product ::find ( $product_id );
                        if ( $product ) {
                            
                            $customer_price = 0;
                            
                            $customerProductPrice = CustomerProductPrice ::where ( [ 'customer_id' => $stock -> customer_id, 'product_id' => $product_id ] ) -> first ();
                            
                            if ( !empty( $customerProductPrice ) )
                                $customer_price = $customerProductPrice -> price;
                            
                            $info = array (
                                'product_id'  => $product_id,
                                'stock_id'    => $stock -> id,
                                'branch_id'   => $stock -> branch_id,
                                'batch_no'    => $stock -> invoice_no,
                                'expiry_date' => Carbon ::now () -> addYears ( 10 ),
                                'box_qty'     => '0',
                                'pack_size'   => $product -> pack_size,
                                'quantity'    => '0',
                                'tp_box'      => $product -> tp_box,
                                'stock_price' => '0',
                                'discount'    => '0',
                                'sale_tax'    => '0',
                                'net_price'   => '0',
                                'cost_box'    => '0',
                                'tp_unit'     => $product -> tp_unit,
                                'sale_box'    => $product -> sale_box,
                                'sale_unit'   => $product -> sale_unit,
                                'return_unit' => $customer_price,
                            );
                            ProductStock ::create ( $info );
                        }
                    }
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
            $stock -> user_id       = auth () -> user () -> id;
            $stock -> branch_id     = $request -> input ( 'branch-id' );
            $stock -> invoice_no    = $request -> input ( 'invoice-no' );
            $stock -> stock_date    = Carbon ::createFromFormat ( 'Y-m-d', $request -> input ( 'stock-date' ) );
            $stock -> discount      = $request -> input ( 'net-discount' );
            $stock -> flat_discount = $request -> input ( 'flat-net-discount', 0 );
            $stock -> total         = $this -> sum_net_price ();
            $stock -> return_net    = $this -> sum_return_net_price ();
            
            if ( $stock -> stock_type === 'customer-return' ) {
                $return_net          = $this -> sum_return_net_price ();
                $return_net          = $return_net - $request -> input ( 'flat-net-discount', 0 );
                $stock -> return_net = $return_net - ( $return_net * ( $request -> input ( 'net-discount' ) / 100 ) );
            }
            
            $stock -> update ();
        }
        
        /**
         * --------------
         * @param $stock_id
         * @param $request
         * @return void
         * update product stock
         * --------------
         */
        
        public function update_stock_products ( $request ) {
            $stocks    = $request -> input ( 'stocks' );
            $branch_id = $request -> input ( 'branch-id' );
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $key => $stock_id ) {
                    if ( is_numeric ( $stock_id ) and $stock_id > 0 ) {
                        $stock = ProductStock ::find ( $stock_id );
                        if ( $stock ) {
                            $stock -> branch_id   = $branch_id;
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
         * @param $request
         * @return bool
         * validate invoice no
         * --------------
         */
        
        public function validate_invoice_no ( $request ) {
            
            if ( $request -> has ( 'adjustment' ) && $request -> input ( 'adjustment' ) == 'true' ) {
                $rows = Stock ::where ( [ 'invoice_no' => $request -> input ( 'invoice_no' ) ] ) -> count ();
                if ( $rows > 0 )
                    return true;
                else
                    return false;
            }
            else {
                $rows = Stock ::where ( [
                                            'vendor_id'  => $request -> input ( 'vendor_id' ),
                                            'invoice_no' => $request -> input ( 'invoice_no' )
                                        ] ) -> count ();
                if ( $rows > 0 )
                    return true;
                else
                    return false;
            }
        }
        
        /**
         * --------------
         * @param $productStock
         * @return mixed
         * delete stock product
         * --------------
         */
        
        public function delete_stock_product ( $productStock ) {
            return $productStock -> delete ();
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
        
        public function return_customer_stock_total () {
            $quantity = request ( 'quantity' );
            $return   = request ( 'return-unit' );
            $sum      = 0;
            
            if ( count ( $return ) > 0 ) {
                foreach ( $return as $key => $price ) {
                    $sum += ( $quantity[ $key ] * $price );
                }
            }
            return $sum;
        }
        
        public function get_stock_attribute_wise ( $stock ) {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            return DB ::table ( 'attributes' )
                -> select ( [ 'attributes.id', 'attributes.title', DB ::raw ( 'GROUP_CONCAT(ims_product_stock.id) as id' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.product_id) as products' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.quantity) as quantities' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.stock_price) as stock_prices' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.net_price) as net_prices' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.tp_unit) as tp_units' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.sale_unit) as sale_units' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.discount) as discounts' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.sale_tax) as sale_taxes' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.box_qty) as box_qty' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.pack_size) as pack_size' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.tp_box) as tp_box' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.cost_box) as cost_box' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.sale_box) as sale_box' ), DB ::raw ( 'GROUP_CONCAT(ims_product_stock.return_unit) as return_unit' ) ] )
                -> join ( 'terms', 'attributes.id', '=', 'terms.attribute_id' )
                -> join ( 'product_terms', 'terms.id', '=', 'product_terms.term_id' )
                -> join ( 'product_stock', 'product_terms.product_id', '=', 'product_stock.product_id' )
                // -> where ( [ 'product_stock.stock_id' => $stock -> id ] )
                -> where ( [ 'product_stock.stock_id' => $stock -> id, 'product_stock.branch_id' => auth()->user()->branch_id ] )
                -> whereNull ( 'product_stock.deleted_at' )
                -> groupBy ( [ 'attributes.id' ] )
                -> get ();
        }
        
        public function get_simple_stock ( $stock ) {
            return $stock -> load ( [ 'products.product', 'products' => function ( $query ) {
                $query -> whereNotIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'product_id' ) -> from ( 'product_terms' );
                } );
            } ] );
        }
        
        public function calculate_stock_return_total ( $stock ) {
            $stock -> load ( [ 'products' ] );
            $totalReturnPrice = 0;
            
            if ( count ( $stock -> products ) > 0 ) {
                foreach ( $stock -> products as $key => $product ) {
                    if ( $product ) {
                        $customer_price   = ( $product -> return_unit * $product -> quantity );
                        $totalReturnPrice += $customer_price;
                    }
                }
                return $totalReturnPrice;
            }
        }
    }
