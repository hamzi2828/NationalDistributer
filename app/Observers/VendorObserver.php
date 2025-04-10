<?php
    
    namespace App\Observers;
    
    use App\Models\Vendor;
    
    class VendorObserver {
        
        /**
         * --------------
         * Handle the Vendor "created" event.
         * @param \App\Models\Vendor $vendor
         * @return void
         * --------------
         */
        
        public function created ( Vendor $vendor ) {
            $vendor -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'vendor-created',
                                               'log'     => $vendor
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Vendor "updated" event.
         * @param \App\Models\Vendor $vendor
         * @return void
         * --------------
         */
        
        public function updated ( Vendor $vendor ) {
            $vendor -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'vendor-updated',
                                               'log'     => $vendor
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Vendor "deleted" event.
         * @param \App\Models\Vendor $vendor
         * @return void
         * --------------
         */
        
        public function deleted ( Vendor $vendor ) {
            $vendor -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'vendor-deleted',
                                               'log'     => $vendor
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Vendor "restored" event.
         * @param \App\Models\Vendor $vendor
         * @return void
         * --------------
         */
        
        public function restored ( Vendor $vendor ) {
            //
        }
        
        /**
         * --------------
         * Handle the Vendor "force deleted" event.
         * @param \App\Models\Vendor $vendor
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Vendor $vendor ) {
            //
        }
    }
