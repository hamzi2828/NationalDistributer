<?php
    
    namespace App\Http\Services;
    
    use App\Models\Attribute;
    use App\Models\StockTake;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Str;
    
    class StockTakeService {
        
        public function all () {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            return StockTake ::selectRaw ( 'GROUP_CONCAT(product_id) as products, GROUP_CONCAT(available_qty) as available_quantities, GROUP_CONCAT(live_qty) as live_quantities, uuid, created_at' )
                -> groupBy ( 'uuid' )
                -> orderBy ( 'created_at', 'DESC' )
                -> get ();
        }
        
        public function save ( $request ) {
            if ( $request -> has ( 'product-id' ) && count ( $request -> input ( 'product-id' ) ) > 0 ) {
                $products  = $request -> input ( 'product-id' );
                $available = $request -> input ( 'available-quantity' );
                $live      = $request -> input ( 'live-quantity' );
                $uuid      = Str ::uuid ();
                
                foreach ( $products as $key => $product_id ) {
                    StockTake ::create ( [
                                             'user_id'       => auth () -> user () -> id,
                                             'product_id'    => $product_id,
                                             'uuid'          => $uuid,
                                             'available_qty' => $available[ $key ],
                                             'live_qty'      => $live[ $key ],
                                         ] );
                }
                return $uuid;
            }
        }
        
        public function get_stock_take_by_uuid ( $uuid ) {
            $attribute = Attribute ::select ( [ 'id', 'title' ] )
                -> whereHas ( 'terms.product_terms.stock_takes', function ( $query ) use ( $uuid ) {
                    $query -> where ( 'stock_takes.uuid', $uuid );
                } )
                -> with ( [ 'terms' => function ( $query ) use ( $uuid ) {
                    $query -> orderBy ( 'terms.title', 'ASC' )
                        -> whereHas ( 'product_terms.stock_takes', function ( $query ) use ( $uuid ) {
                            $query -> where ( 'stock_takes.uuid', $uuid );
                        } )
                        -> with ( [ 'product_terms.stock_takes' => function ( $query ) use ( $uuid ) {
                            $query -> where ( 'stock_takes.uuid', $uuid );
                        } ] );
                } ] )
                -> has ( 'terms.product_terms.stock_takes.product' );
            
            return $attribute -> groupBy ( 'attributes.id', 'attributes.title' ) -> get ();
        }
        
        public function edit ( $request ) {
            if ( $request -> has ( 'stock-take-id' ) && count ( $request -> input ( 'stock-take-id' ) ) > 0 ) {
                $stock_takes = $request -> input ( 'stock-take-id' );
                $live        = $request -> input ( 'live-quantity' );
                
                foreach ( $stock_takes as $key => $stock_take_id ) {
                    $stock_take = StockTake ::find ( $stock_take_id );
                    
                    $stock_take -> live_qty = $live[ $key ];
                    $stock_take -> update ();
                }
            }
        }
        
        public function delete ( $stockTake ) {
            StockTake ::where ( [ 'uuid' => $stockTake -> uuid ] ) -> delete ();
        }
        
        public function get_simple_stock_take_by_uuid ( $uuid ) {
            $stocks = StockTake ::with ( [ 'product' ] )
                -> whereIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'products' ) -> where ( [ 'product_type' => 'simple' ] );
                } )
                -> where ( [ 'uuid' => $uuid ] );
            return $stocks -> get ();
        }
        
    }
