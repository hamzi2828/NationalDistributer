<?php
    
    namespace App\Http\Services;
    
    use App\Models\User;
    use App\Models\UserAccountHead;
    use App\Models\UserRole;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Hash;
    use Intervention\Image\Facades\Image;
    
    class UserService {
        
        /**
         * --------------
         * @return mixed
         * get all users
         * --------------
         */
        
        public function all () {
            return User ::with ( [
                                     'roles.role',
                                     'country',
                                     'branch'
                                 ] ) -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $paginate
         * @return mixed
         * get users by pagination
         * --------------
         */
        
        public function paginated ( $paginate ) {
            return User ::latest () -> paginate ( $paginate );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save users
         * --------------
         */
        
        public function save ( $request ) {
            return User ::create ( [
                                       'country_id'  => $request -> input ( 'country-id' ),
                                       'branch_id'   => $request -> input ( 'branch-id' ),
                                       'name'        => $request -> input ( 'name' ),
                                       'email'       => $request -> input ( 'email' ),
                                       'password'    => Hash ::make ( $request -> input ( 'password' ) ),
                                       'mobile'      => $request -> input ( 'mobile' ),
                                       'identity_no' => $request -> input ( 'identity-no' ),
                                       'gender'      => $request -> input ( 'gender' ),
                                       'dob'         => Carbon ::createFromFormat ( 'Y-m-d', $request -> input ( 'dob' ) ),
                                       'avatar'      => $this -> upload_user_avatar ( $request ),
                                       'address'     => $request -> input ( 'address' ),
                                   ] );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed|void
         * upload user avatar
         * --------------
         */
        
        private function upload_user_avatar ( $request ) {
            $name     = str ( $request -> input ( 'name' ) ) -> slug ( '-' );
            $savePath = './uploads/' . $name;
            
            File ::ensureDirectoryExists ( $savePath, 0755, true );
            
            if ( $request -> hasFile ( 'avatar' ) ) {
                $filenameWithExt = $request -> file ( 'avatar' ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( 'avatar' ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                return $request -> file ( 'avatar' ) -> storeAs ( $savePath, $fileNameToStore );
            }
        }
        
        /**
         * --------------
         * @param $request
         * @param $user_id
         * @return void
         * assign roles to user
         * --------------
         */
        
        public function assign_roles ( $request, $user_id ) {
            $roles = $request -> input ( 'roles' );
            if ( count ( $roles ) > 0 ) {
                foreach ( $roles as $role_id ) {
                    if ( $role_id > 0 ) {
                        UserRole ::create ( [
                                                'user_id' => $user_id,
                                                'role_id' => $role_id
                                            ] );
                    }
                }
            }
        }
        
        /**
         * --------------
         * @param $user_id
         * @return void
         * delete user roles
         * --------------
         */
        
        public function delete_assigned_roles ( $user_id ) {
            UserRole ::where ( [ 'user_id' => $user_id ] ) -> delete ();
        }
        
        /**
         * --------------
         * @param $request
         * @param $user
         * @return void
         * update user
         * --------------
         */
        
        public function edit ( $request, $user ) {
            $user -> country_id = $request -> input ( 'country-id' );
            $user -> branch_id  = $request -> input ( 'branch-id' );
            $user -> name       = $request -> input ( 'name' );
            $user -> email      = $request -> input ( 'email' );
            
            if ( $request -> has ( 'password' ) and !empty( trim ( $request -> input ( 'password' ) ) ) )
                $user -> password = Hash ::make ( $request -> input ( 'password' ) );
            
            $user -> mobile      = $request -> input ( 'mobile' );
            $user -> identity_no = $request -> input ( 'identity-no' );
            $user -> gender      = $request -> input ( 'gender' );
            $user -> dob         = Carbon ::createFromFormat ( 'Y-m-d', $request -> input ( 'dob' ) );
            
            if ( $request -> hasFile ( 'avatar' ) )
                $user -> avatar = $this -> upload_user_avatar ( $request );
            
            $user -> address = $request -> input ( 'address' );
            $user -> update ();
        }
        
        public function theme () {
            $user          = auth () -> user ();
            $user -> theme = ( $user -> theme == 'dark-layout' ) ? 'light-layout' : 'dark-layout';
            $user -> update ();
        }
        
        public function add_customers ( $request, $user_id ): void {
            $customers = $request -> input ( 'customers' );
            
            if ( isset( $customers ) && count ( $customers ) > 0 ) {
                foreach ( $customers as $customer ) {
                    UserAccountHead ::create ( [
                                                   'user_id'         => $user_id,
                                                   'account_head_id' => $customer
                                               ] );
                }
            }
            
        }
        
        public function delete_customers ( $user_id ): void {
            UserAccountHead ::where ( [ 'user_id' => $user_id ] ) -> delete ();
            
        }
    }
