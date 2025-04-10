<?php
    
    namespace App\Observers;
    
    use App\Models\Term;
    
    class TermObserver {
        
        /**
         * --------------
         * Handle the Term "created" event.
         * @param \App\Models\Term $term
         * @return void
         * --------------
         */
        
        public function created ( Term $term ) {
            $term -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'term-created',
                                             'log'     => $term
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Term "updated" event.
         * @param \App\Models\Term $term
         * @return void
         * --------------
         */
        
        public function updated ( Term $term ) {
            $term -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'term-updated',
                                             'log'     => $term
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Term "deleted" event.
         * @param \App\Models\Term $term
         * @return void
         * --------------
         */
        
        public function deleted ( Term $term ) {
            $term -> logs () -> create ( [
                                             'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                             'action'  => 'term-deleted',
                                             'log'     => $term
                                         ] );
        }
        
        /**
         * --------------
         * Handle the Term "restored" event.
         * @param \App\Models\Term $term
         * @return void
         * --------------
         */
        
        public function restored ( Term $term ) {
            //
        }
        
        /**
         * --------------
         * Handle the Term "force deleted" event.
         * @param \App\Models\Term $term
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Term $term ) {
            //
        }
    }
