<?php
    
    namespace App\Observers;
    
    use App\Models\AccountType;
    
    class AccountTypeObserver {
        
        /**
         * --------------
         * Handle the AccountType "created" event.
         * @param \App\Models\AccountType $accountType
         * @return void
         * --------------
         */
        
        public function created ( AccountType $accountType ) {
            $accountType -> logs () -> create ( [
                                                    'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                    'action'  => 'account-type-created',
                                                    'log'     => $accountType
                                                ] );
        }
        
        /**
         * --------------
         * Handle the AccountType "updated" event.
         * @param \App\Models\AccountType $accountType
         * @return void
         * --------------
         */
        
        public function updated ( AccountType $accountType ) {
            $accountType -> logs () -> create ( [
                                                    'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                    'action'  => 'account-type-updated',
                                                    'log'     => $accountType
                                                ] );
        }
        
        /**
         * --------------
         * Handle the AccountType "deleted" event.
         * @param \App\Models\AccountType $accountType
         * @return void
         * --------------
         */
        
        public function deleted ( AccountType $accountType ) {
            $accountType -> logs () -> create ( [
                                                    'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                    'action'  => 'account-type-deleted',
                                                    'log'     => $accountType
                                                ] );
        }
        
        /**
         * --------------
         * Handle the AccountType "restored" event.
         * @param \App\Models\AccountType $accountType
         * @return void
         * --------------
         */
        
        public function restored ( AccountType $accountType ) {
            //
        }
        
        /**
         * --------------
         * Handle the AccountType "force deleted" event.
         * @param \App\Models\AccountType $accountType
         * @return void
         * --------------
         */
        
        public function forceDeleted ( AccountType $accountType ) {
            //
        }
    }
