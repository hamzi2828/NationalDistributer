<?php
    
    namespace App\Observers;
    
    use App\Models\SaleProducts;
    
    class SaleProductObserver {
        
        /**
         * --------------
         * Handle the SaleProducts "created" event.
         * @param \App\Models\SaleProducts $saleProducts
         * @return void
         * --------------
         */
        
        public function created ( SaleProducts $saleProducts ) {
            $saleProducts -> logs () -> create ( [
                                                     'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                     'action'  => 'sale-products-added',
                                                     'log'     => $saleProducts
                                                 ] );
        }
        
        /**
         * --------------
         * Handle the SaleProducts "updated" event.
         * @param \App\Models\SaleProducts $saleProducts
         * @return void
         * --------------
         */
        
        public function updated ( SaleProducts $saleProducts ) {
            $saleProducts -> logs () -> create ( [
                                                     'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                     'action'  => 'sale-products-updated',
                                                     'log'     => $saleProducts
                                                 ] );
        }
        
        /**
         * --------------
         * Handle the SaleProducts "deleted" event.
         * @param \App\Models\SaleProducts $saleProducts
         * @return void
         * --------------
         */
        
        public function deleted ( SaleProducts $saleProducts ) {
            $saleProducts -> logs () -> create ( [
                                                     'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                     'action'  => 'sale-products-deleted',
                                                     'log'     => $saleProducts
                                                 ] );
        }
        
        /**
         * --------------
         * Handle the SaleProducts "restored" event.
         * @param \App\Models\SaleProducts $saleProducts
         * @return void
         * --------------
         */
        
        public function restored ( SaleProducts $saleProducts ) {
            //
        }
        
        /**
         * --------------
         * Handle the SaleProducts "force deleted" event.
         * @param \App\Models\SaleProducts $saleProducts
         * @return void
         * --------------
         */
        
        public function forceDeleted ( SaleProducts $saleProducts ) {
            //
        }
    }
