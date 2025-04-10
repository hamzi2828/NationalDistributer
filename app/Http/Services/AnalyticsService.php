<?php
    
    namespace App\Http\Services;
    
    use App\Http\Helpers\GeneralHelper;
    use App\Models\Account;
    use App\Models\GeneralLedger;
    use App\Models\MonthModel;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\Sale;
    use App\Models\SaleProducts;
    use App\Models\User;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    
    class AnalyticsService {
        
        public function months () {
            return Cache ::remember ( 'months', 120, function () {
                return MonthModel ::pluck ( 'short_name' ) -> toArray ();
            } );
        }
        
        public function sales () {
            $date = date ( 'Y-m-d' );
            
            $sale = Sale ::query ();
            $sale -> where ( [
                                 'sale_closed' => '1',
                                 'refunded'    => '0'
                             ] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $sale -> where ( [
                                     'user_id' => auth () -> user () -> id,
                                 ] ) -> whereRaw ( "DATE(created_at)='$date'" );
            }
            
            return $sale -> sum ( 'net' );
        }
        
        public function orders_count ( $open = true ) {
            $sale = Sale ::query ();
            $sale -> where ( [ 'refunded' => '0', 'status' => '1' ] );
            
            if ( $open )
                $sale -> where ( [ 'sale_closed' => '0' ] );
            else
                $sale -> where ( [ 'sale_closed' => '1' ] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $sale -> where ( [
                                     'user_id' => auth () -> user () -> id,
                                 ] );
            }
            
            return $sale -> count ();
        }
        
        public function payable () {
            $account_head_id = config ( 'constants.account_payable' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'account_head_id' => $account_head_id ] );
            } );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $account -> where ( [
                                        'user_id' => auth () -> user () -> id,
                                    ] );
            }
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( in_array ( $account_head -> account_type -> id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $record -> debit - $record -> credit;
                    else
                        $running_balance = $running_balance - $record -> debit + $record -> credit;
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function receivable () {
            $account_head_id = config ( 'constants.account_receivable' );
            $running_balance = 0;
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id' );
            $account -> selectRaw ( 'SUM(credit) as credit' );
            $account -> selectRaw ( 'SUM(debit) as debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'account_head_id' => $account_head_id ] );
            } );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $account -> where ( [
                                        'user_id' => auth () -> user () -> id,
                                    ] );
            }
            
            $records      = $account -> groupBy ( 'account_head_id' ) -> get ();
            $account_head = Account ::where ( [ 'id' => $account_head_id ] ) -> with ( 'account_type' ) -> first ();
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( in_array ( $account_head -> account_type -> id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $record -> debit - $record -> credit;
                    else
                        $running_balance = $running_balance - $record -> debit + $record -> credit;
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( abs ( $running_balance ) ) );
        }
        
        public function month_wise_sales () {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            
            $year = date ( 'Y' );
            
            $sql = "SELECT ims_months.*, SUM(ims_sales.net) as net FROM ims_months LEFT JOIN ims_sales ON ims_months.month_number=MONTH(ims_sales.created_at) AND YEAR(ims_sales.created_at)='$year' AND (`ims_sales`.`sale_closed` = '1') AND (ims_sales.deleted_at IS NULL) AND (ims_sales.refunded='0') Where 1";
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sql     .= " AND ims_sales.user_id=$user_id";
            }
            
            $sql   .= " GROUP BY ims_months.month_number";
            $sales = DB ::select ( $sql );
            
            $array = [];
            if ( count ( $sales ) ) {
                foreach ( $sales as $sale ) {
                    array_push ( $array, ( $sale -> net == null ) ? 0 : round ( $sale -> net, 2 ) );
                }
            }
            return $array;
        }
        
        public function monthly_orders () {
            $month = date ( 'm' );
            return ( Sale ::selectRaw ( 'SUM(net) as net' ) -> where ( [
                                                                           'sale_closed' => '1',
                                                                           'refunded'    => '0'
                                                                       ] ) -> whereRaw ( "MONTH(created_at)='$month'" ) -> first () );
        }
        
        public function expenses () {
            $account_head_id = config ( 'constants.expenses' );
            $year            = date ( 'Y' );
            
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            
            $sql = "Select ims_months.*, `account_head_id`, SUM(credit) as credit, SUM(debit) as debit from ims_months LEFT JOIN `ims_general_ledgers` ON ims_months.month_number=MONTH(ims_general_ledgers.created_at) AND YEAR(ims_general_ledgers.created_at)='$year' AND `account_head_id` in (select `id` from `ims_account_heads` where (`account_head_id` = '$account_head_id')) AND `ims_general_ledgers`.`deleted_at` is null where 1";
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sql     .= " AND ims_general_ledgers.user_id=$user_id";
            }
            
            $sql .= " group by ims_months.month_number";
            
            $expanses = DB ::select ( $sql );
            
            $array = [];
            if ( count ( $expanses ) > 0 ) {
                $account_head = Account ::where ( [ 'id' => config ( 'constants.expenses' ) ] ) -> with ( 'account_type' ) -> first ();
                foreach ( $expanses as $expense ) {
                    $running_balance = 0;
                    if ( in_array ( $account_head -> account_type -> id, config ( 'constants.account_type_in' ) ) ) {
                        $running_balance = $running_balance + ( $expense -> debit == null ? 0 : $expense -> debit ) - ( $expense -> credit == null ? 0 : $expense -> credit );
                    }
                    else {
                        $running_balance = $running_balance - ( $expense -> debit == null ? 0 : $expense -> debit ) + ( $expense -> credit == null ? 0 : $expense -> credit );
                    }
                    array_push ( $array, abs ( round ( $running_balance, 2 ) ) );
                }
            }
            return $array;
        }
        
        public function cash_in_hand () {
            $account_head_id = config ( 'constants.cash_in_hand' );
            $year            = date ( 'Y' );
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            
            $sql = "Select ims_months.*, `account_head_id`, SUM(credit) as credit, SUM(debit) as debit from ims_months LEFT JOIN `ims_general_ledgers` ON ims_months.month_number=MONTH(ims_general_ledgers.created_at) AND YEAR(ims_general_ledgers.created_at)='$year' AND `account_head_id`=$account_head_id AND `ims_general_ledgers`.`deleted_at` is null where 1";
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sql     .= " AND ims_general_ledgers.user_id=$user_id";
            }
            
            $sql  .= " group by ims_months.month_number";
            $cash = DB ::select ( $sql );
            
            $array = [];
            if ( count ( $cash ) > 0 ) {
                $account_head = Account ::where ( [ 'id' => config ( 'constants.cash_in_hand' ) ] ) -> with ( 'account_type' ) -> first ();
                
                foreach ( $cash as $hand ) {
                    $running_balance = 0;
                    
                    if ( in_array ( $account_head -> account_type -> id, config ( 'constants.account_type_in' ) ) ) {
                        $running_balance = $running_balance + ( $hand -> debit == null ? 0 : $hand -> debit ) - ( $hand -> credit == null ? 0 : $hand -> credit );
                    }
                    else {
                        $running_balance = $running_balance - ( $hand -> debit == null ? 0 : $hand -> debit ) + ( $hand -> credit == null ? 0 : $hand -> credit );
                    }
                    array_push ( $array, abs ( round ( $running_balance, 2 ) ) );
                }
            }
            return $array;
        }
        
        public function top_selling_products ( $limit = 10 ) {
            $sales = SaleProducts ::with ( [ 'product.term.term.attribute' ] )
                -> Join ( 'sales', 'sale_products.sale_id', '=', 'sales.id' )
                -> selectRaw ( 'ims_sale_products.product_id as product_id, COALESCE(sum(ims_sale_products.quantity),0) quantity, COALESCE(sum(ims_sale_products.net_price),0) net_price' )
                -> where ( [
                               'sales.sale_closed' => '1',
                               'sales.deleted_at'  => null
                           ] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sales -> where ( [ 'user_id' => $user_id ] );
            }
            
            return $sales -> groupBy ( 'sale_products.product_id' ) -> orderBy ( 'quantity', 'DESC' ) -> limit ( $limit ) -> get ();
        }
        
        public function sales_analysis_report_product_wise () {
            $search = false;
            $sales  = SaleProducts ::with ( [ 'product.term.term.attribute' ] )
             -> Join ( 'sales', 'sale_id', '=', 'sales.id' ) 
             -> selectRaw ( 'ims_sale_products.product_id as product_id, COALESCE(sum(ims_sale_products.quantity),0) quantity, COALESCE(sum(ims_sale_products.net_price),0) net_price' ) 
             -> where ( [ 'sales.sale_closed' => '1','sales.deleted_at'  => null] );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sales -> where ( [ 'user_id' => $user_id ] );
            }
            
            if ( request () -> has ( 'product-id' ) && request () -> input ( 'product-id' ) > 0 ) {
                $product_id = request ( 'product-id' );
                $sales -> where ( [ 'product_id' => $product_id ] );
                $search = true;
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = request ( 'start-date' );
                $end_date   = request ( 'end-date' );
                $sales -> whereBetween ( DB ::raw ( 'DATE(ims_sale_products.created_at)' ), [
                    $start_date,
                    $end_date
                ] );
                $search = true;
            }
            
            if ( $search )
            return $sales ;
                // return $sales -> groupBy ( 'sale_products.product_id' ) -> orderBy ( 'quantity', 'DESC' ) -> get ();
            else
                return [];
        }
        
        public function daily_sales_count () {
            $date = date ( 'Y-m-d' );
            
            $sale = Sale ::query ();
            $sale -> where ( [
                                 'sale_closed' => '1',
                                 'refunded'    => '0'
                             ] );
            $sale -> whereRaw ( "DATE(created_at)='$date'" );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sale -> where ( [ 'user_id' => $user_id ] );
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( $sale -> sum ( 'net' ) ) );
        }
        
        public function daily_profit () {
            $date   = date ( 'Y-m-d' );
            $profit = 0;
            
            $sales = SaleProducts ::query () -> select ( 'sale_id' ) -> selectRaw ( 'GROUP_CONCAT(product_id) as products, GROUP_CONCAT(stock_id) as stocks, GROUP_CONCAT(quantity) as quantity' ) -> whereRaw ( "DATE(created_at)='$date'" ) -> whereNull ( 'deleted_at' ) -> whereIn ( 'sale_id', function ( $model ) {
                $model -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'deleted_at'  => null,
                                                                             'refunded'    => '0',
                                                                             'sale_closed' => '1'
                                                                         ] );
            } );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sales -> whereIn ( 'sale_id', function ( $model ) use ( $user_id ) {
                    $model -> select ( 'id' ) -> from ( 'sales' ) -> where ( [ 'user_id' => $user_id ] );
                } );
            }
            
            $sales = $sales -> groupBy ( 'sale_id' ) -> with ( [
                                                                   'sale.customer'
                                                               ] ) -> latest () -> get ();
            
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale ) {
                    $stocks       = explode ( ',', $sale -> stocks );
                    $quantity     = explode ( ',', $sale -> quantity );
                    $gross_profit = 0;
                    
                    if ( count ( $stocks ) > 0 ) {
                        foreach ( $stocks as $key => $stock_id ) {
                            $stock = ProductStock ::find ( $stock_id );
                            if ( !empty( $stock ) )
                                $gross_profit = $gross_profit + ( $stock -> tp_unit * $quantity[ $key ] );
                        }
                    }
                    
                    $profit += ( $sale -> sale -> net - $gross_profit );
                }
            }
            
            return ( ( new GeneralHelper() ) -> format_currency ( $profit ) );
        }
        
        public function inventory_value_tp_wise () {
            return Cache ::remember ( 'inventory_value_tp_wise', 120, function () {
                $products = Product ::withWhereHas ( 'all_stocks', function ( $query ) {
                    $query -> where ( 'branch_id', '=', auth () -> user () -> branch_id );
                } ) -> get ();
                
                $net = 0;
                if ( count ( $products ) > 0 ) {
                    foreach ( $products as $product ) {
                        $value = ( $product -> stock_value_tp_wise () * $product -> available_quantity () );
                        $net   += $value;
                    }
                }
                return ( ( new GeneralHelper() ) -> format_currency ( $net ) );
            } );
        }
        
        public function inventory_value_sale_wise () {
            return Cache ::remember ( 'inventory_value_sale_wise', 120, function () {
                $products = Product ::withWhereHas ( 'all_stocks', function ( $query ) {
                    $query -> where ( 'branch_id', '=', auth () -> user () -> branch_id );
                } ) -> get ();
                
                $net = 0;
                if ( count ( $products ) > 0 ) {
                    foreach ( $products as $product ) {
                        $value = ( $product -> stock_value_sale_wise () * $product -> available_quantity () );
                        $net   += $value;
                    }
                }
                return ( ( new GeneralHelper() ) -> format_currency ( $net ) );
            } );
        }
        
        public function get_threshold_products () {
            return Cache ::remember ( 'get_threshold_products', 120, function () {
                $products = ( new ProductService() ) -> all ();
                
                $array = [];
                if ( count ( $products ) > 0 ) {
                    foreach ( $products as $product ) {
                        if ( $product -> available_quantity () < $product -> threshold && count ( $array ) <= 20 ) {
                            $info[ 'labels' ]   = $product -> id;
                            $info[ 'actual' ]   = $product -> available_quantity ();
                            $info[ 'expected' ] = $product -> threshold;
                            array_push ( $array, $info );
                        }
                    }
                }
                $array_1            = array_column ( $array, 'labels' );
                $array_2            = array_column ( $array, 'actual' );
                $array_3            = array_column ( $array, 'expected' );
                $info[ 'labels' ]   = $array_1;
                $info[ 'actual' ]   = $array_2;
                $info[ 'expected' ] = $array_3;
                return $info;
            } );
        }
        
        public function daily_sales () {
            $month = date ( 'm' );
            $year  = date ( 'Y' );
            $sales = Sale ::selectRaw ( 'DAY(created_at) as sale_day, SUM(net) as net' ) -> where ( [
                                                                                                        'sale_closed' => '1',
                                                                                                        'refunded'    => '0'
                                                                                                    ] ) -> whereRaw ( "MONTH(created_at)='$month' AND YEAR(created_at)='$year'" );
            
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 ) {
                $user_id = auth () -> user () -> id;
                $sales -> where ( [ 'user_id' => $user_id ] );
            }
            
            $sales  = $sales -> groupBy ( DB ::raw ( 'DAY(created_at)' ) ) -> get ();
            $values = '';
            $days   = '';
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $key => $sale ) {
                    $values .= $sale -> net . ',';
                    $day    = $sale -> sale_day;
                    $days   .= date ( 'D jS', strtotime ( "$year-$month-$day" ) );
                    if ( $key < ( count ( $sales ) - 1 ) )
                        $days .= ',';
                }
            }
            
            return array (
                'values' => $values,
                'days'   => explode ( ',', $days )
            );
        }
        
        public function sales_analysis_report_attribute_wise () {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            
            $search = false;
            
            $sql = "SELECT ims_attributes.id AS attribute_id, ims_attributes.title, COALESCE(SUM(ims_sale_products.quantity), 0) as quantity, SUM(ims_sale_products.net_price) AS net, COALESCE(SUM(ims_sale_products.discount), 0) as discount FROM ims_sales JOIN ims_sale_products ON ims_sales.id=ims_sale_products.sale_id AND ims_sales.sale_closed='1' AND ims_sales.refunded='0'AND ims_sales.deleted_at IS NULL AND ims_sale_products.deleted_at IS NULL JOIN ims_product_terms ON ims_sale_products.product_id=ims_product_terms.product_id JOIN ims_terms ON ims_product_terms.term_id=ims_terms.id JOIN ims_attributes ON ims_terms.attribute_id=ims_attributes.id WHERE 1";
            
            if ( request () -> filled ( 'attribute-id' ) ) {
                $attribute_id = request ( 'attribute-id' );
                $sql          .= " AND attribute_id IN ($attribute_id)";
                $search       = true;
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                
                $sql .= " AND DATE(ims_sales.created_at) BETWEEN '$start_date' AND '$end_date'";
                
                $search = true;
            }
            
            $sql .= " GROUP BY ims_attributes.id ORDER BY quantity DESC";
            
            if ( $search )
                return DB ::select ( $sql );
            else
                return [];
        }
        
    }
