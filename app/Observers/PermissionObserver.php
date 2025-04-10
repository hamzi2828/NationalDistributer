<?php
    
    namespace App\Observers;
    
    use App\Models\Permission;
    
    class PermissionObserver {
        
        /**
         * --------------
         * Handle the Permission "created" event.
         * @param \App\Models\Permission $permission
         * @return void
         * --------------
         */
        
        public function created ( Permission $permission ) {
            $permission -> logs () -> create ( [
                                                   'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                   'action'  => 'permission-created',
                                                   'log'     => $permission
                                               ] );
        }
        
        /**
         * --------------
         * Handle the Permission "updated" event.
         * @param \App\Models\Permission $permission
         * @return void
         * --------------
         */
        
        public function updated ( Permission $permission ) {
            $permission -> logs () -> create ( [
                                                   'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                   'action'  => 'permission-updated',
                                                   'log'     => $permission
                                               ] );
        }
        
        /**
         * --------------
         * Handle the Permission "deleted" event.
         * @param \App\Models\Permission $permission
         * @return void
         * --------------
         */
        
        public function deleted ( Permission $permission ) {
            $permission -> logs () -> create ( [
                                                   'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                   'action'  => 'permission-deleted',
                                                   'log'     => $permission
                                               ] );
        }
        
        /**
         * --------------
         * Handle the Permission "restored" event.
         * @param \App\Models\Permission $permission
         * @return void
         * --------------
         */
        public function restored ( Permission $permission ) {
            $permission -> logs () -> create ( [
                                                   'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                   'action'  => 'permission-restored',
                                                   'log'     => $permission
                                               ] );
        }
        
        /**
         * --------------
         * Handle the Permission "force deleted" event.
         * @param \App\Models\Permission $permission
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Permission $permission ) {
            $permission -> logs () -> create ( [
                                                   'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                   'action'  => 'permission-forceDeleted',
                                                   'log'     => $permission
                                               ] );
        }
    }
