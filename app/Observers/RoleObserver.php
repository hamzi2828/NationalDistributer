<?php
    
    namespace App\Observers;
    
    use App\Models\Role;
    
    class RoleObserver {
        
        /**
         * --------------
         * Handle the Role "created" event.
         * @param \App\Models\Role $role
         * @return void
         * --------------
         */
        
        public function created ( Role $role ) {
            $role -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'role-created',
                                             'log'     => $role
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Role "updated" event.
         * @param \App\Models\Role $role
         * @return void
         * --------------
         */
        
        public function updated ( Role $role ) {
            $role -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'role-updated',
                                             'log'     => $role
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Role "deleted" event.
         * @param \App\Models\Role $role
         * @return void
         * --------------
         */
        
        public function deleted ( Role $role ) {
            $role -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'role-deleted',
                                             'log'     => $role
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Role "restored" event.
         * @param \App\Models\Role $role
         * @return void
         * --------------
         */
        
        public function restored ( Role $role ) {
            $role -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'role-restored',
                                             'log'     => $role
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Role "force deleted" event.
         * @param \App\Models\Role $role
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Role $role ) {
            $role -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'role-forceDeleted',
                                             'log'     => $role
                                         ] );
        }
    }
