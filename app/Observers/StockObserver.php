<?php
    
    namespace App\Observers;
    
    use App\Models\Stock;
    
    class StockObserver {
        
        /**
         * --------------
         * Handle the Stock "created" event.
         * @param \App\Models\Stock $stock
         * @return void
         * --------------
         */
        
        public function created ( Stock $stock ) {
            $stock -> logs () -> create ( [
                                              'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                              'action'  => 'stock-created',
                                              'log'     => $stock
                                          ] );
        }
        
        /**
         * --------------
         * Handle the Stock "updated" event.
         * @param \App\Models\Stock $stock
         * @return void
         * --------------
         */
        
        public function updated ( Stock $stock ) {
            $stock -> logs () -> create ( [
                                              'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                              'action'  => 'stock-updated',
                                              'log'     => $stock
                                          ] );
        }
        
        /**
         * --------------
         * Handle the Stock "deleted" event.
         * @param \App\Models\Stock $stock
         * @return void
         * --------------
         */
        
        public function deleted ( Stock $stock ) {
            $stock -> logs () -> create ( [
                                              'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                              'action'  => 'stock-deleted',
                                              'log'     => $stock
                                          ] );
        }
        
        /**
         * --------------
         * Handle the Stock "restored" event.
         * @param \App\Models\Stock $stock
         * @return void
         * --------------
         */
        
        public function restored ( Stock $stock ) {
            //
        }
        
        /**
         * --------------
         * Handle the Stock "force deleted" event.
         * @param \App\Models\Stock $stock
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Stock $stock ) {
            //
        }
    }
