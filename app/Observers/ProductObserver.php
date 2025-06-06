<?php
    
    namespace App\Observers;
    
    use App\Models\Product;
    
    class ProductObserver {
        
        /**
         * --------------
         * Handle the Product "created" event.
         * @param \App\Models\Product $product
         * @return void
         * --------------
         */
        
        public function created ( Product $product ) {
            $product -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'product-created',
                                                'log'     => $product
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Product "updated" event.
         * @param \App\Models\Product $product
         * @return void
         * --------------
         */
        
        public function updated ( Product $product ) {
            $product -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'product-updated',
                                                'log'     => $product
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Product "deleted" event.
         * @param \App\Models\Product $product
         * @return void
         * --------------
         */
        
        public function deleted ( Product $product ) {
            $product -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'product-deleted',
                                                'log'     => $product
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Product "restored" event.
         * @param \App\Models\Product $product
         * @return void
         * --------------
         */
        
        public function restored ( Product $product ) {
            //
        }
        
        /**
         * --------------
         * Handle the Product "force deleted" event.
         * @param \App\Models\Product $product
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Product $product ) {
            //
        }
    }
