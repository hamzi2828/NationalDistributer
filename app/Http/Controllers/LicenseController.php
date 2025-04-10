<?php

    namespace App\Http\Controllers;

    use App\Http\Services\LicenseService;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Log;

    class LicenseController extends Controller {

        public function __construct () {
            $cookie = Cache ::get ( 'license-key' );

            if ( isset( $cookie ) && !empty( trim ( $cookie ) ) ) {
                abort ( 404 );
            }
        }

        public function product_verification () {
            $data[ 'title' ] = 'Product Verification';
            return view ( 'verifications.index', $data );
        }

        public function verify_product ( Request $request ) {
            try {
                $verified = ( new LicenseService() ) -> verify ( $request );
                if ( $verified )
                    return redirect () -> route ( 'login' ) -> with ( 'message', 'Success! Product is not verified.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Invalid License key.' );
            }
            catch ( QueryException $exception ) {
                Log ::info ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
            catch ( Exception $exception ) {
                Log ::info ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
        }

    }
