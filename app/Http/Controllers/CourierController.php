<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CourierFormRequest;
    use App\Http\Services\CourierService;
    use App\Models\Courier;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CourierController extends Controller {
        
        protected object $courierService;
        
        public function __construct ( CourierService $courierService ) {
            $this -> courierService = $courierService;
        }
        
        public function index (): View {
            $this -> authorize ( 'all', Courier::class );
            $data[ 'title' ]    = 'All Couriers';
            $data[ 'couriers' ] = $this -> courierService -> all ();
            return view ( 'settings.couriers.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Courier::class );
            $data[ 'title' ] = 'Add Couriers';
            return view ( 'settings.couriers.create', $data );
        }
        
        public function store ( CourierFormRequest $request ) {
            $this -> authorize ( 'create', Courier::class );
            try {
                DB ::beginTransaction ();
                $account_head = $this -> courierService -> add_account_head ( $request );
                $courier = $this -> courierService -> save ( $request, $account_head );
                DB ::commit ();
                
                if ( !empty( $courier ) and $courier -> id > 0 )
                    return redirect () -> back () -> with ( 'message', 'Courier has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Courier $courier ) {
            $this -> authorize ( 'edit', $courier );
            $data[ 'title' ]   = 'Edit Courier';
            $data[ 'courier' ] = $courier;
            return view ( 'settings.couriers.update', $data );
        }
        
        public function update ( CourierFormRequest $request, Courier $courier ) {
            $this -> authorize ( 'update', $courier );
            try {
                DB ::beginTransaction ();
                $this -> courierService -> edit ( $request, $courier );
                $this -> courierService -> update_account_head ( $courier );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Courier has been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Courier $courier ) {
            $this -> authorize ( 'delete', $courier );
            try {
                DB ::beginTransaction ();
                $this -> courierService -> delete ( $courier );
                $this -> courierService -> delete_account_head ( $courier );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Courier has been deleted.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
