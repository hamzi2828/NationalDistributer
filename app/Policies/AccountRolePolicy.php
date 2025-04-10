<?php
    
    namespace App\Policies;
    
    use App\Models\AccountRole;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class AccountRolePolicy {
        use HandlesAuthorization;
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewAccountRolesMenu ( User $user ) {
            if ( in_array ( 'account-roles-privilege', $user -> permissions () ) )
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
        
        public function viewAllAccountRoles ( User $user ) {
            if ( in_array ( 'all-account-roles-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\AccountRole $accountRole
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit ( User $user, AccountRole $accountRole ) {
            if ( in_array ( 'edit-account-roles-privilege', $user -> permissions () ) )
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
            if ( in_array ( 'add-account-roles-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\AccountRole $accountRole
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function update ( User $user, AccountRole $accountRole ) {
            if ( in_array ( 'edit-account-roles-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\AccountRole $accountRole
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function delete ( User $user, AccountRole $accountRole ) {
            if ( in_array ( 'delete-account-roles-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\AccountRole $accountRole
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function restore ( User $user, AccountRole $accountRole ) {
            //
        }
        
        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\AccountRole $accountRole
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function forceDelete ( User $user, AccountRole $accountRole ) {
            //
        }
    }
