<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\CourierService;
    use App\Http\Services\SiteSettingService;
    use App\Models\SiteSettings;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class SiteSettingsController extends Controller {
        
        public function create () { 
            $this -> authorize ( 'create', SiteSettings::class );
            $data[ 'title' ]    = 'Site Settings';
            $data[ 'settings' ] = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            $data[ 'couriers' ] = ( new CourierService() ) -> all ();
            return view ( 'settings.site-settings.create', $data );
        }  
        
        public function store ( Request $request ) {
            $this -> authorize ( 'create', SiteSettings::class );

            try {
                DB ::beginTransaction ();
                ( new SiteSettingService() ) -> save ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Settings have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
