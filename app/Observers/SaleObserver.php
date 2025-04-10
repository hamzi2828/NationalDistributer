<?php
    
    namespace App\Observers;
    
    use App\Models\Sale;
    
    class SaleObserver {
        
        /**
         * --------------
         * Handle the Sale "created" event.
         * @param \App\Models\Sale $sale
         * @return void
         * --------------
         */
        
        public function created ( Sale $sale ) {
            $sale -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'sale-added',
                                             'log'     => $sale
                                         ] );
            
            $sale -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'sale-all-added',
                                             'log'     => json_encode ( request () -> all () )
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Sale "updated" event.
         * @param \App\Models\Sale $sale
         * @return void
         * --------------
         */
        
        public function updated ( Sale $sale ) {
            $sale -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'sale-updated',
                                             'log'     => $sale
                                         ] );
            
            $sale -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'sale-all-added',
                                             'log'     => json_encode ( request () -> all () )
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Sale "deleted" event.
         * @param \App\Models\Sale $sale
         * @return void
         * --------------
         */
        
        public function deleted ( Sale $sale ) {
            $sale -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'sale-deleted',
                                             'log'     => $sale
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Sale "restored" event.
         * @param \App\Models\Sale $sale
         * @return void
         * --------------
         */
        
        public function restored ( Sale $sale ) {
            //
        }
        
        /**
         * --------------
         * Handle the Sale "force deleted" event.
         * @param \App\Models\Sale $sale
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Sale $sale ) {
            //
        }
    }
