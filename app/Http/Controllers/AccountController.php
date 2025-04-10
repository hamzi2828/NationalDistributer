<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AccountRequest;
    use App\Http\Requests\AddOpeningBalanceRequest;
    use App\Http\Requests\AddQuickTransactionFormRequest;
    use App\Http\Requests\TransactionRequest;
    use App\Http\Services\AccountService;
    use App\Http\Services\AccountTypeService;
    use App\Http\Services\BranchService;
    use App\Http\Services\CustomerService;
    use App\Http\Services\GeneralLedgerService;
    use App\Http\Services\SaleService;
    use App\Http\Services\VendorService;
    use App\Models\Account;
    use App\Models\Customer;
    use App\Models\GeneralLedger;
    use App\Models\GeneralLedgerTransactionDetails;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class AccountController extends Controller {
        
        protected object $accountService;
        protected object $accountTypeService;
        protected object $generalLedgerService;
        
        public function __construct ( AccountService $accountService, AccountTypeService $accountTypeService, GeneralLedgerService $generalLedgerService ) {
            $this -> accountService       = $accountService;
            $this -> accountTypeService   = $accountTypeService;
            $this -> generalLedgerService = $generalLedgerService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllAccounts', Account::class );
            $data[ 'title' ]    = 'All Account Heads';
            $data[ 'accounts' ] = $this -> accountService -> all ();
            return view ( 'accounts.index', $data );
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function chat_of_accounts () {
            $this -> authorize ( 'viewAllAccounts', Account::class );
            $data[ 'title' ]          = 'Chart of Accounts';
            $data[ 'accounts_heads' ] = $this -> accountService -> convertToList ();
            return view ( 'accounts.chart-of-accounts', $data );
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function general_ledger () {
            $this -> authorize ( 'viewGeneralLedger', Account::class );
            $data[ 'title' ]           = 'General Ledger';
            $data[ 'account_heads' ]   = $this -> accountService -> convertToOptions ();
            $data[ 'ledgers' ]         = $this -> generalLedgerService -> filter_general_ledgers ();
            $data[ 'running_balance' ] = $this -> generalLedgerService -> get_running_balance ();
            return view ( 'accounts.general-ledger', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Account::class );
            $data[ 'title' ]         = 'Add Account Heads';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( [], 'parent', false, false );
            $data[ 'types' ]         = $this -> accountTypeService -> all ();
            return view ( 'accounts.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( AccountRequest $request ) {
            $this -> authorize ( 'create', Account::class );
            try {
                DB ::beginTransaction ();
                $account_head = $this -> accountService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $account_head ) and $account_head -> id > 0 )
                    return redirect ( route ( 'accounts.edit', [ 'account' => $account_head -> id ] ) ) -> with ( 'message', 'Account head has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $account
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Account $account ) {
            $this -> authorize ( 'edit', $account );
            $data[ 'title' ]         = 'Edit Account Heads';
            $data[ 'account' ]       = $account;
            $data[ 'account_heads' ] = $this -> accountService -> all ();
            $data[ 'types' ]         = $this -> accountTypeService -> all ();
            return view ( 'accounts.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( Request $request, Account $account ) {
            $this -> authorize ( 'edit', $account );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> edit ( $request, $account );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Account head has been updated.' );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * Remove the specified resource from storage.
         * @param object $account
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( Account $account ) {
            $this -> authorize ( 'delete', $account );
            $account -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Account head has been deleted.' );
        }
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $account
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function add_transactions () {
            $this -> authorize ( 'add_transactions', Account::class );
            $data[ 'title' ]         = 'Add Transactions';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            return view ( 'accounts.add-transactions', $data );
        }
        
        /**
         * --------------
         * @param Request $request
         * @return mixed
         * get account head type
         * --------------
         */
        
        public function get_account_head_type ( Request $request ) {
            $account_head = Account ::find ( $request -> input ( 'account_head_id' ) );
            $account_head -> load ( 'account_type' );
            return $account_head -> account_type -> type;
        }
        
        public function process_add_transactions ( TransactionRequest $request ): RedirectResponse {
            $this -> authorize ( 'add_transactions', Account::class );
            try {
                DB ::beginTransaction ();
                $account_head = $this -> accountService -> add_transactions ( $request );
                $this -> accountService -> add_transaction_detail ( $request, $account_head );
                DB ::commit ();
                
                $print = '<a href="' . route ( 'transaction', [ 'voucher-no' => $account_head -> voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';
                return redirect () -> back () -> with ( 'message', 'Transactions have been added.' . $print );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $account
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function add_opening_balance () {
            $this -> authorize ( 'add_opening_balance', Account::class );
            $data[ 'title' ]         = 'Add Opening Balance';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            return view ( 'accounts.add-opening-balance', $data );
        }
        
        /**
         * --------------
         * @param TransactionRequest $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * add transactions
         * --------------
         */
        
        public function process_add_opening_balance ( AddOpeningBalanceRequest $request ) {
            $this -> authorize ( 'add_opening_balance', Account::class );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> add_opening_balance ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Opening balance has been added.' );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $account
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function add_multiple_transactions () {
            $this -> authorize ( 'add_multiple_transactions', Account::class );
            $data[ 'title' ]         = 'Add Multiple Transactions';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            return view ( 'accounts.add-multiple-transactions', $data );
        }
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $account
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function add_more_transactions ( Request $request ) {
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            $data[ 'row' ]           = $request -> input ( 'nextRow' );
            return view ( 'accounts.add-more-transactions', $data );
        }
        
        /**
         * --------------
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * process add multiple transactions
         * --------------
         */
        
        public function process_add_multiple_transactions ( Request $request ) {
            $this -> authorize ( 'add_multiple_transactions', Account::class );
            try {
                DB ::beginTransaction ();
                $voucher_no = $this -> accountService -> add_multiple_transactions ( $request );
                DB ::commit ();
                
                $print = '<a href="' . route ( 'transaction', [ 'voucher-no' => $voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';
                return redirect () -> back () -> with ( 'message', 'Transactions have been added.' . $print );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * @param Request $request
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * search transactions
         * --------------
         */
        
        public function search_transactions ( Request $request ) {
            $this -> authorize ( 'search_transactions', Account::class );
            $data[ 'title' ]   = 'Search Transactions';
            $data[ 'ledgers' ] = $this -> generalLedgerService -> search_transactions_by_voucher ( $request );
            $data[ 'details' ] = $this -> accountService -> get_transaction_details_by_search ( $request -> input ( 'voucher-no' ) );
            return view ( 'accounts.search-transactions', $data );
        }
        
        /**
         * --------------
         * @param Request $request
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * process add multiple transactions
         * --------------
         */
        
        public function update_transactions ( Request $request ) {
            $this -> authorize ( 'search_transactions', Account::class );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> update_transactions ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Transactions have been updated.' );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function delete_transactions () {
            $this -> authorize ( 'delete_transactions', Account::class );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> delete_transactions ();
                DB ::commit ();
                
                return redirect () -> route ( 'accounts.search-transactions' ) -> with ( 'message', 'Transactions have been deleted.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function account_heads_dropdown ( Request $request ): void {
            
            $account_heads = array ();
            if ( $request -> input ( 'type' ) == 'cash' )
                $account_heads = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.cash_balances' ) );
            
            else if ( $request -> input ( 'type' ) == 'bank' )
                $account_heads = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.banks' ) );
            
            echo $this -> accountService -> convertToOptions ( $account_heads );
        }
        
        public function transaction_detail_dropdown ( Request $request ): string {
            $account_head_id = $request -> get ( 'account_head_id' );
            $account         = Account ::findorFail ( $account_head_id );
            $sales           = ( new SaleService() ) -> get_credit_sales ( $account_head_id, $account );
            $stocks          = ( new VendorService() ) -> get_vendor_stocks ( $account_head_id, $account );
            return view ( 'accounts.transaction-dropdown', compact ( 'sales', 'stocks', 'account' ) ) -> render ();
        }
        
        public function transaction_detail ( GeneralLedger $general_ledger ): View {
            $general_ledger -> load ( [ 'account_head', 'transaction_details' ] );
            $title        = 'Transaction Details';
            $account_head = Account ::where ( [ 'id' => $general_ledger -> account_head_id ] ) -> first ();
            $sales        = ( new SaleService() ) -> get_credit_sales ( $general_ledger -> account_head_id, $account_head );
            $stocks       = ( new VendorService() ) -> get_vendor_stocks ( $general_ledger -> account_head_id, $account_head );
            $vouchers     = $general_ledger -> transaction_details -> pluck ( 'voucher' ) -> toArray ();
            return view ( 'accounts.transaction-details', compact ( 'general_ledger', 'title', 'sales', 'stocks', 'vouchers' ) );
        }
        
        public function update_transaction_detail ( Request $request, GeneralLedger $general_ledger ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                $account_head = Account ::find ( $general_ledger -> account_head_id );
                $this -> accountService -> delete_transaction_details ( $general_ledger );
                $this -> accountService -> update_transaction_detail ( $request, $account_head, $general_ledger );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Transactions have been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function general_ledgers () {
            $this -> authorize ( 'viewGeneralLedger', Account::class );
            $data[ 'title' ]         = 'General Ledger';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( disabled: false );
            $account_heads           = $this -> accountService -> getRecursiveAccountHeads ( request ( 'account-head-id' ) );
            $parent_account_head     = $this -> accountService -> get_account_head_by_id ( request ( 'account-head-id' ) );
            $account_head[]          = $parent_account_head;
            $account_heads_list      = array_merge ( $account_head, $account_heads );
            $data[ 'ledgers' ]       = $this -> generalLedgerService -> build_ledgers_table ( $account_heads_list );
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            return view ( 'accounts.general-ledgers', $data );
        }
        
        public function status ( Account $account ): RedirectResponse {
            $this -> authorize ( 'status', $account );
            try {
                DB ::beginTransaction ();
                $this -> accountService -> status ( $account );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'success', 'Account head status has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                Log ::info ( $exception );
                DB ::rollBack ();
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function get_account_head_type_id ( Request $request ) {
            $account_head = Account ::find ( $request -> input ( 'account_head_id' ) );
            return $account_head -> account_type_id;
        }
        
        public function add_transactions_complex_jv () {
            $this -> authorize ( 'add_transactions_complex_jv', Account::class );
            $data[ 'title' ]         = 'Add Transactions (Complex JV)';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            return view ( 'accounts.add-transactions-complex-jv', $data );
        }
        
        public function add_more_transactions_complex_jv ( Request $request ) {
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            $data[ 'row' ]           = $request -> input ( 'nextRow' );
            return view ( 'accounts.add-more-transactions-complex-jv', $data );
        }
        
        public function add_transactions_quick () {
            $this -> authorize ( 'add_transactions_quick', Account::class );
            $data[ 'title' ]         = 'Quick Receive';
            $account_heads           = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.customers' ) );
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( $account_heads );
            return view ( 'accounts.add-transactions-quick', $data );
        }
        
        public function get_banks () {
            $account_heads           = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.banks' ) );
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( $account_heads );
            return view ( 'accounts.get-banks', $data ) -> render ();
        }
        
        public function get_account_head_running_balance ( Request $request ): float | int {
            return $this -> accountService -> get_account_head_running_balance ( $request -> input ( 'account_head_id' ) );
        }
        
        public function process_add_transactions_quick ( AddQuickTransactionFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'add_transactions_quick', Account::class );
            try {
                DB ::beginTransaction ();
                $voucher_no = $this -> accountService -> add_transactions_quick ( $request );
                DB ::commit ();
                
                $print = '<a href="' . route ( 'transaction', [ 'voucher-no' => $voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';
                return redirect () -> back () -> with ( 'message', 'Quick Transaction has been added.' . $print );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function add_transactions_quick_pay () {
            $this -> authorize ( 'add_transactions_quick_pay', Account::class );
            $data[ 'title' ]         = 'Quick Pay';
            $account_heads           = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.vendors' ) );
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( $account_heads );
            return view ( 'accounts.add-transactions-quick-pay', $data );
        }
        
        public function process_add_transactions_quick_pay ( AddQuickTransactionFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'add_transactions_quick_pay', Account::class );
            try {
                DB ::beginTransaction ();
                $voucher_no = $this -> accountService -> process_add_transactions_quick_pay ( $request );
                DB ::commit ();
                
                $print = '<a href="' . route ( 'transaction', [ 'voucher-no' => $voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';
                return redirect () -> back () -> with ( 'message', 'Quick Transaction has been added.' . $print );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function add_transactions_quick_expense () {
            $this -> authorize ( 'add_transactions_quick_expense', Account::class );
            $data[ 'title' ]         = 'Quick Expense';
            $account_heads           = ( new AccountService() ) -> getRecursiveAccountHeads ( config ( 'constants.expenses' ) );
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ( $account_heads );
            return view ( 'accounts.add-transactions-quick-expense', $data );
        }
        
        public function process_add_transactions_quick_expense ( AddQuickTransactionFormRequest $request ): RedirectResponse {
            $this -> authorize ( 'add_transactions_quick_expense', Account::class );
            try {
                DB ::beginTransaction ();
                $voucher_no = $this -> accountService -> process_add_transactions_quick_pay ( $request );
                DB ::commit ();
                
                $print = '<a href="' . route ( 'transaction', [ 'voucher-no' => $voucher_no ] ) . '" class="ms-1 text-primary text-decoration-underline" target="_blank">Print Voucher</a>';
                return redirect () -> back () -> with ( 'message', 'Quick Transaction has been added.' . $print );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
