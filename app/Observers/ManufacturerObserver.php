<?php
    
    namespace App\Observers;
    
    use App\Models\Manufacturer;
    
    class ManufacturerObserver {
        
        /**
         * --------------
         * Handle the Manufacturer "created" event.
         * @param \App\Models\Manufacturer $manufacturer
         * @return void
         * --------------
         */
        
        public function created ( Manufacturer $manufacturer ) {
            $manufacturer -> logs () -> create ( [
                                                     'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                     'action'  => 'manufacturer-created',
                                                     'log'     => $manufacturer
                                                 ] );
        }
        
        /**
         * --------------
         * Handle the Manufacturer "updated" event.
         * @param \App\Models\Manufacturer $manufacturer
         * @return void
         * --------------
         */
        
        public function updated ( Manufacturer $manufacturer ) {
            $manufacturer -> logs () -> create ( [
                                                     'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                     'action'  => 'manufacturer-updated',
                                                     'log'     => $manufacturer
                                                 ] );
        }
        
        /**
         * --------------
         * Handle the Manufacturer "deleted" event.
         * @param \App\Models\Manufacturer $manufacturer
         * @return void
         * --------------
         */
        
        public function deleted ( Manufacturer $manufacturer ) {
            $manufacturer -> logs () -> create ( [
                                                     'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                     'action'  => 'manufacturer-deleted',
                                                     'log'     => $manufacturer
                                                 ] );
        }
        
        /**
         * --------------
         * Handle the Manufacturer "restored" event.
         * @param \App\Models\Manufacturer $manufacturer
         * @return void
         * --------------
         */
        
        public function restored ( Manufacturer $manufacturer ) {
            //
        }
        
        /**
         * --------------
         * Handle the Manufacturer "force deleted" event.
         * @param \App\Models\Manufacturer $manufacturer
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Manufacturer $manufacturer ) {
            //
        }
    }
