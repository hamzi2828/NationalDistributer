<?php
    
    namespace App\Http\Services;
    
    use App\Models\Account;
    use App\Models\Attribute;
    use App\Models\Category;
    use App\Models\FinancialYear;
    use App\Models\GeneralLedger;
    use App\Models\Product;
    use App\Models\Sale;
    use App\Models\SaleProducts;
    use App\Models\Stock;
    use App\Models\StockReturn;
    use App\Models\User;
    use Illuminate\Support\Facades\DB;
    
    class ReportingService {
        
        public bool $search = false;
        
        /**
         * --------------
         * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         * get sales
         * apply filters
         * --------------
         */
        
        public function filter_sales () {
            
            $search = false;
            $refundedStatus = 0; 
            $is_online = 0;
        
            // Check if 'refunded' is provided in the request and update $refundedStatus accordingly
            if (request()->filled('refunded')) {
                $refundedStatus = request('refunded');
            }
            if (request()->filled('is_online')) {
                $is_online = request('is_online');
            }
        
            $query = SaleProducts::query()->select('sale_id')->whereIn('sale_id', function ($model) use ($refundedStatus, $is_online){
                $model->select('id')->from('sales')->where([
                    'sale_closed' => '1',
                    'is_online' => $is_online,
                    'refunded' => $refundedStatus
                ])->whereNull('deleted_at');
            });
            
            if ( request () -> filled ( 'product-id' ) ) {
                $query -> where ( [ 'product_id' => request () -> input ( 'product-id' ) ] );
                $search = true;
            }
            
            if ( request () -> filled ( 'customer-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $model ) {
                    $model -> select ( 'id' ) -> from ( 'sales' ) -> where ( [ 'customer_id' => request ( 'customer-id' ), ] );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'attribute-id' ) ) {
                $query -> whereIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'product_id' ) -> from ( 'product_terms' ) -> whereIn ( 'term_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'terms' ) -> whereIn ( 'attribute_id', request () -> input ( 'attribute-id' ) );
                    } );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'user-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [ 'user_id' => request ( 'user-id' ) ] );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> whereIn ( 'user_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => request ( 'branch-id' ) ] );
                    } );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request () -> input ( 'end-date' ) ) );
                
                $query -> whereIn ( 'sale_id', function ( $model ) use ( $start_date, $end_date ) {
                    $model -> select ( 'id' ) -> from ( 'sales' ) -> whereRaw ( "DATE(closed_at) BETWEEN '$start_date' AND '$end_date'" );
                } );
                $search = true;
            }

            // if (request()->filled('refunded')) {
            //     $refundedStatus = request('refunded'); // Get the refunded status from the request (could be 1 or 0)
            //     $query->whereIn('sale_id', function ($query) use ($refundedStatus) {
            //         $query->select('id')->from('sales')->where('refunded', 1);
            //     });
            //     $search = true;
            // }
            
            
            
            if ( $search )
                return $query -> groupBy ( 'sale_id' ) -> with ( [
                                                                     'sale.customer'
                                                                 ] ) -> latest () -> get ();
            else
                return [];
        }
        
        /**
         * --------------
         * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         * get sales
         * apply filters
         * --------------
         */
        
        public function profit_report () {
            
            $search = false;
            $query  = SaleProducts ::query () -> select ( 'sale_id' ) -> selectRaw ( 'GROUP_CONCAT(product_id) as products, GROUP_CONCAT(stock_id) as stocks, GROUP_CONCAT(quantity) as quantities' ) -> whereIn ( 'sale_id', function ( $model ) {
                $model -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'deleted_at'  => null,
                                                                             'refunded'    => '0',
                                                                             'sale_closed' => '1'
                                                                         ] );
            } );
            
            if ( request () -> filled ( 'customer-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $model ) {
                    $model -> select ( 'id' ) -> from ( 'sales' ) -> where ( [ 'customer_id' => request ( 'customer-id' ), ] );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'product-id' ) ) {
                $query -> where ( [ 'product_id' => request () -> input ( 'product-id' ) ] );
                $search = true;
            }
            
            if ( request () -> filled ( 'attribute-id' ) ) {
                $query -> whereIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'product_id' ) -> from ( 'product_terms' ) -> whereIn ( 'term_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'terms' ) -> where ( [ 'attribute_id' => request () -> input ( 'attribute-id' ) ] );
                    } );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'user-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [ 'user_id' => request ( 'user-id' ) ] );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> whereIn ( 'user_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => request ( 'branch-id' ) ] );
                    } );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'category-id' ) ) {
                $query -> whereIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'products' ) -> where ( [ 'category_id' => request ( 'category-id' ) ] );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request () -> input ( 'end-date' ) ) );
                
                $query -> whereRaw ( "DATE(created_at) BETWEEN '$start_date' AND '$end_date'" );
                $search = true;
            }
            
            if ( $search )
                return $query -> groupBy ( 'sale_id' ) -> with ( [
                                                                     'sale.customer'
                                                                 ] ) -> latest () -> get ();
            else
                return [];
        }
        
        /**
         * --------------
         * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         * get sales
         * apply filters
         * --------------
         */
        
        public function refund_report () {
            
            $search = false;
            $query  = SaleProducts ::query () -> select ( 'sale_id' ) -> selectRaw ( 'GROUP_CONCAT(product_id) as products, GROUP_CONCAT(stock_id) as stocks' ) -> whereIn ( 'sale_id', function ( $model ) {
                $model -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'deleted_at' => null,
                                                                             'refunded'   => '1'
                                                                         ] );
            } );
            
            if ( request () -> filled ( 'product-id' ) ) {
                $query -> where ( [ 'product_id' => request () -> input ( 'product-id' ) ] );
                $search = true;
            }
            
            if ( request () -> filled ( 'attribute-id' ) ) {
                $query -> whereIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'product_id' ) -> from ( 'product_terms' ) -> whereIn ( 'term_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'terms' ) -> where ( [ 'attribute_id' => request () -> input ( 'attribute-id' ) ] );
                    } );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'user-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [ 'user_id' => request ( 'user-id' ) ] );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $query -> whereIn ( 'sale_id', function ( $query ) {
                    $query -> select ( 'id' ) -> from ( 'sales' ) -> whereIn ( 'user_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => request ( 'branch-id' ) ] );
                    } );
                } );
                $search = true;
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request () -> input ( 'end-date' ) ) );
                
                $query -> whereRaw ( "DATE(created_at) BETWEEN '$start_date' AND '$end_date'" );
                $search = true;
            }
            
            if ( $search )
                return $query -> groupBy ( 'sale_id' ) -> with ( [
                                                                     'sale.customer'
                                                                 ] ) -> latest () -> get ();
            else
                return [];
        }
        
        /**
         * --------------
         * @return array
         * search transactions
         * --------------
         */
        
        public function search_transactions () {
            if ( request () -> has ( 'voucher-no' ) && request () -> filled ( 'voucher-no' ) ) {
                $voucher_no = request () -> input ( 'voucher-no' );
                return GeneralLedger ::where ( [ 'voucher_no' => $voucher_no ] )
                    -> with ( [ 'account_head' ] )
                    -> orderBy ( 'debit', 'DESC' )
                    -> get ();
            }
            return [];
        }
        
        /**
         * --------------
         * @return array
         * stock valuation report
         * --------------
         */
        
        public function stock_valuation_report () {
            $products = Product ::withWhereHas ( 'all_stocks', function ( $query ) {
                
                if ( request () -> filled ( 'branch-id' ) ) {
                    $query -> where ( 'branch_id', '=', request ( 'branch-id' ) );
                    $this -> search = true;
                }
                
                if ( request () -> filled ( 'attribute-id' ) ) {
                    $query -> whereIn ( 'product_id', function ( $query ) {
                        $query -> select ( 'product_id' ) -> from ( 'product_terms' ) -> whereIn ( 'term_id', function ( $query ) {
                            $query -> select ( 'id' ) -> from ( 'terms' ) -> where ( [ 'attribute_id' => request ( 'attribute-id' ) ] );
                        } );
                    } );
                    $this -> search = true;
                }
                
                if ( request () -> filled ( 'vendor-id' ) ) {
                    $query -> whereIn ( 'stock_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'stocks' ) -> where ( [ 'vendor_id' => request ( 'vendor-id' ) ] );
                    } );
                    $this -> search = true;
                }
                
                if ( request () -> filled ( 'category-id' ) ) {
                    $query -> whereIn ( 'product_id', function ( $query ) {
                        $query -> select ( 'id' ) -> from ( 'products' ) -> where ( [ 'category_id' => request ( 'category-id' ) ] );
                    } );
                    $this -> search = true;
                }
            } ) -> get ();
            
            if ( $this -> search )
                return $products;
            else
                return [];
        }

        public function stock_statement_report() {
            // Eager load all stocks and their associated branch details without any filtering
            // $products = Product::with(['all_stocks.branch'])
            //     ->get();
                    $products = Product::with(['all_stocks.branch'])
                    ->whereHas('all_stocks', function($query) {
                        $query->whereBetween('branch_id', [1, 100]);
                    })->get();
            
        
            return $products;
        }
        
        public function stock_movement_report() {
            $startDate = request('start_date');
            $endDate = request('end_date');
            $initialDate = '2016-01-01';

            if (!$startDate || !$endDate) {
                // Return an empty collection for both current and old products if the dates are not provided
                return [
                    'current_products' => collect(), // Return an empty collection
                    'old_products' => collect() // Return an empty collection
                ];
            }
            
        

            $products = Product::with(['all_stocks.branch'])
            ->whereHas('all_stocks', function($query) {
            // $query->whereBetween('created_at');
                // $query->whereBetween('branch_id', [1, 100]);
                $query->where('branch_id', 1); // Filter by branch_id 1
            })->get();


        
            // For each product, load the stocks with additional relationships and order them by expiry_date
            $products->each(function($product) use ($startDate, $endDate) {
                $product->load([
                    'stocks.stock.vendor',
                    'stocks' => function($query) use ($startDate, $endDate) {
                        $query->orderBy('expiry_date', 'ASC');
                        $query->whereBetween('created_at', [$startDate, $endDate]);
                    }
                ]);
            });

            $oldProducts = Product::with(['all_stocks.branch'])
            ->whereHas('all_stocks', function($query) {
            // $query->whereBetween('created_at');
                // $query->whereBetween('branch_id', [1, 100]);
                $query->where('branch_id', 1); // Filter by branch_id 1
            })->get();

               // Load additional relationships for old products from the initial date to the start date
                $oldProducts->each(function($product) use ($initialDate, $startDate) {
                    $product->load([
                        'stocks.stock.vendor',
                        'stocks' => function($query) use ($initialDate, $startDate) {
                            $query->orderBy('expiry_date', 'ASC');
                            $query->whereBetween('created_at', [$initialDate, $startDate]);
                        }
                    ]);
                });

                return [
                    'current_products' => $products,
                    'old_products' => $oldProducts
                ];
                    
        
        }
        
            
        /**
         * --------------
         * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         * get sales
         * apply filters
         * --------------
         */
        
        // public function filter_sales_attributes_wise ( $limit = 0 ) {
        //     config () -> set ( 'database.connections.mysql.strict', false );
        //     DB ::reconnect ();
            
        //     $search = false;
        //     $is_online = 0; // Default value for the is_online filter

        //     // Check if 'is_online' is provided in the request and update $is_online accordingly
        //     if (request()->filled('is_online')) {
        //         $is_online = request('is_online');
        //         $search = true;
        //     }
        //     $sql = "SELECT ims_attributes.id AS attribute_id, ims_attributes.title, COALESCE(SUM(ims_sale_products.quantity), 0) as quantity, SUM(ims_sale_products.net_price) AS net, COALESCE(SUM(ims_sale_products.discount), 0) as discount FROM ims_sales JOIN ims_sale_products ON ims_sales.id=ims_sale_products.sale_id
        //      AND ims_sales.sale_closed='1' AND ims_sales.refunded='0' AND ims_sales.is_online='$is_online' AND ims_sales.deleted_at IS NULL AND ims_sale_products.deleted_at IS NULL JOIN ims_product_terms ON ims_sale_products.product_id=ims_product_terms.product_id JOIN ims_terms ON ims_product_terms.term_id=ims_terms.id JOIN ims_attributes ON ims_terms.attribute_id=ims_attributes.id WHERE 1";
            
        //     if ( request () -> has ( 'customer-id' ) && request () -> filled ( 'customer-id' ) && request ( 'customer-id' ) > 0 ) {
        //         $customer_id = request ( 'customer-id' );
        //         $sql         .= " AND ims_sales.customer_id=$customer_id";
        //         $search      = true;
        //     }
            
        //     if ( request () -> has ( 'user-id' ) && request () -> filled ( 'user-id' ) && request ( 'user-id' ) > 0 ) {
        //         $user_id = request ( 'user-id' );
        //         $sql     .= " AND ims_sales.user_id=$user_id";
        //         $search  = true;
        //     }
            
        //     if ( request () -> has ( 'attribute-id' ) && count ( request ( 'attribute-id' ) ) > 0 ) {
        //         // dd(request('attribute-id'));

        //         $attribute_id = implode ( ',', request ( 'attribute-id' ) );
        //         $sql          .= " AND attribute_id IN ($attribute_id)";
        //         $search       = true;
        //     }
        //     // dd($sql);
        //     if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) && request ( 'branch-id' ) > 0 ) {
        //         $branch_id = request ( 'branch-id' );
        //         $users     = User ::where ( [ 'branch_id' => $branch_id ] ) -> pluck ( 'id' ) -> toArray ();
                
        //         if ( count ( $users ) > 0 ) {
        //             $user_ids = implode ( ',', $users );
        //             $sql      .= " AND ims_sales.user_id IN ($user_ids)";
        //         }
                
        //         $search = true;
        //     }
            
        //     if ( request () -> has ( 'start-date' ) && request () -> filled ( 'start-date' ) && request () -> has ( 'end-date' ) && request () -> filled ( 'end-date' ) ) {
        //         $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
        //         $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                
        //         $sql .= " AND DATE(ims_sales.created_at) BETWEEN '$start_date' AND '$end_date'";
                
        //         $search = true;
        //     }
            
        //     $sql .= " GROUP BY ims_attributes.id ORDER BY quantity DESC";
            
        //     if ( $limit > 0 )
        //         $sql .= " limit $limit";
            
        //     if ( $search || $limit > 0 )
        //         return DB ::select ( $sql );
        //     else
        //         return [];
        // }

        public function filter_sales_attributes_wise ($limit = 0) {
            config()->set('database.connections.mysql.strict', false);
            DB::reconnect();
        
            $search = false;
            $is_online = 0; // Default value for the is_online filter
        
            // Check if 'is_online' is provided in the request and update $is_online accordingly
            if (request()->filled('is_online')) {
                $is_online = request('is_online');
                $search = true;
            }
        
            $sql = "SELECT ims_attributes.id AS attribute_id, ims_attributes.title, 
                    COALESCE(SUM(ims_sale_products.quantity), 0) as quantity, 
                    SUM(ims_sale_products.net_price) AS net, 
                    COALESCE(SUM(ims_sale_products.discount), 0) as discount 
                    FROM ims_sales 
                    JOIN ims_sale_products ON ims_sales.id = ims_sale_products.sale_id 
                    AND ims_sales.sale_closed = '1' 
                    AND ims_sales.refunded = '0' 
                    AND ims_sales.is_online = '$is_online' 
                    AND ims_sales.deleted_at IS NULL 
                    AND ims_sale_products.deleted_at IS NULL 
                    JOIN ims_product_terms ON ims_sale_products.product_id = ims_product_terms.product_id 
                    JOIN ims_terms ON ims_product_terms.term_id = ims_terms.id 
                    JOIN ims_attributes ON ims_terms.attribute_id = ims_attributes.id 
                    WHERE 1";
        
            if (request()->has('customer-id') && request()->filled('customer-id') && request('customer-id') > 0) {
                $customer_id = request('customer-id');
                $sql .= " AND ims_sales.customer_id = $customer_id";
                $search = true;
            }
        
            if (request()->has('user-id') && request()->filled('user-id') && request('user-id') > 0) {
                $user_id = request('user-id');
                $sql .= " AND ims_sales.user_id = $user_id";
                $search = true;
            }
        
            if (request()->has('attribute-id') && count(request('attribute-id')) > 0) {
                $attribute_id = implode(',', request('attribute-id'));
                $sql .= " AND ims_terms.attribute_id IN ($attribute_id)"; // Specify table name here
                $search = true;
            }
        
            if (request()->has('branch-id') && request()->filled('branch-id') && request('branch-id') > 0) {
                $branch_id = request('branch-id');
                $users = User::where(['branch_id' => $branch_id])->pluck('id')->toArray();
        
                if (count($users) > 0) {
                    $user_ids = implode(',', $users);
                    $sql .= " AND ims_sales.user_id IN ($user_ids)";
                }
        
                $search = true;
            }
        
            if (request()->has('start-date') && request()->filled('start-date') && request()->has('end-date') && request()->filled('end-date')) {
                $start_date = date('Y-m-d', strtotime(request('start-date')));
                $end_date = date('Y-m-d', strtotime(request('end-date')));
        
                $sql .= " AND DATE(ims_sales.created_at) BETWEEN '$start_date' AND '$end_date'";
        
                $search = true;
            }
        
            $sql .= " GROUP BY ims_attributes.id ORDER BY quantity DESC";
        
            if ($limit > 0) {
                $sql .= " limit $limit";
            }
        
            if ($search || $limit > 0) {
                return DB::select($sql);
            } else {
                return [];
            }
        }
        
        
        public function filter_sales_products_wise () {
            $search = false;

            $is_online = 0;
            if (request()->filled('is_online')) {
                $is_online = request('is_online');
            }
    
            
            $query  = SaleProducts ::query ();
            $query -> select ( 'sale_products.product_id as product_id' );
            $query -> selectRaw ( 'COALESCE(SUM(ims_sale_products.quantity), 0) as quantity, COALESCE(SUM(ims_sale_products.net_price), 0) as net_price' );
            $query -> join ( 'sales', function ( $model ) use ($is_online) {
                $model -> on ( 'sales.id', '=', 'sale_products.sale_id' )
                ->where('sales.is_online', $is_online);
            } );
            
            if ( request () -> has ( 'customer-id' ) && request () -> filled ( 'customer-id' ) && request ( 'customer-id' ) > 0 ) {
                $customer_id = request ( 'customer-id' );
                $query -> where ( [ 'sales.customer_id' => $customer_id ] );
                $search = true;
            }
            
            if ( request () -> has ( 'user-id' ) && request () -> filled ( 'user-id' ) && request ( 'user-id' ) > 0 ) {
                $user_id = request ( 'user-id' );
                $query -> where ( [ 'sales.user_id' => $user_id ] );
                $search = true;
            }
            
            if ( request () -> has ( 'product-id' ) && count ( request ( 'product-id' ) ) > 0 ) {
                $product_id = request ( 'product-id' );
                $query -> whereIn ( 'product_id', $product_id );
                $search = true;
            }
            
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) && request ( 'branch-id' ) > 0 ) {
                $branch_id = request ( 'branch-id' );
                $users     = User ::where ( [ 'branch_id' => $branch_id ] ) -> pluck ( 'id' ) -> toArray ();
                
                if ( count ( $users ) > 0 ) {
                    $query -> whereIn ( 'sales.user_id', $users );
                }
                
                $search = true;
            }
            
            if ( request () -> has ( 'start-date' ) && request () -> filled ( 'start-date' ) && request () -> has ( 'end-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                
                $query -> whereBetween ( 'sales.created_at', [
                    $start_date,
                    $end_date
                ] );
                
                $search = true;
            }
            
            $query -> where ( [
                                  'sales.sale_closed' => '1',
                                  'sales.refunded'    => '0',
                              ] );
            $query -> whereNull ( 'sales.deleted_at' );
            $query -> whereNull ( 'sale_products.deleted_at' );
            $query -> groupBy ( 'product_id' ) -> orderBy ( 'quantity', 'DESC' );
            $query -> with ( 'product' );
            
            if ( $search )
                return $query -> get ();
            else
                return [];
        }

