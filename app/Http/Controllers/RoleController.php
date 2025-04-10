<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\RoleRequest;
    use App\Http\Services\PermissionService;
    use App\Http\Services\RoleService;
    use App\Models\Role;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class RoleController extends Controller {
        
        protected object $roleService;
        protected object $permissionService;
        
        public function __construct ( RoleService $roleService, PermissionService $permissionService ) {
            $this -> roleService = $roleService;
            $this -> permissionService = $permissionService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllRoles', Role::class );
            $data[ 'title' ] = 'All Roles';
            $data[ 'roles' ] = $this -> roleService -> all ();
            return view ( 'user-management.roles.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Role::class );
            $data[ 'title' ] = 'Add Roles';
            return view ( 'user-management.roles.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( RoleRequest $request ) {
            $this -> authorize ( 'create', Role::class );
            try { 
                DB ::beginTransaction ();
                $role = $this -> roleService -> save ( $request );
                $this -> permissionService -> save ( $request, $role -> id );
                DB ::commit ();
                
                if ( !empty( $role ) and $role -> id > 0 )
                    return redirect ( route ( 'roles.edit', [ 'role' => $role -> id ] ) ) -> with ( 'message', 'Role has been created.' );
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
         * @param object $role
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Role $role ) {
            $this -> authorize ( 'edit', $role );
            $data[ 'title' ] = 'Edit Roles';
            $data[ 'role' ] = $role;
            return view ( 'user-management.roles.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $role
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( RoleRequest $request, Role $role ) {
            $this -> authorize ( 'edit', $role );
            try {
                DB ::beginTransaction ();
                $this -> roleService -> edit ( $request, $role );
                $this -> permissionService -> edit ( $request, $role -> id );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Role has been updated.' );
                
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
        
        public function destroy ( Role $role ) {
            $this -> authorize ( 'delete', $role );
        }
    }
