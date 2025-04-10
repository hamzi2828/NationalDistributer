<?php
    
    namespace App\Http\Services;
    
    use App\Models\AccountRole;
    use App\Models\AccountRoleModels;
    
    class AccountRoleService {
        
        /**
         * --------------
         * @return mixed
         * get all account roles
         * --------------
         */
        
        public function all () {
            return AccountRole ::with ( [ 'role_models' ] ) -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save account roles
         * --------------
         */
        
        public function save ( $request ) {
            return AccountRole ::create ( [
                                              'user_id' => auth () -> user () -> id,
                                              'title'   => $request -> input ( 'title' ),
                                          ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $account_role_id
         * @return mixed
         * save account role models
         * --------------
         */
        
        public function save_account_role_models ( $request, $account_role_id ) {
            $account_heads = $request -> input ( 'account-head-id' );
            
            if ( count ( $account_heads ) > 0 ) {
                foreach ( $account_heads as $key => $account_head ) {
                    if ( !empty( trim ( $account_head ) ) and $account_head > 0 ) {
                        AccountRoleModels ::create ( [
                                                         'account_role_id' => $account_role_id,
                                                         'account_head_id' => $account_head,
                                                         'type'            => $request -> input ( 'type.' . $key ),
                                                     ] );
                    }
                }
            }
        }
        
        /**
         * --------------
         * @param $request
         * @param $account_role
         * @return void
         * update account roles
         * --------------
         */
        
        public function edit ( $request, $account_role ) {
            $account_role -> user_id = auth () -> user () -> id;
            $account_role -> title = $request -> input ( 'title' );
            $account_role -> update ();
        }
        
        /**
         * --------------
         * @param $request
         * @param $account_role_id
         * @return mixed
         * save account role models
         * --------------
         */
        
        public function update_account_role_models ( $request, $account_role_id ) {
            $models = $request -> input ( 'role-models' );
            
            if ( count ( $models ) > 0 ) {
                foreach ( $models as $key => $model_id ) {
                    $roleModel = AccountRoleModels ::find ( $model_id );
                    $roleModel -> type = $request -> input ( 'type.' . $key );
                    $roleModel -> update ();
                }
            }
        }
    }