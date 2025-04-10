<?php
    
    namespace App\Observers;
    
    use App\Models\Customer;
    
    class CustomerObserver {
        
        /**
         * --------------
         * Handle the Customer "created" event.
         * @param \App\Models\Customer $customer
         * @return void
         * --------------
         */
        
        public function created ( Customer $customer ) {
            $customer -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'customer-created',
                                                'log'     => $customer
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Customer "updated" event.
         * @param \App\Models\Customer $customer
         * @return void
         * --------------
         */
        
        public function updated ( Customer $customer ) {
            $customer -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'customer-updated',
                                                'log'     => $customer
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Customer "deleted" event.
         * @param \App\Models\Customer $customer
         * @return void
         * --------------
         */
        
        public function deleted ( Customer $customer ) {
            $customer -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'customer-deleted',
                                                'log'     => $customer
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Customer "restored" event.
         * @param \App\Models\Customer $customer
         * @return void
         * --------------
         */
        
        public function restored ( Customer $customer ) {
            //
        }
        
        /**
         * --------------
         * Handle the Customer "force deleted" event.
         * @param \App\Models\Customer $customer
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Customer $customer ) {
            //
        }
    }
