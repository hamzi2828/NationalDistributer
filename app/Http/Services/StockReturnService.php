<?php
    
    namespace App\Http\Services;
    
    use App\Models\Product;
    use App\Models\StockReturn;
    use App\Models\StockReturnProduct;
    
    class StockReturnService {
        
        /**
         * --------------
         * @return mixed
         * get all stock returns
         * --------------
         */
        
        public function all ( $type = 'vendor-return' ): mixed {
            $returns = StockReturn ::with ( [ 'products.product' ] ) -> where ( [ 'type' => $type ] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 )
                $returns -> where ( [ 'user_id' => auth () -> user () -> id ] );
            
            return $returns -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $product_id
         * @param $sale_qty
         * @return float[]|int[]
         * get stock tp/unit
         * --------------
         */
        
        public function get_price ( $product_id, $sale_qty ): array {
            $product = Product ::findorFail ( $product_id );
            $product -> load ( [
                                   'stocks'
                               ] );
            $info     = array ();
            $price    = 0;
            $netPrice = 0;
            if ( count ( $product -> stocks ) > 0 ) {
                foreach ( $product -> stocks as $stock ) {
                    if ( $sale_qty > 0 ) {
                        
                        $tp_unit       = $stock -> tp_unit;
                        $available_qty = $stock -> available ();
                        
                        if ( $available_qty > 0 ) {
                            $sale[ 'stock_id' ] = $stock -> id;
                            $sale[ 'tp_unit' ]  = $tp_unit;
                            
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
                            array_push ( $info, $sale );
                        }
                    }
                }
            }
            
            if ( count ( $info ) > 0 ) {
                foreach ( $info as $item ) {
                    $tp_unit  = $item[ 'tp_unit' ];
                    $sale_qty = $item[ 'sale_qty' ];
                    $price    = $price + $tp_unit;
                    $netPrice += ( $sale_qty * $tp_unit );
                }
            }
            return [
                'price'     => $price / count ( $info ),
                'net_price' => $netPrice,
            ];
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * create sale
         * store data in sales table
         * --------------
         */
        
        public function stock_return ( $request ): mixed {

//            $total = $this -> get_return_total ( $request );
            $total = $request -> input ( 'total-vendor-return' );
            $info  = array (
                'user_id'      => auth () -> user () -> id,
                'vendor_id'    => $request -> input ( 'vendor-id' ),
                'reference_no' => $request -> input ( 'reference-no' ),
                'net_price'    => $total,
                'discount'     => $request -> input ( 'discount', 0 ),
                'price'        => ( $total - $request -> input ( 'discount', 0 ) ),
                'description'  => $request -> input ( 'description' ),
            );
            
            return StockReturn ::create ( $info );
            
        }
        
        /**
         * --------------
         * @param $request
         * @param $return_id
         * @return void
         * return products
         * --------------
         */
        
        public function return_products ( $request, $return_id ): void {
            $products = $request -> input ( 'products' );
            
            if ( count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    $product_price = $request -> input ( 'tp_unit.' . $key );
                    $product       = Product ::findorFail ( $product_id );
                    $product -> load ( [
                                           'stocks',
                                           'customer_price'
                                       ] );
                    
                    $sale_qty = $request -> input ( 'quantity.' . $key );
                    if ( count ( $product -> stocks ) > 0 ) {
                        foreach ( $product -> stocks as $stock ) {
                            if ( $sale_qty > 0 ) {

//                                $tp_unit       = $stock -> tp_unit;
                                $tp_unit       = $product_price;
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
                                        'stock_return_id' => $return_id,
                                        'product_id'      => $product_id,
                                        'stock_id'        => $stock -> id,
                                        'quantity'        => $sale[ 'sale_qty' ],
                                        'tp_unit'         => $tp_unit,
                                        'price'           => ( $sale[ 'sale_qty' ] * $tp_unit ),
                                    );
                                    StockReturnProduct ::create ( $info );
                                }
                            }
                        }
                    }
                }
            }
        }
        
        /**
         * --------------
         * @param $request
         * @return float|int
         * get sales total price
         * --------------
         */
        
        public function get_return_total ( $request ): float | int {
            
            $products = $request -> input ( 'products' );
            $info     = array ();
            $netPrice = 0;
            
            if ( count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    $product = Product ::findorFail ( $product_id );
                    $product -> load ( [
                                           'stocks',
                                           'customer_price'
                                       ] );
                    
                    $sale_qty = $request -> input ( 'quantity.' . $key );
                    if ( count ( $product -> stocks ) > 0 ) {
                        foreach ( $product -> stocks as $stock ) {
                            if ( $sale_qty > 0 ) {
                                
                                $tp_unit = $stock -> tp_unit;
                                
                                $available_qty = $stock -> available ();
                                
                                if ( $available_qty > 0 ) {
                                    $sale[ 'stock_id' ] = $stock -> id;
                                    $sale[ 'tp_unit' ]  = $tp_unit;
                                    
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
                                    array_push ( $info, $sale );
                                    
                                }
                            }
                        }
                    }
                }
            }
            
            if ( count ( $info ) > 0 ) {
                foreach ( $info as $item ) {
                    $tp_unit  = $item[ 'tp_unit' ];
                    $sale_qty = $item[ 'sale_qty' ];
                    $netPrice += ( $sale_qty * $tp_unit );
                }
            }
            return $netPrice;
        }
        
        public function sum_total_stock_return_value (): float | int {
            $products = request ( 'products' );
            $quantity = request ( 'quantity' );
            $tp_unit  = request ( 'tp_unit' );
            $sum      = 0;
            
            if ( isset( $products ) && count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    if ( $product_id > 0 ) {
                        $sum += ( $quantity[ $key ] * $tp_unit[ $key ] );
                    }
                }
            }
            return $sum;
        }
        
        public function update_returns ( $stockReturn ) {
            $netPrice                    = $this -> sum_total_stock_return_value ();
            $stockReturn -> reference_no = request ( 'reference-no' );
            $stockReturn -> description  = request ( 'description' );
            $stockReturn -> net_price    = $this -> sum_total_stock_return_value ();
            $stockReturn -> discount     = request ( 'discount', 0 );
            $stockReturn -> price        = $netPrice - request ( 'discount', 0 );
            $stockReturn -> update ();
        }
        
        public function delete_returned_products ( $return_stock_id ) {
            StockReturnProduct ::where ( [ 'stock_return_id' => $return_stock_id ] ) -> delete ();
        }
        
        public function delete_returns ( $stockReturn ) {
            
            $stockReturn -> load ( 'products', 'ledgers' );
            
            if ( count ( $stockReturn -> products ) > 0 ) {
                foreach ( $stockReturn -> products as $stock ) {
                    $stock -> delete ();
                }
            }
            
            if ( count ( $stockReturn -> ledgers ) > 0 ) {
                foreach ( $stockReturn -> ledgers as $ledgers ) {
                    $ledgers -> delete ();
                }
            }
            
            $stockReturn -> delete ();
        }
        
    }
