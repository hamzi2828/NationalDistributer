<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\VendorRequest;
    use App\Http\Services\AccountRoleService;
    use App\Http\Services\AccountService;
    use App\Http\Services\VendorService;
    use App\Models\Account;
    use App\Models\Vendor;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class VendorController extends Controller {

        protected object $vendorService;
        protected object $accountRoleService;
        protected object $accountService;

        public function __construct ( VendorService $vendorService, AccountService $accountService, AccountRoleService $accountRoleService ) {
            $this -> vendorService = $vendorService;
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
            $this -> authorize ( 'viewAllVendors', Vendor::class );
            $data[ 'title' ] = 'All Vendors';
            $data[ 'vendors' ] = $this -> vendorService -> all ();
            return view ( 'vendors.index', $data );
        }

        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function create () {
            $this -> authorize ( 'create', Vendor::class );
            $data[ 'title' ] = 'Add Vendors';
            $data[ 'account_heads' ] = $this -> accountService -> convertToOptions ();
            $data[ 'account_roles' ] = $this -> accountRoleService -> all ();
            return view ( 'vendors.create', $data );
        }

        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function store ( VendorRequest $request ) {
            $this -> authorize ( 'create', Vendor::class );
            try {
                DB ::beginTransaction ();
                $account = $this -> vendorService -> save_account_head ( $request );
                $vendor = $this -> vendorService -> save ( $request, $account -> id );
                DB ::commit ();

                if ( !empty( $vendor ) and $vendor -> id > 0 )
                    return redirect ( route ( 'vendors.edit', [ 'vendor' => $vendor -> id ] ) ) -> with ( 'message', 'Vendor has been added.' );
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
         * @param object $vendor
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function edit ( Vendor $vendor ) {
            $this -> authorize ( 'edit', $vendor );
            $data[ 'title' ] = 'Edit Vendors';
            $data[ 'vendor' ] = $vendor;
            return view ( 'vendors.update', $data );
        }

        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $vendor
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function update ( VendorRequest $request, Vendor $vendor ) {
            $this -> authorize ( 'edit', $vendor );
            try {
                DB ::beginTransaction ();
                $this -> vendorService -> edit ( $request, $vendor );
                ( new AccountService() ) -> update_account_head ( $vendor );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Vendor has been updated.' );

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
         * @param object $vendor
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function destroy ( Vendor $vendor ) {
            $this -> authorize ( 'delete', $vendor );
            $vendor -> delete ();

            return redirect () -> back () -> with ( 'message', 'Vendor has been deleted.' );
        }
        
        public function status ( Vendor $vendor ) {
            $this -> authorize ( 'status', $vendor );
            $vendor -> active = !$vendor -> active;
            $vendor -> update ();
            
            $accountHead = Account ::find ( $vendor -> account_head_id );
            if ( $accountHead ) {
                $accountHead -> active = !$accountHead -> active;
                $accountHead -> update ();
            }
            
            return redirect () -> back () -> with ( 'message', 'Vendor status has been updated.' );
        }
    }
