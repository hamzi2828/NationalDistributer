<?php
    
    namespace App\Observers;
    
    use App\Models\Category;
    
    class CategoryObserver {
        
        /**
         * --------------
         * Handle the Category "created" event.
         * @param \App\Models\Category $category
         * @return void
         * --------------
         */
        
        public function created ( Category $category ) {
            $category -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'category-created',
                                                 'log'     => $category
                                             ] );
        }
        
        /**
         * --------------
         * Handle the Category "updated" event.
         * @param \App\Models\Category $category
         * @return void
         * --------------
         */
        
        public function updated ( Category $category ) {
            $category -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'category-updated',
                                                 'log'     => $category
                                             ] );
        }
        
        /**
         * --------------
         * Handle the Category "deleted" event.
         * @param \App\Models\Category $category
         * @return void
         * --------------
         */
        
        public function deleted ( Category $category ) {
            $category -> logs () -> create ( [
                                                 'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                 'action'  => 'category-deleted',
                                                 'log'     => $category
                                             ] );
        }
        
        /**
         * --------------
         * Handle the Category "restored" event.
         * @param \App\Models\Category $category
         * @return void
         * --------------
         */
        
        public function restored ( Category $category ) {
        
        }
        
        /**
         * --------------
         * Handle the Category "force deleted" event.
         * @param \App\Models\Category $category
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Category $category ) {
        
        }
    }
