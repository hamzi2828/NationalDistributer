<?php

    namespace App\Http\Services;

    use App\Models\SiteSettings;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Crypt;

    class LicenseService {

        public function verify ( $request ) {
            $key = $request -> input ( 'license-key' );

            if ( !preg_match ( '/^[a-zA-Z0-9\-]+$/', $key ) )
                return false;

            $settings = SiteSettings ::where ( [ 'license_key' => $key ] ) -> first ();
            if ( empty( $settings ) )
                return false;
            else {
                $key = Crypt ::encrypt ( $key );
                Cache ::put ( 'license-key', $key, now () -> addYears ( 5 ) );
                return true;
            }

        }

    }
