<?php
    
    namespace App\Http\Services;
    
    use Illuminate\Support\Facades\Auth;
    
    class LoginService {
        
        /**
         * --------------
         * @param $request
         * @return false
         * authenticate user
         * --------------
         */
        
        public function login ( $request ) {
            $credentials = array (
                'email'    => $request -> input ( 'login-email' ),
                'password' => $request -> input ( 'login-password' ),
                'status'   => '1',
                'type'     => null
            );
            
            $remember = $request -> input ( 'remember-me' );
            if ( isset( $remember ) and $remember == '1' )
                $remember = true;
            else
                $remember = false;
            
            if ( Auth ::attempt ( $credentials, $remember ) ) {
                $this -> create_login_log ();
                $request -> session () -> regenerate ();
                return auth () -> user () -> id;
            }
            else
                return false;
        }
        
        /**
         * --------------
         * @return void
         * create log for user login
         * --------------
         */
        
        public function create_login_log () {
            $user = auth () -> user ();
            $user -> logs () -> create ( [
                                             'user_id' => $user -> id,
                                             'action'  => 'user-logged-in',
                                             'log'     => auth () -> user (),
                                         ] );
        }
        
        /**
         * --------------
         * @return void
         * create log for user logout
         * --------------
         */
        
        public function create_logout_log () {
            $user = auth () -> user ();
            $user -> logs () -> create ( [
                                             'user_id' => $user -> id,
                                             'action'  => 'user-logout',
                                             'log'     => auth () -> user (),
                                         ] );
        }
        
    }