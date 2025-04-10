<?php
    
    namespace App\Policies;
    
    use App\Models\Issuance;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class IssuancePolicy {
        use HandlesAuthorization;
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewIssuanceMenu ( User $user ) {
            if ( in_array ( 'issuance-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewAllIssuance ( User $user ) {
            if ( in_array ( 'all-issuance-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Issuance $issuance
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit ( User $user, Issuance $issuance ) {
            if ( ( in_array ( 'edit-issuance-privilege', $user -> permissions () ) && $issuance -> user_id == $user -> id && $issuance -> received != '1' ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can create models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function create ( User $user ) {
            if ( in_array ( 'add-issuance-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Issuance $issuance
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function update ( User $user, Issuance $issuance ) {
            if ( ( in_array ( 'edit-issuance-privilege', $user -> permissions () ) && $issuance -> user_id == $user -> id && $issuance -> received != '1' ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Issuance $issuance
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function received ( User $user, Issuance $issuance ) {
            if ( ( in_array ( 'received-issuance-privilege', $user -> permissions () ) && $issuance -> received != '1' ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Issuance $issuance
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function delete ( User $user, Issuance $issuance ) {
            if ( ( in_array ( 'delete-issuance-privilege', $user -> permissions () ) && $issuance -> user_id == $user -> id && $issuance -> received != '1' ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\Issuance $issuance
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function restore ( User $user, Issuance $issuance ) {
            //
        }
        
        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Issuance $issuance
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function forceDelete ( User $user, Issuance $issuance ) {
            //
        }
        
        public function print ( User $user ): bool {
            if ( ( in_array ( 'print-issuance-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
        
        public function p_print ( User $user ): bool {
            if ( ( in_array ( 'p-print-issuance-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
    }
