<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\UserRequest;
    use App\Http\Services\AccountService;
    use App\Http\Services\BranchService;
    use App\Http\Services\CountryService;
    use App\Http\Services\CustomerService;
    use App\Http\Services\RoleService;
    use App\Http\Services\UserService;
    use App\Models\User;
    use App\Policies\UserPolicy;
    use Exception;
    use Illuminate\Database\QueryException;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class UserController extends Controller {

        private object $userService;
        private object $countryService;
        private object $branchService;
        private object $roleService;

        public function __construct ( UserService $userService, CountryService $countryService, BranchService $branchService, RoleService $roleService ) {
            $this -> userService    = $userService;
            $this -> countryService = $countryService;
            $this -> branchService  = $branchService;
            $this -> roleService    = $roleService;
        }

        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function index () {
            $this -> authorize ( 'viewAllUsers', User::class );
            $data[ 'title' ] = 'All Users';
            $data[ 'users' ] = $this -> userService -> all ();
            return view ( 'users.index', $data );
        }

        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function create () {
            $this -> authorize ( 'create', User::class );
            $data[ 'title' ]     = 'Add Users';
            $data[ 'countries' ] = $this -> countryService -> all ();
            $data[ 'branches' ]  = $this -> branchService -> all ();
            $data[ 'roles' ]     = $this -> roleService -> all ();
            $data[ 'customers' ] = ( new AccountService() ) -> account_heads_not_linked_with_user ();
            return view ( 'users.create', $data );
        }

        /**
         * --------------
         * @param UserRequest $request
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         * Store a newly created resource in storage.
         * --------------
         */

        public function store ( UserRequest $request ) {
            $this -> authorize ( 'create', User::class );
            try {
                DB ::beginTransaction ();
                $user = $this -> userService -> save ( $request );
                $this -> userService -> assign_roles ( $request, $user -> id );
                $this -> userService -> add_customers ( $request, $user -> id );
                DB ::commit ();

                if ( !empty( $user ) and $user -> id > 0 )
                    return redirect ( route ( 'users.edit', [ 'user' => $user -> id ] ) ) -> with ( 'message', 'User has been created.' );
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
         * @param int $user
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function edit ( User $user ) {
            $this -> authorize ( 'edit', User::class );
            $data[ 'title' ]          = 'Edit Users';
            $data[ 'user' ]           = $user -> load ( [ 'roles', 'customers' ] );
            $data[ 'countries' ]      = $this -> countryService -> all ();
            $data[ 'branches' ]       = $this -> branchService -> all ();
            $data[ 'roles' ]          = $this -> roleService -> all ();
            $data[ 'customers' ]      = ( new AccountService() ) -> account_heads_not_linked_with_user ( $user -> id );
            $data[ 'user_customers' ] = ( $user -> customers && count ( $user -> customers ) > 0 ) ? $user -> customers -> pluck ( 'account_head_id' ) -> toArray () : array ();
            return view ( 'users.update', $data );
        }

        /**
         * --------------
         * @param UserRequest $request
         * @param User $user
         * @return \Illuminate\Http\RedirectResponse
         * Update the specified resource in storage.
         * --------------
         */

        public function update ( UserRequest $request, User $user ) {
            $this -> authorize ( 'update', $user );
            try {
                DB ::beginTransaction ();
                $this -> userService -> edit ( $request, $user );
                $this -> userService -> delete_assigned_roles ( $user -> id );
                $this -> userService -> assign_roles ( $request, $user -> id );
                $this -> userService -> delete_customers ( $user -> id );
                $this -> userService -> add_customers ( $request, $user -> id );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'User has been updated.' );
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
         * @param int $user
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function destroy ( User $user ) {
            $this -> authorize ( 'delete', $user );
            $user -> delete ();
            return redirect () -> back () -> with ( 'message', 'User has been deleted.' );
        }

        public function status(User $user)
        {
            $this->authorize('status', $user);
             // Store the previous status
            $previousStatus = $user->status;
           if($previousStatus == 'Inactive'){
            $previousStatus = 'Active';
            $user->status = '1';
            $user->save();
            return redirect()->back()->with('message', 'User status has been updated.');
           }
            else{
            // Toggle the status
            $user->status = !$user->status;
            $user->save();
            }
            return redirect()->back()->with('message', 'User status has been updated.');
        }


        public function theme () {
            try {
                DB ::beginTransaction ();
                $this -> userService -> theme ();
                DB ::commit ();
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
            }
        }

    }
