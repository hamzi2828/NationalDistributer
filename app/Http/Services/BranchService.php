<?php
    
    namespace App\Http\Services;
    
    use App\Models\Branch;
    
    class BranchService {
        
        public function all () {
            return Branch ::with ( [
                                       'manager',
                                       'country'
                                   ] ) -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save branches
         * --------------
         */
        
        public function save ( $request ) {
            return Branch ::create ( [
                                         'user_id'           => auth () -> user () -> id,
                                         'branch_manager_id' => $request -> input ( 'branch-manager-id' ),
                                         'country_id'        => $request -> input ( 'country-id' ),
                                         'code'              => $request -> input ( 'code' ),
                                         'name'              => $request -> input ( 'name' ),
                                         'landline'          => $request -> input ( 'landline' ),
                                         'mobile'            => $request -> input ( 'mobile' ),
                                         'address'           => $request -> input ( 'address' ),
                                     ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $branch
         * @return void
         * update branch
         * --------------
         */
        
        public function edit ( $request, $branch ) {
            $branch -> user_id           = auth () -> user () -> id;
            $branch -> branch_manager_id = $request -> input ( 'branch-manager-id' );
            $branch -> country_id        = $request -> input ( 'country-id' );
            $branch -> code              = $request -> input ( 'code' );
            $branch -> name              = $request -> input ( 'name' );
            $branch -> landline          = $request -> input ( 'landline' );
            $branch -> mobile            = $request -> input ( 'mobile' );
            $branch -> address           = $request -> input ( 'address' );
            $branch -> update ();
        }
        
        /**
         * --------------
         * @param $branch
         * @return void
         * delete branch
         * --------------
         */
        
        public function delete ( $branch ) {
            $branch -> delete ();
        }
        
        public function get_branch_by_id ( $branch_id ) {
            return Branch ::find ( $branch_id );
        }
        
    }