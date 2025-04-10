<?php
    
    namespace App\Observers;
    
    use App\Models\Issuance;
    
    class IssuanceObserver {
        
        /**
         * --------------
         * Handle the Issuance "created" event.
         * @param \App\Models\Issuance $issuance
         * @return void
         * --------------
         */
        
        public function created ( Issuance $issuance ) {
            $issuance -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'issuance-created',
                                                'log'     => $issuance
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Issuance "updated" event.
         * @param \App\Models\Issuance $issuance
         * @return void
         * --------------
         */
        
        public function updated ( Issuance $issuance ) {
            $issuance -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'issuance-updated',
                                                'log'     => $issuance
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Issuance "deleted" event.
         * @param \App\Models\Issuance $issuance
         * @return void
         * --------------
         */
        
        public function deleted ( Issuance $issuance ) {
            $issuance -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'issuance-deleted',
                                                'log'     => $issuance
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Issuance "restored" event.
         * @param \App\Models\Issuance $issuance
         * @return void
         * --------------
         */
        
        public function restored ( Issuance $issuance ) {
            //
        }
        
        /**
         * --------------
         * Handle the Issuance "force deleted" event.
         * @param \App\Models\Issuance $issuance
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Issuance $issuance ) {
            //
        }
    }
