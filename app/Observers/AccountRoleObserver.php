<?php
    
    namespace App\Observers;
    
    use App\Models\AccountRole;
    
    class AccountRoleObserver {
        
        /**
         * --------------
         * Handle the AccountRole "created" event.
         * @param \App\Models\AccountRole $accountRole
         * @return void
         * --------------
         */
        
        public function created ( AccountRole $accountRole ) {
            $accountRole -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'account-role-created',
                                                'log'     => $accountRole
                                            ] );
        }
        
        /**
         * --------------
         * Handle the AccountRole "updated" event.
         * @param \App\Models\AccountRole $accountRole
         * @return void
         * --------------
         */
        
        public function updated ( AccountRole $accountRole ) {
            $accountRole -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'account-role-updated',
                                                'log'     => $accountRole
                                            ] );
        }
        
        /**
         * --------------
         * Handle the AccountRole "deleted" event.
         * @param \App\Models\AccountRole $accountRole
         * @return void
         * --------------
         */
        
        public function deleted ( AccountRole $accountRole ) {
            $accountRole -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'account-role-deleted',
                                                'log'     => $accountRole
                                            ] );
        }
        
        /**
         * --------------
         * Handle the AccountRole "restored" event.
         * @param \App\Models\AccountRole $accountRole
         * @return void
         * --------------
         */
        
        public function restored ( AccountRole $accountRole ) {
        }
        
        /**
         * --------------
         * Handle the AccountRole "force deleted" event.
         * @param \App\Models\AccountRole $accountRole
         * @return void
         * --------------
         */
        
        public function forceDeleted ( AccountRole $accountRole ) {
            //
        }
    }
