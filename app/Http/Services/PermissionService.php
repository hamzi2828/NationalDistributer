<?php
    
    namespace App\Http\Services;
    
    use App\Models\Permission;
    
    class PermissionService {
        
        /**
         * --------------
         * @param $request
         * @param $role_id
         * @return mixed
         * save permission
         * --------------
         */
        
        public function save ( $request, $role_id ) {
            return Permission ::create ( [
                                             'user_id'    => auth () -> user () -> id,
                                             'role_id'    => $role_id,
                                             'permission' => $request -> input ( 'privilege' ),
                                         ] );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * edit permission
         * --------------
         */
        
        public function edit ( $request, $role_id ) {
            $permission = Permission ::where ( [ 'role_id' => $role_id ] ) -> first ();
            if ( !empty( $permission ) ) {
                $permission -> user_id = auth () -> user () -> id;
                $permission -> permission = $request -> input ( 'privilege' );
                $permission -> update ();
            }
            else {
                $this -> save ( $request, $role_id );
            }
        }
        
    }