<?php
    
    namespace App\Http\Services;
    
    use App\Http\Helpers\GeneralHelper;
    use App\Models\Issuance;
    use App\Models\IssuedProducts;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\SaleProducts;
    use App\Models\Stock;
    use Illuminate\Support\Carbon;
    
    class IssuanceService {
        
        /**
         * --------------
         * @return mixed
         * get all issuance
         * --------------
         */
        
        public function all () {
            $issuances = Issuance ::with ( [ 'issuance_from_branch', 'issuance_to_branch', 'products.product' ] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 )
                $issuances -> where ( [ 'to_branch' => auth () -> user () -> branch_id ] );
            
            return $issuances -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save issuance
         * --------------
         */
        
        public function save ( $request ) {
            return Issuance ::create ( [
                                           'user_id'     => auth () -> user () -> id,
                                           'from_branch' => $request -> input ( 'from-branch-id' ),
                                           'to_branch'   => $request -> input ( 'to-branch-id' )
                                       ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $issuance_id
         * @return void
         * issue products
         * --------------
         */
        
        public function issue_products ( $request, $issuance_id ): void {
            $products = $request -> input ( 'products' );
            if ( count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    $product = Product ::findorFail ( $product_id );
                    $product -> load ( 'stocks' );
                    
                    $sale_qty = $request -> input ( 'quantity.' . $key );
                    if ( count ( $product -> stocks ) > 0 ) {
                        foreach ( $product -> stocks as $stock ) {
                            
                            if ( $sale_qty > 0 ) {
                                //                                $quantity = $stock -> quantity;
                                //                                $soldQuantity = $stock -> sold_quantity ();
                                //                                $available_qty = $quantity - $soldQuantity;
                                $available_qty = $stock -> available ();
                                
                                if ( $available_qty > 0 ) {
                                    if ( $available_qty >= $sale_qty ) {
                                        $sale[ 'available_qty' ] = $available_qty;
                                        $sale[ 'sale_qty' ]      = $sale_qty;
                                        $sale[ 'remaining_qty' ] = $available_qty - $sale_qty;
                                        $sale_qty                = 0;
                                    }
                                    else {
                                        $sale[ 'available_qty' ] = $available_qty;
                                        $sale[ 'sale_qty' ]      = $sale_qty - $available_qty;
                                        $sale[ 'remaining_qty' ] = $sale_qty - $available_qty;
                                        $sale[ 'sale_qty' ]      = $sale_qty - $sale[ 'remaining_qty' ];
                                        $sale_qty                -= $available_qty;
                                    }
                                    $info = array (
                                        'issuance_id' => $issuance_id,
                                        'product_id'  => $product_id,
                                        'stock_id'    => $stock -> id,
                                        'quantity'    => $sale[ 'sale_qty' ],
                                    );
                                    IssuedProducts ::create ( $info );
                                }
                            }
                        }
                    }
                }
            }
        }
        
        /**
         * --------------
         * @param $issuance
         * @return void
         * received issuance
         * --------------
         */
        
        public function received ( $issuance ) {
            $issuance -> received = '1';
            $issuance -> update ();
        }
        
        /**
         * --------------
         * @param $issuance
         * @return void
         * move issued products into stock
         * --------------
         */
        
        public function move_issuance_to_branch ( $issuance ) {
            $issuance -> load ( 'issued_products.product_stock.stock' );
            if ( count ( $issuance -> issued_products ) > 0 ) {
                foreach ( $issuance -> issued_products as $issued_product ) {
                    $product = Product ::find ( $issued_product -> product_id );
                    $info    = array (
                        'product_id'  => $issued_product -> product_id,
                        'stock_id'    => $issued_product -> product_stock -> stock_id,
                        'branch_id'   => $issuance -> to_branch,
                        'batch_no'    => $issued_product -> product_stock -> stock -> invoice_no . '-' . ( new GeneralHelper ) -> generateRandomString (),
                        'expiry_date' => Carbon ::now () -> addYears ( 10 ),
                        'box_qty'     => $issued_product -> product_stock -> box_qty,
                        'pack_size'   => $product -> pack_size,
                        'quantity'    => $issued_product -> quantity,
                        'tp_box'      => $product -> tp_box,
                        'stock_price' => ( $issued_product -> quantity * $issued_product -> product_stock -> tp_box ),
                        'discount'    => '0',
                        'sale_tax'    => '0',
                        'net_price'   => ( $issued_product -> quantity * $issued_product -> product_stock -> tp_box ),
                        'cost_box'    => $issued_product -> product_stock -> tp_unit,
                        'tp_unit'     => $issued_product -> product_stock -> tp_unit,
                        'sale_box'    => $issued_product -> product_stock -> sale_box,
                        'sale_unit'   => $issued_product -> product_stock -> sale_unit,
                        'transfer'    => '1'
                    );
                    ProductStock ::create ( $info );
                }
            }
            
        }
        
        /**
         * --------------
         * @param $issuance_id
         * @return void
         * delete issued products
         * --------------
         */
        
        public function delete_issued_products ( $issuance_id ) {
            IssuedProducts ::where ( [ 'issuance_id' => $issuance_id ] ) -> delete ();
        }
    }