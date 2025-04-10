<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\HomeSettingService;
    use App\Models\HomeSetting;
    use App\Models\Newsletter;

    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class HomeSettingController extends Controller {
        
        public function index () {
            //
        }
        
        public function create (): View {
            $this -> authorize ( 'create', HomeSetting::class );
            $data[ 'title' ]    = 'Home Page Settings';
            $data[ 'settings' ] = HomeSetting ::first ();
            return view ( 'settings.home-settings.create', $data );
        }
        
        public function store ( Request $request ) {
            $this -> authorize ( 'create', HomeSetting::class );
            try {
                DB ::beginTransaction ();
                ( new HomeSettingService() ) -> save ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Home page settings have been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function newsletter_email()
        {
            $data['title']    = 'Newsletter Settings';
            $data['settings'] = Newsletter::all();
        
            return view('settings.home-settings.newsletter', $data);
        }
        
        
        public function show ( $id ) {
            //
        }
        
        public function edit ( $id ) {
            //
        }
        
        public function update ( Request $request, $id ) {
            //
        }
        
        public function destroy ( $id ) {
            //
        }
    }
