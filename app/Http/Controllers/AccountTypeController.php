<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AccountTypeRequest;
    use App\Http\Services\AccountTypeService;
    use App\Models\AccountType;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class AccountTypeController extends Controller {
        
        protected object $accountTypeService;
        
        public function __construct ( AccountTypeService $accountTypeService ) {
            $this -> accountTypeService = $accountTypeService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllAccountTypes', AccountType::class );
            $data[ 'title' ] = 'All Account Types';
            $data[ 'types' ] = $this -> accountTypeService -> all ();
            return view ( 'account-settings.account-types.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', AccountType::class );
            $data[ 'title' ] = 'Add Account Types';
            return view ( 'account-settings.account-types.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( AccountTypeRequest $request ) {
            $this -> authorize ( 'create', AccountType::class );
            try {
                DB ::beginTransaction ();
                $type = $this -> accountTypeService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $type ) and $type -> id > 0 )
                    return redirect ( route ( 'account-types.edit', [ 'account_type' => $type -> id ] ) ) -> with ( 'message', 'Account type has been added.' );
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
         * @param object $accountType
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( AccountType $accountType ) {
            $this -> authorize ( 'edit', $accountType );
            $data[ 'title' ] = 'Edit Account Types';
            $data[ 'type' ] = $accountType;
            return view ( 'account-settings.account-types.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $accountType
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( AccountTypeRequest $request, AccountType $accountType ) {
            $this -> authorize ( 'edit', $accountType );
            try {
                DB ::beginTransaction ();
                $this -> accountTypeService -> edit ( $request, $accountType );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Account type has been updated.' );
                
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
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( AccountType $accountType ) {
            $this -> authorize ( 'delete', $accountType );
            $accountType -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Account type has been deleted.' );
        }
    }
