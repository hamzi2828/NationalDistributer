<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AccountRoleRequest;
    use App\Http\Services\AccountRoleService;
    use App\Http\Services\AccountService;
    use App\Models\Account;
    use App\Models\AccountRole;
    use Illuminate\Database\QueryException;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class AccountRoleController extends Controller {
        
        protected object $accountRoleService;
        protected object $accountService;
        
        public function __construct ( AccountRoleService $accountRoleService, AccountService $accountService ) {
            $this -> accountRoleService = $accountRoleService;
            $this -> accountService = $accountService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllAccountRoles', AccountRole::class );
            $data[ 'title' ] = 'All Account Roles';
            $data[ 'roles' ] = $this -> accountRoleService -> all ();
            return view ( 'account-settings.account-roles.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', AccountRole::class );
            $data[ 'title' ] = 'Add Account Roles';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            return view ( 'account-settings.account-roles.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( AccountRoleRequest $request ) {
            $this -> authorize ( 'create', AccountRole::class );
            try {
                DB ::beginTransaction ();
                $role = $this -> accountRoleService -> save ( $request );
                $this -> accountRoleService -> save_account_role_models ( $request, $role -> id );
                DB ::commit ();
                
                if ( !empty( $role ) and $role -> id > 0 )
                    return redirect ( route ( 'account-roles.edit', [ 'account_role' => $role -> id ] ) ) -> with ( 'message', 'Account role has been added.' );
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
         * @param object $accountRole
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( AccountRole $accountRole ) {
            $this -> authorize ( 'edit', $accountRole );
            $data[ 'title' ] = 'Edit Account Roles';
            $data[ 'role' ] = $accountRole -> load ( [ 'role_models' ] );
            return view ( 'account-settings.account-roles.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $accountRole
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( AccountRoleRequest $request, AccountRole $accountRole ) {
            $this -> authorize ( 'edit', $accountRole );
            try {
                DB ::beginTransaction ();
                $this -> accountRoleService -> edit ( $request, $accountRole );
                $this -> accountRoleService -> update_account_role_models ( $request, $accountRole );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Account role has been updated.' );
                
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
         * @param object $accountRole
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( AccountRole $accountRole ) {
            $this -> authorize ( 'delete', $accountRole );
            $accountRole -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Account role has been deleted.' );
        }
    }
