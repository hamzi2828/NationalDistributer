<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CouponFormRequest;
    use App\Http\Services\CouponService;
    use App\Models\Coupon;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    
    class CouponController extends Controller {
        
        protected object $couponService;
        
        public function __construct ( CouponService $couponService ) {
            $this -> couponService = $couponService;
        }
        
        public function index (): View {
            $this -> authorize ( 'all', Coupon::class );
            $data[ 'title' ]   = 'All Coupons';
            $data[ 'coupons' ] = $this -> couponService -> all ();
            
            return view ( 'settings.coupons.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Coupon::class );
            $data[ 'title' ] = 'Add Coupons';
            return view ( 'settings.coupons.create', $data );
        }
        
        public function store ( CouponFormRequest $request ) {
            $this -> authorize ( 'create', Coupon::class );
            try {
                DB ::beginTransaction (); 
                $coupon = $this -> couponService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $coupon ) and $coupon -> id > 0 )
                    return redirect () -> back () -> with ( 'message', 'Coupon has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Coupon $coupon ): View {
            $this -> authorize ( 'edit', $coupon );
            $data[ 'title' ]  = 'Edit Coupon';
            $data[ 'coupon' ] = $coupon;
            return view ( 'settings.coupons.update', $data );
        }
        
        public function update ( CouponFormRequest $request, Coupon $coupon ) {
            $this -> authorize ( 'update', $coupon );
            try {
                DB ::beginTransaction ();
                $this -> couponService -> edit ( $request, $coupon );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Coupon has been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Coupon $coupon ) {
            $this -> authorize ( 'delete', $coupon );
            try {
                DB ::beginTransaction ();
                $this -> couponService -> delete ( $coupon );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Coupon has been deleted.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function updateStatus(Request $request, Coupon $coupon)
        {
            
            $this->authorize('delete', $coupon);
    
            $coupon->status = $coupon->status === 'active' ? 'inactive' : 'active';
            $coupon->save();
    
            return redirect()->back()->with('success', 'Category status updated successfully.');
        }
    }
