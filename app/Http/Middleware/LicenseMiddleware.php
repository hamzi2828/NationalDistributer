<?php

    namespace App\Http\Middleware;

    use Closure;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Cookie;

    class LicenseMiddleware {

        /**
         * Handle an incoming request.
         * @param \Illuminate\Http\Request $request
         * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
         * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
         */

        public function handle ( Request $request, Closure $next ) {
            $cookie = Cache ::get ( 'license-key' );

            if ( !isset( $cookie ) || empty( trim ( $cookie ) ) ) {
                Auth ::logout ();
                return redirect ( route ( 'product-verification' ) );
            }

            return $next( $request );
        }
    }