//        public function attribute_wise_quantity_report () {
//
//            if ( request () -> has ( 'attribute-id' ) && request ( 'attribute-id' ) > 0 ) {
//                $attribute = Attribute ::find ( request ( 'attribute-id' ) );
//                if ( !empty( $attribute ) ) {
//                    return $attribute -> load ( [ 'terms' => function ( $query ) {
//                        $query -> orderBy ( 'title', 'ASC' );
//                    }, 'terms.product_terms.product' ] );
//                }
//            }
//            return null;
//        }
        
        public function attribute_wise_quantity_report() {
            $search = false;

            // Initialize the query for attributes
            $attribute = Attribute::select(['id', 'title'])
                ->with(['terms' => function ($query) {
                    $query->orderBy('terms.title', 'ASC');
                }])
                ->has('terms.product_terms.product');

            // Check if 'attribute-id' is provided and apply the filter
            if (request()->filled('attribute-id') && request('attribute-id') > 0) {
                $attribute->where('id', request('attribute-id'));
                $search = true;
            }

            // Check if 'branch-id' is provided and apply the filter through related products' stocks
            if (request()->filled('branch-id')) {
                $attribute->whereHas('terms.product_terms.product.all_stocks', function ($query) {
                    $query->where('branch_id', request('branch-id'));
                });
                $search = true;
            }

            // Return the filtered attributes or an empty array if no filters were applied
            if ($search) {
                return $attribute->groupBy('attributes.id', 'attributes.title')->get();
            } else {
                return [];
            }
        }

        
        public function filter_sales_total () {
            $search = false;
            $sales  = Sale ::where ( [
                                         'refunded'    => '0',
                                         'sale_closed' => '1'
                                     ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $sales -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            return $search ? $sales -> sum ( 'total' ) : 0;
            
        }
        
        public function filter_sales_refund_total () {
            $search = false;
            $sales  = Sale ::where ( [
                                         'refunded'    => '1',
                                         'sale_closed' => '1'
                                     ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $sales -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            return $search ? $sales -> sum ( 'net' ) : 0;
            
        }
        
        public function filter_sales_return_total () {
            $search = false;
            $return = Stock ::where ( [ 'stock_type' => 'customer-return', ] ) -> whereNotNull ( 'customer_id' );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $return -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $search    = true;
                $branch_id = request ( 'branch-id' );
                $return -> where ( [ 'branch_id' => $branch_id ] );
            }
            
            return $search ? $return -> sum ( 'return_net' ) : 0;
            
        }
        
        public function sale_discounts () {
            $search = false;
            $sales  = Sale ::selectRaw ( 'SUM(total) as total, SUM(net) as net' ) -> where ( [
                                                                                                 'refunded'    => '0',
                                                                                                 'sale_closed' => '1'
                                                                                             ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $sales -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            return $search ? $sales -> first () : 0;
            
        }
        
        public function get_ledgers_by_account_head ( $id ) {
            $accountHead             = Account ::where ( [ 'id' => $id ] ) -> with ( 'running_balance' ) -> first ();
            $accountHead -> children = $this -> getChildrenAccounts ( $id );
            return $this -> convertToTr ( $accountHead );
        }
        
        public function getChildrenAccounts ( $id ) {
            $children = DB ::table ( 'account_heads' ) -> where ( 'account_head_id', $id ) -> get ();
            
            foreach ( $children as $child ) {
                $child -> children = $this -> getChildrenAccounts ( $child -> id );
            }
            
            return $children;
        }
        
        public function convertToTr ( $account_heads, $children = false, $padding = 50 ) {
            $item = '';
            $net  = 0;
            
            if ( !$children ) {
                $running_balance = ( new AccountService() ) -> get_account_head_running_balance ( $account_heads -> id );
                $item            .= '<tr>';
                $item            .= '<td>' . $account_heads -> name . '</td>';
                $item            .= '<td>' . number_format ( $running_balance, 2 ) . '</td>';
                $net             += $running_balance;
                $item            .= '</tr>';
            }
            if ( count ( $account_heads -> children ) > 0 ) {
                foreach ( $account_heads -> children as $account_head ) {
                    $item            .= '<tr>';
                    $running_balance = ( new AccountService() ) -> get_account_head_running_balance ( $account_head -> id );
                    $net             += $running_balance;
                    if ( count ( $account_head -> children ) > 0 ) {
                        $item            .= '<td style="padding-left:' . $padding . 'px">' . $account_head -> name . '</td>';
                        $item            .= '<td>' . number_format ( abs ( $running_balance ), 2 ) . '</td>';
                        $recursiveResult = $this -> convertToTr ( $account_head, true, ( $padding + 25 ) );
                        $item            .= $recursiveResult[ 'items' ];
                        
                    }
                    else {
                        $item .= '<td style="padding-left:' . $padding . 'px">' . $account_head -> name . '</td>';
                        $item .= '<td>' . number_format ( abs ( $running_balance ), 2 ) . '</td>';
                    }
                    $item .= '</tr>';
                }
            }
            
            return [
                'items' => $item,
                'net'   => $net
            ];
        }
        
        public function customer_returns () {
            $search = false;
            $stocks = Stock ::ByBranch () -> with ( [ 'customer' ] ) -> where ( [ 'stock_type' => 'customer-return' ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $stocks -> whereBetween ( DB ::raw ( 'DATE(stock_date)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            if ( request () -> filled ( 'customer-id' ) ) {
                $search = true;
                $stocks -> where ( [ 'customer_id' => request ( 'customer-id' ) ] );
            }
            
            if ( $search )
                return $stocks -> get ();
            else
                return [];
        }
        
        public function vendor_returns () {
            $search  = false;
            $returns = StockReturn ::with ( [ 'products.product' ] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 )
                $returns -> where ( [ 'user_id' => auth () -> user () -> id ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $returns -> whereBetween ( DB ::raw ( 'DATE(created_at)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            if ( request () -> filled ( 'vendor-id' ) ) {
                $search = true;
                $returns -> where ( [ 'vendor_id' => request ( 'vendor-id' ) ] );
            }
            
            if ( $search )
                return $returns -> get ();
            else
                return [];
        }
        
        public function filter_stocks () {
            $search = false;
            $stocks = Stock ::ByBranch () -> with ( [ 'vendor', 'products.product', 'products' => function ( $query ) use ( $search ) {
                if ( request () -> filled ( 'product-id' ) ) {
                    $search = true;
                    $query -> where ( [ 'product_id' => request ( 'product-id' ) ] );
                }
            } ] ) -> where ( [ 'stock_type' => 'vendor' ] );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $stocks -> whereBetween ( DB ::raw ( 'DATE(stock_date)' ), [
                    $start_date,
                    $end_date
                ] );
            }
            
            if ( request () -> filled ( 'vendor-id' ) ) {
                $search = true;
                $stocks -> where ( [ 'vendor_id' => request ( 'vendor-id' ) ] );
            }
            
            if ( $search )
                return $stocks -> get ();
            else
                return [];
        }
        
        public function calculate_sales_ledger ( $id, $column = '' ) {
            $accountHead             = Account ::where ( [ 'id' => $id ] ) -> with ( 'running_balance' ) -> first ();
            $accountHead -> children = $this -> getChildrenAccounts ( $id );
            return $this -> convertToTrCustomized ( $accountHead, false, 50, $column );
        }
        
        public function convertToTrCustomized ( $account_heads, $children = false, $padding = 50, $column = '' ): array {
            $item = '';
            $net  = 0;
            
            if ( !$children ) {
                $running_balance = ( new AccountService() ) -> get_sales_running_balance ( $account_heads -> id, $column );
                $item            .= '<tr>';
                $item            .= '<td>' . $account_heads -> name . '</td>';
                $item            .= '<td>' . number_format ( $running_balance, 2 ) . '</td>';
                $net             += $running_balance;
                $item            .= '</tr>';
            }
            if ( count ( $account_heads -> children ) > 0 ) {
                foreach ( $account_heads -> children as $account_head ) {
                    $item            .= '<tr>';
                    $running_balance = ( new AccountService() ) -> get_sales_running_balance ( $account_head -> id, $column );
                    $net             += $running_balance;
                    if ( count ( $account_head -> children ) > 0 ) {
                        $item            .= '<td style="padding-left:' . $padding . 'px">' . $account_head -> name . '</td>';
                        $item            .= '<td>' . number_format ( abs ( $running_balance ), 2 ) . '</td>';
                        $recursiveResult = $this -> convertToTrCustomized ( $account_head, true, ( $padding + 25 ), $column );
                        $item            .= $recursiveResult[ 'items' ];
                    }
                    else {
                        $item .= '<td style="padding-left:' . $padding . 'px">' . $account_head -> name . '</td>';
                        $item .= '<td>' . number_format ( abs ( $running_balance ), 2 ) . '</td>';
                    }
                    $item .= '</tr>';
                }
            }
            return [
                'items' => $item,
                'net'   => $net
            ];
        }
        
        public function filter_balance_sheet ( $account_head_id ): array {
            if ( !request () -> filled ( 'start-date' ) )
                return [
                    'html' => '',
                    'net'  => 0
                ];
            
            $accounts = Account ::where ( [ 'account_head_id' => $account_head_id ] ) -> get ();
            return $this -> createTableRows ( $accounts );
        }
        
        public function createTableRows ( $account_heads, $padding = 50 ): array {
            $item = '';
            $net  = 0;
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $item            .= '<tr>';
                    $running_balance = ( new AccountService() ) -> get_recursive_account_head_running_balance ( $account_head -> id );
                    $net             += $running_balance;
                    $item            .= '<td style="padding-left:' . $padding . 'px">' . $account_head -> name . '</td>';
                    $item            .= '<td>' . number_format ( $running_balance, 2 ) . '</td>';
                    $item            .= '</tr>';
                }
            }
            return [
                'html' => $item,
                'net'  => $net
            ];
        }
        
        public function profit () {
            $sales                  = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'credit' );
            $sales_refund           = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'debit' );
            $sale_discounts         = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.discount_on_invoices' ) );
            $direct_costs           = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.direct_cost' ) );
            $general_admin_expenses = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.expenses' ) );
            $income                 = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.income' ) );
            $taxes                  = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.tax' ) );
            $a                      = 0;
            $b                      = 0;
            $c                      = 0;
            $d                      = 0;
            $e                      = 0;
            $f                      = 0;
            $g                      = 0;
            $h                      = 0;
            $i                      = 0;
            $j                      = 0;
            $k                      = 0;
            $a                      += $sales[ 'net' ];
            $b                      += $sales_refund[ 'net' ];
            $c                      += $sale_discounts[ 'net' ];
            $e                      = ( $a - $b - $c );
            $f                      += $direct_costs[ 'net' ];
            $g                      += $e - $f;
            $h                      += $general_admin_expenses[ 'net' ];
            $i                      = $g - $h;
            $i                      += $income[ 'net' ];
            $j                      += $taxes[ 'net' ];
            return ( $i > 0 ? $i - $j : $i + $j );
        }
        
        public function category_wise_quantity_report () {
            
            $search   = false;
            $products = Product ::query ();
            
            if ( request () -> has ( 'category-id' ) ) {
                $products -> where ( [ 'category_id' => request ( 'category-id' ) ] );
                $search = true;
            }
            if (request()->filled('branch-id')) {
                $products->whereHas('all_stocks', function ($query) {
                    $query->where('branch_id', request('branch-id'));
                });
                $search = true;
            }
            
            return $search ? $products -> with ( 'category' ) -> get () : [];
        }


        public function high_low_sale_reports () {


        }
        
        public function category_wise_products () {
            
            $search     = false;
            $categories = Category :: select ( [ 'id', 'title' ] ) -> with ( [ 'products' => function ( $query ) {
                $query -> orderBy ( 'products.title', 'ASC' );
            } ] ) -> has ( 'products' );
            
            if ( request () -> filled ( 'category-id' ) ) {
                $search = true;
                $categories -> where ( [ 'id' => request ( 'category-id' ) ] );
            }
            
            if ( $search )
                return $categories -> get ();
            else
                return [];
        }
        
        public function sale_analysis_report () {
            $search = false;
            $sales  = SaleProducts ::with ( [ 'sale', 'product' ] )
                -> whereIn ( 'sale_id', function ( $query ) {
                    $query
                        -> select ( 'id' )
                        -> from ( 'sales' )
                        -> whereNull ( 'deleted_at' )
                        -> where ( [ 'sale_closed' => '1' ] );
                } );
            
            if ( request () -> filled ( 'product-id' ) ) {
                $search = true;
                $sales -> where ( [ 'product_id' => request ( 'product-id' ) ] );
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $search     = true;
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $sales -> whereIn ( 'sale_id', function ( $query ) use ( $start_date, $end_date ) {
                    $query
                        -> select ( 'id' )
                        -> from ( 'sales' )
                        -> whereBetween ( DB ::raw ( 'DATE(closed_at)' ), [
                            $start_date,
                            $end_date
                        ] );
                } );
            }
            
            if ( request () -> filled ( 'customer-id' ) ) {
                $search = true;
                $sales -> whereIn ( 'sale_id', function ( $query ) {
                    $query
                        -> select ( 'id' )
                        -> from ( 'sales' )
                        -> where ( [ 'customer_id' => request ( 'customer-id' ) ] );
                } );
            }
            
            return $search ? $sales -> get () : [];
        }
    }
