<?php
    
    namespace App\Http\Services;
    
    use App\Models\Account;
    use App\Models\FinancialYear;
    use App\Models\GeneralLedger;
    use App\Models\GeneralLedgerTransactionDetails;
    use App\Models\User;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Gate;
    
    class AccountService {
        
        protected int $counter;
        
        public function __construct () {
            $this -> counter = 0;
        }
        
        /**
         * --------------
         * @return mixed
         * get all account heads
         * --------------
         */
        
        public function all () {
            return Account ::with ( [ 'account_head', 'account_type' ] ) -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save account heads
         * --------------
         */
        
        public function save ( $request ) {
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $request -> input ( 'account-head-id' ),
                                          'account_type_id' => $request -> input ( 'account-type-id' ),
                                          'name'            => $request -> input ( 'name' ),
                                          'phone'           => $request -> input ( 'phone' ),
                                          'description'     => $request -> input ( 'description' ),
                                      ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $account
         * @return void
         * update account heads
         * --------------
         */
        
        public function edit ( $request, $account ) {
            $account -> user_id         = auth () -> user () -> id;
            $account -> account_head_id = $request -> input ( 'account-head-id' );
            $account -> account_type_id = $request -> input ( 'account-type-id' );
            $account -> name            = $request -> input ( 'name' );
            $account -> phone           = $request -> input ( 'phone' );
            $account -> description     = $request -> input ( 'description' );
            $account -> update ();
        }
        
        /**
         * --------------
         * @param array $elements
         * @param $parentId
         * @return array
         * convert array into tree
         * --------------
         */
        
        function buildTree ( array $elements, $parentId = 0 ) {
            $branch = array ();
            
            foreach ( $elements as $element ) {
                if ( $element[ 'parent_id' ] == $parentId ) {
                    $children = $this -> buildTree ( $elements, $element[ 'id' ] );
                    if ( $children ) {
                        $element[ 'children' ] = $children;
                    }
                    $branch[] = $element;
                }
            }
            
            return $branch;
        }
        
        /**
         * --------------
         * @return array
         * build a tree structure
         * --------------
         */
        
        public function parseAccountHeads () {
            $account_heads = Account ::with ( [ 'account_head', 'account_type' ] ) -> where ( [ 'active' => '1' ] ) -> get ();
            $array         = array ();
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $info = array (
                        'id'              => $account_head -> id,
                        'parent_id'       => $account_head -> account_head_id,
                        'account_type_id' => $account_head -> account_type_id,
                        'name'            => $account_head -> name,
                        'phone'           => $account_head -> phone,
                        'active'          => $account_head -> active,
                    );
                    array_push ( $array, $info );
                }
            }
            return $array;
        }
        
        public function parseAllAccountHeads () {
            $account_heads = $this -> all ();
            $array         = array ();
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_head ) {
                    $info = array (
                        'id'              => $account_head -> id,
                        'parent_id'       => $account_head -> account_head_id,
                        'account_type_id' => $account_head -> account_type_id,
                        'name'            => $account_head -> name,
                        'phone'           => $account_head -> phone,
                        'active'          => $account_head -> active,
                    );
                    array_push ( $array, $info );
                }
            }
            return $array;
        }
        
        /**
         * --------------
         * @param $account_heads
         * @return string
         * convert to ul li
         * --------------
         */
        
        public function convertToList ( $account_heads = array () ) {
            
            if ( count ( $account_heads ) < 1 )
                $account_heads = $this -> buildTree ( $this -> parseAllAccountHeads () );
            
            $item   = '';
            $edit   = '';
            $delete = '';
            $status = '';
            
            if ( count ( $account_heads ) > 0 ) {
                $item .= '<ol>';
                foreach ( $account_heads as $account_head ) {
                    
                    if ( Gate ::allows ( 'delete', Account ::find ( $account_head[ 'id' ] ) ) )
                        $delete = '<a class="ms-0 me-50" href="' . route ( 'accounts.destroy', [ 'account' => $account_head[ 'id' ] ] ) . '"><i data-feather="trash-2" style="width: 12px;"></i></a>';
                    
                    if ( Gate ::allows ( 'edit', Account ::find ( $account_head[ 'id' ] ) ) )
                        $edit = '<a class="ms-0 me-50" href="' . route ( 'accounts.edit', [ 'account' => $account_head[ 'id' ] ] ) . '"><i data-feather="edit" style="width: 12px;"></i></a>';
                    
                    if ( Gate ::allows ( 'status', Account ::find ( $account_head[ 'id' ] ) ) )
                        $status = '<a class="ms-0 me-50" href="' . route ( 'accounts.status', [ 'account' => $account_head[ 'id' ] ] ) . '"><i data-feather="refresh-ccw" style="width: 12px;"></i></a>';
                    
                    $link  = $edit . $status . $delete;
                    $class = $account_head[ 'active' ] == '0' ? 'text-decoration: line-through;' : '';
                    
                    if ( array_key_exists ( 'children', $account_head ) ) {
                        $item .= '<li style="' . $class . '">' . $link . $account_head[ 'name' ] . '</li>';
                        if ( count ( $account_head[ 'children' ] ) > 0 ) {
                            $item .= $this -> convertToList ( $account_head[ 'children' ] );
                        }
                    }
                    else {
                        $item .= '<li style="' . $class . '">' . $link . $account_head[ 'name' ] . '</li>';
                    }
                }
                $item .= '</ol>';
            }
            
            return $item;
        }
        
        /**
         * --------------
         * @param $account_heads
         * @param $class
         * @param $recursive
         * @return string
         * convert to select options
         * --------------
         */
        
        public function convertToOptions ( $account_heads = array (), $class = 'parent', $recursive = false, $disabled = true, $indentation = 0 ) {
            
            if ( $recursive )
                $this -> counter++;
            else
                $this -> counter = 0;
            
            if ( count ( $account_heads ) < 1 )
                $account_heads = $this -> buildTree ( $this -> parseAccountHeads () );
            
            $item     = '';
            $selected = '';
            $indent   = str_repeat ( '&nbsp;', $indentation * 5 );
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $key => $account_head ) {
                    
                    if ( array_key_exists ( 'children', $account_head ) ) {
                        
                        if ( request () -> input ( 'account-head-id' ) == $account_head[ 'id' ] )
                            $selected = 'selected="selected"';
                        else
                            $selected = '';
                        
                        if ( count ( $account_head[ 'children' ] ) > 0 && $disabled )
                            $disabled = 'disabled="disabled"';
                        else
                            $disabled = '';
                        
                        $item .= '<option class="' . $class . '" style="font-weight: 900" value="' . $account_head[ 'id' ] . '" ' . $selected . $disabled . '><strong>' . $indent . $account_head[ 'name' ] . '</strong></option>';
                        if ( count ( $account_head[ 'children' ] ) > 0 ) {
                            $item .= $this -> convertToOptions ( $account_head[ 'children' ], 'child-' . $this -> counter, true, $disabled, $indentation + 1 );
                        }
                    }
                    else {
                        
                        if ( request () -> input ( 'account-head-id' ) == $account_head[ 'id' ] )
                            $selected = 'selected="selected"';
                        else
                            $selected = '';
                        
                        $this -> counter = 0;
                        $item            .= $indent . '<option class="' . $class . '" style="font-weight: 900" value="' . $account_head[ 'id' ] . '" ' . $selected . '>' . $indent . $account_head[ 'name' ] . '</option>';
                    }
                }
            }
            
            return $item;
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * add transactions
         * --------------
         */
        
        public function add_transactions ( $request ) {
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id' ) );
            $voucher_no  = $this -> generate_voucher_no ();
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => $request -> input ( 'transaction-type' ) === 'credit' ? $request -> input ( 'amount' ) : 0,
                                'debit'            => $request -> input ( 'transaction-type' ) === 'debit' ? $request -> input ( 'amount' ) : 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'transaction-date' ) ) ),
                                'payment_mode'     => $request -> input ( 'payment-mode' ),
                                'transaction_no'   => $request -> input ( 'transaction-no' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id-2' ) );
            return $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => $request -> input ( 'transaction-type-2' ) === 'credit' ? $request -> input ( 'amount' ) : 0,
                                'debit'            => $request -> input ( 'transaction-type-2' ) === 'debit' ? $request -> input ( 'amount' ) : 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'transaction-date' ) ) ),
                                'payment_mode'     => $request -> input ( 'payment-mode' ),
                                'transaction_no'   => $request -> input ( 'transaction-no' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            return $voucher_no;
            
        }
        
        /**
         * --------------
         * @return string|void
         * generate voucher no
         * --------------
         */
        
        public function generate_voucher_no () {
            if ( request () -> has ( 'voucher-no' ) && request () -> filled ( 'voucher-no' ) ) {
                $voucher_no = request () -> input ( 'voucher-no' );
                $row        = DB ::table ( 'general_ledgers' ) -> select ( 'voucher_no' ) -> where ( 'voucher_no', 'like', $voucher_no . '%' ) -> orderBy ( 'id', 'DESC' ) -> first ();
                
                if ( !empty( $row ) ) {
                    $v_no = explode ( '-', $row -> voucher_no );
                    $rows = $v_no[ 1 ] + 1;
                    return $voucher_no . '-' . $rows;
                }
                else
                    return $voucher_no . '-1';
                
            }
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * add opening balances
         * --------------
         */
        
        public function add_opening_balance ( $request ) {
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id' ) );
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => $request -> input ( 'transaction-type' ) === 'credit' ? $request -> input ( 'amount' ) : 0,
                                'debit'            => $request -> input ( 'transaction-type' ) === 'debit' ? $request -> input ( 'amount' ) : 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'transaction-date' ) ) ),
                                'payment_mode'     => 'opening-balance',
                                'description'      => $request -> input ( 'description' ),
                            ] );
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * add multiple transactions
         * --------------
         */
        
        public function add_multiple_transactions ( $request ) {
            $date           = $request -> input ( 'transaction-date' );
            $account_heads  = $request -> input ( 'account-heads' );
            $amount         = $request -> input ( 'amount' );
            $description    = $request -> input ( 'description' );
            $payment_mode   = $request -> input ( 'payment-mode' );
            $transaction_no = $request -> input ( 'transaction-no' );
            $voucher_no     = $this -> generate_voucher_no ();
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $key => $account_head_id ) {
                    if ( !empty( trim ( $account_head_id ) ) && $account_head_id > 0 ) {
                        $account_head = Account ::findorFail ( $account_head_id );
                        
                        $account_head
                            -> general_ledger ()
                            -> create ( [
                                            'user_id'          => auth () -> user () -> id,
                                            'branch_id'        => auth () -> user () -> branch_id,
                                            'account_head_id'  => $account_head -> id,
                                            'credit'           => $request -> input ( 'transaction-type-' . $key ) === 'credit' ? $amount[ $key ] : 0,
                                            'debit'            => $request -> input ( 'transaction-type-' . $key ) === 'debit' ? $amount[ $key ] : 0,
                                            'transaction_date' => date ( 'Y-m-d', strtotime ( $date ) ),
                                            'voucher_no'       => $voucher_no,
                                            'payment_mode'     => $payment_mode,
                                            'transaction_no'   => $transaction_no,
                                            'description'      => $description
                                        ] );
                    }
                }
            }
            
            return $voucher_no;
            
        }
        
        /**
         * --------------
         * @param $request
         * @return void
         * update transactions
         * --------------
         */
        
        public function update_transactions ( $request ) {
            $ledgers          = $request -> input ( 'ledger-id' );
            $amount           = $request -> input ( 'amount' );
            $transaction_date = $request -> input ( 'transaction-date' );
            $description      = $request -> input ( 'description' );
            
            if ( count ( $ledgers ) > 0 ) {
                foreach ( $ledgers as $key => $ledger_id ) {
                    $generalLedger = GeneralLedger ::findorFail ( $ledger_id );
                    
                    $generalLedger -> credit           = $request -> input ( 'transaction-type-' . $ledger_id ) === 'credit' ? $amount[ $key ] : 0;
                    $generalLedger -> debit            = $request -> input ( 'transaction-type-' . $ledger_id ) === 'debit' ? $amount[ $key ] : 0;
                    $generalLedger -> transaction_date = date ( 'Y-m-d', strtotime ( $transaction_date ) );
                    $generalLedger -> description      = $description;
                    
                    $generalLedger -> update ();
                }
            }
            
        }
        
        public function trialBalance () {
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                return Account ::withSum ( 'trial_balance as totalCredit', 'credit' )
                    -> withSum ( 'trial_balance as totalDebit', 'debit' )
                    -> has ( 'trial_balance' )
                    -> get ();
            }
            return [];
        }
        
        public function customersTrialBalance () {
            $account_head_id = config ( 'constants.account_receivable' );
            $record          = Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> with ( 'running_balance' )
                -> withSum ( 'trial_balance as totalCredit', 'credit' )
                -> withSum ( 'trial_balance as totalDebit', 'debit' );
            
            if ( request () -> has ( 'user-id' ) && request () -> filled ( 'user-id' ) ) {
                $user_id = request ( 'user-id' );
                $user    = User ::find ( $user_id );
                
                if ( $user ) {
                    $user -> load ( 'customers' );
                    $customers = $user -> customers -> pluck ( 'account_head_id' ) -> toArray ();
                    $record -> whereIn ( 'id', $customers );
                }
            }
            
            return $record -> orderBy ( 'name', 'ASC' ) -> get ();
        }
        
        public function vendorsTrialBalance () {
            $account_head_id = config ( 'constants.account_payable' );
            return Account ::where ( [ 'account_head_id' => $account_head_id ] ) -> with ( 'running_balance' ) -> withSum ( 'trial_balance as totalCredit', 'credit' ) -> withSum ( 'trial_balance as totalDebit', 'debit' ) -> orderBy ( 'name', 'ASC' ) -> get ();
        }
        
        public function get_account_head_running_balance ( $account_head_id, $sale = null ) {
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                $account -> where ( [ 'branch_id' => $branch_id ] );
            }
            
            if ( request () -> has ( 'start-date' ) && request () -> filled ( 'start-date' ) && request () -> has ( 'end-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            else if ( request () -> routeIs ( 'balance-sheet' ) && request () -> filled ( 'start-date' ) ) {
                $financial_year = FinancialYear ::first ();
                $start_date     = $financial_year -> start_date;
                $end_date       = request () -> input ( 'start-date' );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            
            else if ( !empty( $sale ) ) {
                $ledger = GeneralLedger ::where ( [ 'invoice_no' => $sale -> id, 'account_head_id' => $account_head_id ] ) -> first ();
                
                if ( !empty( $ledger ) ) {
                    $account -> where ( DB ::raw ( 'DATE(transaction_date)' ), '<=', date ( 'Y-m-d', strtotime ( $sale -> created_at ) ) );
                    $account -> where ( function ( $query ) use ( $ledger ) {
                        $query -> where ( 'id', '<', $ledger -> id );
                    } );
                }
            }
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            $running_balance = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $record -> debit - $record -> credit;
                    else
                        $running_balance = $running_balance - $record -> debit + $record -> credit;
                }
            }
            
            return $running_balance;
        }
        
        function update_account_head ( $model ) {
            $model -> account_head () -> update ( [ 'name' => $model -> name ] );
        }
        
        public function account_heads_not_linked_with_user ( $user_id = 0 ) {
            $account_head_id = config ( 'constants.customers' );
            $account_heads   = Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> whereNotIn ( 'id', function ( $query ) {
                    $query -> select ( 'account_head_id' ) -> from ( 'user_account_heads' );
                } );
            
            if ( $user_id > 0 ) {
                $account_heads -> orWhereIn ( 'id', function ( $query ) use ( $user_id ) {
                    $query -> select ( 'account_head_id' )
                        -> from ( 'user_account_heads' )
                        -> where ( 'user_id', $user_id );
                } );
            }
            
            return $account_heads -> get ();
        }
        
        public function delete_transactions () {
            $ledgers = request ( 'ledgers' );
            if ( count ( $ledgers ) > 0 ) {
                foreach ( $ledgers as $ledger ) {
                    GeneralLedger ::where ( [ 'id' => $ledger ] ) -> delete ();
                }
            }
        }
        
        public function getRecursiveAccountHeads ( $parentID = 0 ): array {
            if ( $parentID > 0 ) {
                $result  = Account ::where ( [ 'account_head_id' => $parentID, 'active' => '1' ] ) -> get () -> toArray ();
                $records = array ();
                
                foreach ( $result as $row ) {
                    $id                = $row[ 'id' ];
                    $row[ 'children' ] = $this -> getRecursiveAccountHeads ( $id );
                    $records[]         = $row;
                }
                
                return $records;
            }
            return array ();
        }
        
        public function add_transaction_detail ( $request, $account_head ) {
            $sales      = $request -> input ( 'sales', [] );
            $stocks     = $request -> input ( 'stocks', [] );
            $voucher_no = request () -> input ( 'voucher-no' );
            
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $account_head -> id,
                                                                   'customer_id'       => $request -> input ( 'account-head-id-2' ),
                                                                   'sale_id'           => $sale_id,
                                                                   'voucher'           => $voucher_no,
                                                                   'voucher_no'        => $account_head -> voucher_no,
                                                               ] );
                }
            }
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $account_head -> id,
                                                                   'vendor_id'         => $request -> input ( 'account-head-id-2' ),
                                                                   'stock_id'          => $stock_id,
                                                                   'voucher'           => $voucher_no,
                                                                   'voucher_no'        => $account_head -> voucher_no,
                                                               ] );
                }
            }
            
        }
        
        public function get_transaction_details_by_search ( $voucher_no ) {
            return !empty( trim ( $voucher_no ) ) ? GeneralLedgerTransactionDetails ::where ( [ 'voucher_no' => $voucher_no ] ) -> get () : [];
        }
        
        public function delete_transaction_details ( $general_ledger ) {
            GeneralLedgerTransactionDetails ::where ( [ 'general_ledger_id' => $general_ledger -> id ] ) -> delete ();
        }
        
        public function update_transaction_detail ( $request, $account_head, $general_ledger ) {
            $sales      = $request -> input ( 'sales', [] );
            $stocks     = $request -> input ( 'stocks', [] );
            $voucher_no = $general_ledger -> voucher_no;
            $voucher    = explode ( '-', $voucher_no );
            $voucher    = $voucher[ 0 ];
            
            if ( count ( $sales ) > 0 ) {
                foreach ( $sales as $sale_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $general_ledger -> id,
                                                                   'customer_id'       => $general_ledger -> account_head_id,
                                                                   'sale_id'           => $sale_id,
                                                                   'voucher'           => $voucher,
                                                                   'voucher_no'        => $voucher_no,
                                                               ] );
                }
            }
            
            if ( count ( $stocks ) > 0 ) {
                foreach ( $stocks as $stock_id ) {
                    GeneralLedgerTransactionDetails ::create ( [
                                                                   'general_ledger_id' => $general_ledger -> id,
                                                                   'vendor_id'         => $general_ledger -> account_head_id,
                                                                   'stock_id'          => $stock_id,
                                                                   'voucher'           => $voucher,
                                                                   'voucher_no'        => $voucher_no,
                                                               ] );
                }
            }
            
        }
        
        public function get_account_head_by_id ( $account_head ) {
            return Account ::find ( $account_head );
        }
        
        public function get_sales_running_balance ( $account_head_id, $column = '' ) {
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                $account -> where ( [ 'branch_id' => $branch_id ] );
            }
            
            if ( request () -> has ( 'start-date' ) && request () -> filled ( 'start-date' ) && request () -> has ( 'end-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            else if ( request () -> routeIs ( 'balance-sheet' ) && request () -> filled ( 'start-date' ) ) {
                $financial_year = FinancialYear ::first ();
                $start_date     = $financial_year -> start_date;
                $end_date       = request () -> input ( 'start-date' );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $end_date ] );
            }
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            $running_balance = 0;
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( $column === 'credit' )
                        $running_balance = $running_balance + $record -> credit;
                    else if ( $column === 'debit' )
                        $running_balance = $running_balance + $record -> debit;
                    else {
                        if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                            $running_balance = $running_balance + $record -> debit - $record -> credit;
                        else
                            $running_balance = $running_balance - $record -> debit + $record -> credit;
                    }
                }
            }
            
            return $running_balance;
        }
        
        public function get_recursive_account_head_running_balance ( $account_head_id, $running_balance = 0 ) {
            
            $account = GeneralLedger ::query ();
            $account -> select ( 'account_head_id', 'credit', 'debit' );
            
            $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
            } );
            
            if ( request () -> filled ( 'start-date' ) ) {
                
                $financial_year = FinancialYear ::first ();
                if ( $financial_year )
                    $start_date = $financial_year -> start_date;
                else {
                    $month = date ( 'm' );
                    if ( $month < 7 )
                        $year = date ( 'Y' ) - 1;
                    else
                        $year = date ( 'Y' );
                    $start_date = $year . '-07-01';
                }
                
                $trans_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $trans_date ] );
            }
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                $account -> where ( [ 'branch_id' => $branch_id ] );
            }
            
            $records      = $account -> get ();
            $account_head = Account ::find ( $account_head_id );
            
            if ( count ( $records ) > 0 ) {
                foreach ( $records as $record ) {
                    if ( in_array ( $account_head -> account_type_id, config ( 'constants.account_type_in' ) ) )
                        $running_balance = $running_balance + $record -> debit - $record -> credit;
                    else
                        $running_balance = $running_balance - $record -> debit + $record -> credit;
                }
            }
            
            $accountHeads = Account ::where ( [ 'account_head_id' => $account_head_id ] ) -> get ();
            if ( count ( $accountHeads ) > 0 )
                $running_balance = $this -> calculate_recursive_account_heads_running_balance ( $accountHeads, $running_balance );
            
            return $running_balance;
        }
        
        public function calculate_recursive_account_heads_running_balance ( $account_heads, $running_balance ) {
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $account_headInfo ) {
                    $account_head_id = $account_headInfo -> id;
                    $account         = GeneralLedger ::query ();
                    $account -> select ( 'account_head_id', 'credit', 'debit' );
                    
                    $account -> whereIn ( 'account_head_id', function ( $query ) use ( $account_head_id ) {
                        $query -> select ( 'id' ) -> from ( 'account_heads' ) -> where ( [ 'id' => $account_head_id ] );
                    } );
                    
                    if ( request () -> filled ( 'start-date' ) ) {
                        
                        $financial_year = FinancialYear ::first ();
                        if ( $financial_year )
                            $start_date = $financial_year -> start_date;
                        else {
                            $month = date ( 'm' );
                            if ( $month < 7 )
                                $year = date ( 'Y' ) - 1;
                            else
                                $year = date ( 'Y' );
                            $start_date = $year . '-07-01';
                        }
                        
                        $trans_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                        $account -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [ $start_date, $trans_date ] );
                    }
                    
                    if ( request () -> filled ( 'branch-id' ) ) {
                        $branch_id = request ( 'branch-id' );
                        $account -> where ( [ 'branch_id' => $branch_id ] );
                    }
                    
                    $records = $account -> get ();
                    
                    if ( count ( $records ) > 0 ) {
                        foreach ( $records as $record ) {
                            if ( in_array ( $account_headInfo -> account_type_id, config ( 'constants.account_type_in' ) ) )
                                $running_balance = $running_balance + $record -> debit - $record -> credit;
                            else
                                $running_balance = $running_balance - $record -> debit + $record -> credit;
                        }
                    }
                    
                    $accountHeads = Account ::where ( [ 'account_head_id' => $account_head_id ] ) -> get ();
                    if ( count ( $accountHeads ) > 0 )
                        $running_balance = $this -> calculate_recursive_account_heads_running_balance ( $accountHeads, $running_balance );
                }
            }
            
            return $running_balance;
        }
        
        public function status ( $account ): void {
            $account -> active = !$account -> active;
            $account -> update ();
        }
        
        public function add_transactions_quick ( $request ) {
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id' ) );
            $voucher_no  = $this -> generate_voucher_no ();
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => $request -> input ( 'receive-amount' ),
                                'debit'            => 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'receive-date' ) ) ),
                                'payment_mode'     => 'cash',
                                'transaction_no'   => $request -> input ( 'reference-id' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $request -> input ( 'bank-id', config ( 'constants.cash_sale.cash_in_hand' ) ),
                                'credit'           => 0,
                                'debit'            => $request -> input ( 'receive-amount' ),
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'receive-date' ) ) ),
                                'payment_mode'     => 'cash',
                                'transaction_no'   => $request -> input ( 'reference-id' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            return $voucher_no;
        }
        
        public function process_add_transactions_quick_pay ( $request ) {
            $accountHead = Account ::findorFail ( $request -> input ( 'account-head-id' ) );
            $voucher_no  = $this -> generate_voucher_no ();
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $accountHead -> id,
                                'credit'           => 0,
                                'debit'            => $request -> input ( 'receive-amount' ),
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'receive-date' ) ) ),
                                'payment_mode'     => 'cash',
                                'transaction_no'   => $request -> input ( 'reference-id' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            $accountHead
                -> general_ledger ()
                -> create ( [
                                'user_id'          => auth () -> user () -> id,
                                'branch_id'        => auth () -> user () -> branch_id,
                                'account_head_id'  => $request -> input ( 'bank-id', config ( 'constants.cash_sale.cash_in_hand' ) ),
                                'credit'           => $request -> input ( 'receive-amount' ),
                                'debit'            => 0,
                                'transaction_date' => date ( 'Y-m-d', strtotime ( $request -> input ( 'receive-date' ) ) ),
                                'payment_mode'     => 'cash',
                                'transaction_no'   => $request -> input ( 'reference-id' ),
                                'voucher_no'       => $voucher_no,
                                'description'      => $request -> input ( 'description' )
                            ] );
            
            return $voucher_no;
        }
        
        public function customer_ageing_report () {
            $account_head_id = config ( 'constants.account_receivable' );
            $record          = Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> with ( 'running_balance' )
                -> withSum ( 'trial_balance as totalCredit', 'credit' )
                -> withSum ( 'trial_balance as totalDebit', 'debit' );
            return $record -> orderBy ( 'name', 'ASC' ) -> get ();
        }
        
        public function vendor_ageing_report () {
            $account_head_id = config ( 'constants.account_payable' );
            return Account ::where ( [ 'account_head_id' => $account_head_id ] )
                -> with ( 'running_balance' )
                -> withSum ( 'trial_balance as totalCredit', 'credit' )
                -> withSum ( 'trial_balance as totalDebit', 'debit' )
                -> orderBy ( 'name', 'ASC' )
                -> get ();
        }
    }
