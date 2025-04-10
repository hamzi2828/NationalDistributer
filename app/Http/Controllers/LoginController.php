<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\LoginRequest;
    use App\Http\Services\LoginService;
    use Exception;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    
    class LoginController extends Controller {
        
        private object $loginService;
        
        /**
         * --------------
         * @param LoginService $loginService
         * loads constructor classes, services...
         * --------------
         */
        
        public function __construct ( LoginService $loginService ) {
            $this -> loginService = $loginService;
        }
        
        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * loads login page
         * --------------
         */
        
        public function login () {
            $data[ 'title' ] = 'Login';
            return view ( 'login.login', $data );
        }
        
        /**
         * --------------
         * @param LoginRequest $request
         * @return \Illuminate\Http\RedirectResponse
         * authenticates user
         * --------------
         */
        
        public function authenticate ( LoginRequest $request ) {
            try {
                $user_id = $this -> loginService -> login ( $request );
                if ( $user_id > 0 )
                    return redirect () -> intended ( route ( 'home' ) );
                else
                    return redirect () -> back () -> with ( 'error', 'Invalid Credentials.' );
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
        
        /**
         * --------------
         * @param Request $request
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         * logout user
         * --------------
         */
        
        public function logout ( Request $request ) {
            $this -> loginService -> create_logout_log ();
            Auth ::logout ();
            $request -> session () -> regenerate ();
            return redirect ( route ( 'login' ) );
        }
        
    }
