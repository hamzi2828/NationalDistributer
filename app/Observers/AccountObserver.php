<?php
    
    namespace App\Observers;
    
    use App\Models\Account;
    
    class AccountObserver {
        
        /**
         * --------------
         * Handle the Account "created" event.
         * @param \App\Models\Account $account
         * @return void
         * --------------
         */
        
        public function created ( Account $account ) {
            $account -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'account-created',
                                                'log'     => $account
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Account "updated" event.
         * @param \App\Models\Account $account
         * @return void
         * --------------
         */
        
        public function updated ( Account $account ) {
            $account -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'account-updated',
                                                'log'     => $account
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Account "deleted" event.
         * @param \App\Models\Account $account
         * @return void
         * --------------
         */
        
        public function deleted ( Account $account ) {
            $account -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'account-deleted',
                                                'log'     => $account
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Account "restored" event.
         * @param \App\Models\Account $account
         * @return void
         * --------------
         */
        
        public function restored ( Account $account ) {
            //
        }
        
        /**
         * --------------
         * Handle the Account "force deleted" event.
         * @param \App\Models\Account $account
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Account $account ) {
            //
        }
    }
