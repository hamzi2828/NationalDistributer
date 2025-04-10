<?php
    
    namespace App\Observers;
    
    use App\Models\UserRole;
    
    class UserRoleObserver {
        
        /**
         * --------------
         * Handle the UserRole "created" event.
         * @param \App\Models\UserRole $userRole
         * @return void
         * --------------
         */
        
        public function created ( UserRole $userRole ) {
            $userRole -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'user-role-created',
                                                 'log'     => $userRole
                                             ] );
        }
        
        /**
         * --------------
         * Handle the UserRole "updated" event.
         * @param \App\Models\UserRole $userRole
         * @return void
         * --------------
         */
        
        public function updated ( UserRole $userRole ) {
            $userRole -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'user-role-updated',
                                                 'log'     => $userRole
                                             ] );
        }
        
        /**
         * --------------
         * Handle the UserRole "deleted" event.
         * @param \App\Models\UserRole $userRole
         * @return void
         * --------------
         */
        
        public function deleted ( UserRole $userRole ) {
            $userRole -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'user-role-deleted',
                                                 'log'     => $userRole
                                             ] );
        }
        
        /**
         * --------------
         * Handle the UserRole "restored" event.
         * @param \App\Models\UserRole $userRole
         * @return void
         * --------------
         */
        
        public function restored ( UserRole $userRole ) {
            $userRole -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'user-role-restored',
                                                 'log'     => $userRole
                                             ] );
        }
        
        /**
         * --------------
         * Handle the UserRole "force deleted" event.
         * @param \App\Models\UserRole $userRole
         * @return void
         * --------------
         */
        
        public function forceDeleted ( UserRole $userRole ) {
            $userRole -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'user-role-forceDeleted',
                                                 'log'     => $userRole
                                             ] );
        }
    }
