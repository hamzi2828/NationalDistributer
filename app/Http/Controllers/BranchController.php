<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\BranchRequest;
    use App\Http\Services\BranchService;
    use App\Http\Services\CountryService;
    use App\Http\Services\UserService;
    use App\Models\Branch;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class BranchController extends Controller {
        
        protected object $branchService;
        protected object $userService;
        protected object $countryService;
        
        public function __construct ( BranchService $branchService, UserService $userService, CountryService $countryService ) {
            $this -> branchService = $branchService;
            $this -> userService = $userService;
            $this -> countryService = $countryService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllBranches', Branch::class );
            $data[ 'title' ] = 'All Branches';
            $data[ 'branches' ] = $this -> branchService -> all ();
            return view ( 'settings.branches.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Branch::class );
            $data[ 'title' ] = 'Add Branches';
            $data[ 'users' ] = $this -> userService -> all ();
            $data[ 'countries' ] = $this -> countryService -> all ();
            return view ( 'settings.branches.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( BranchRequest $request ) {
            $this -> authorize ( 'create', Branch::class );
            try {
                DB ::beginTransaction ();
                $branch = $this -> branchService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $branch ) and $branch -> id > 0 )
                    return redirect ( route ( 'branches.edit', [ 'branch' => $branch -> id ] ) ) -> with ( 'message', 'Branch has been created.' );
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
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Branch $branch ) {
            $this -> authorize ( 'edit', $branch );
            $data[ 'title' ] = 'Add Branches';
            $data[ 'users' ] = $this -> userService -> all ();
            $data[ 'countries' ] = $this -> countryService -> all ();
            $data[ 'branch' ] = $branch;
            return view ( 'settings.branches.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $branch
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( Request $request, Branch $branch ) {
            $this -> authorize ( 'edit', $branch );
            try {
                DB ::beginTransaction ();
                $this -> branchService -> edit ( $request, $branch );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Branch has been updated.' );
                
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
         * @param object $branch
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( Branch $branch ) {
            $this -> authorize ( 'delete', Branch::class );
            try {
                DB ::beginTransaction ();
                $this -> branchService -> delete ( $branch );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Branch has been deleted.' );
                
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
    }
