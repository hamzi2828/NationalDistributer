<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\IssuanceRequest;
    use App\Http\Services\BranchService;
    use App\Http\Services\IssuanceService;
    use App\Http\Services\ProductService;
    use App\Models\Issuance;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class IssuanceController extends Controller {
        
        private object $issuanceService;
        private object $branchService;
        private object $productService;
        
        public function __construct ( IssuanceService $issuanceService, BranchService $branchService, ProductService $productService ) {
            $this -> issuanceService = $issuanceService;
            $this -> branchService = $branchService;
            $this -> productService = $productService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
         
        public function index () {
            $this -> authorize ( 'viewAllIssuance', Issuance::class );
            $data[ 'title' ] = 'All Transfers';
            $data[ 'issuance' ] = $this -> issuanceService -> all ();
            return view ( 'issuance.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Issuance::class );
            $data[ 'title' ] = 'Add Transfer';
            $data[ 'branches' ] = $this -> branchService -> all ();
            $data[ 'products' ] = $this -> productService -> all ();
            return view ( 'issuance.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( IssuanceRequest $request ) {
            $this -> authorize ( 'create', Issuance::class );
            try {
                DB ::beginTransaction ();
                $issuance = $this -> issuanceService -> save ( $request );
                $this -> issuanceService -> issue_products ( $request, $issuance -> id );
                DB ::commit ();
                
                if ( !empty( $issuance ) and $issuance -> id > 0 )
                    return redirect ( route ( 'issuance.edit', [ 'issuance' => $issuance -> id ] ) ) -> with ( 'message', 'Issuance has been added.' );
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
        
        public function edit ( Issuance $issuance ) {
            $this -> authorize ( 'edit', $issuance );
            $data[ 'title' ] = 'Edit Transfer';
            $data[ 'branches' ] = $this -> branchService -> all ();
            $data[ 'issuance' ] = $issuance -> load ( 'products.product' );
            return view ( 'issuance.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( Request $request, Issuance $issuance ) {
            $this -> authorize ( 'edit', $issuance );
            try {
                DB ::beginTransaction ();
                $this -> issuanceService -> delete_issued_products ( $issuance -> id );
                $this -> issuanceService -> issue_products ( $request, $issuance -> id );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Issuance has been updated.' );
                
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
         * @param Issuance $issuance
         * @return \Illuminate\Http\RedirectResponse
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * move issuance to specific branch, add new stock
         * mark issuance as received
         * --------------
         */
        
        public function received ( Issuance $issuance ) {
            $this -> authorize ( 'received', $issuance );
            try {
                DB ::beginTransaction ();
                $this -> issuanceService -> received ( $issuance );
                $this -> issuanceService -> move_issuance_to_branch ( $issuance );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Issuance has been marked as received.' );
                
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
        
        public function destroy ( Issuance $issuance ) {
            $this -> authorize ( 'delete', $issuance );
            $issuance -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Issuance has been deleted.' );
        }
    }
