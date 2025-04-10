<?php
    
    namespace App\Http\Services;
    
    use App\Models\Role;
    
    class RoleService {
        
        /**
         * --------------
         * @return mixed
         * get all roles by latest
         * --------------
         */
        
        public function all () {
            return Role ::latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save roles
         * --------------
         */
        
        public function save ( $request ) {
            return Role ::create ( [
                                       'user_id' => auth () -> user () -> id,
                                       'title'   => $request -> input ( 'title' ),
                                       'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                   ] );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * edit roles
         * --------------
         */
        
        public function edit ( $request, $role ) {
            $role -> user_id = auth () -> user () -> id;
            $role -> title = $request -> input ( 'title' );
            $role -> update ();
        }
        
    }