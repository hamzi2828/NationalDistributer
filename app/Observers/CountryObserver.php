<?php
    
    namespace App\Observers;
    
    use App\Models\Country;
    
    class CountryObserver {
        
        /**
         * --------------
         * Handle the Country "created" event.
         * @param \App\Models\Country $country
         * @return void
         * --------------
         */
        
        public function created ( Country $country ) {
            $country -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'country-created',
                                                'log'     => $country
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Country "updated" event.
         * @param \App\Models\Country $country
         * @return void
         * --------------
         */
        
        public function updated ( Country $country ) {
            $country -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'country-updated',
                                                'log'     => $country
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Country "deleted" event.
         * @param \App\Models\Country $country
         * @return void
         * --------------
         */
        
        public function deleted ( Country $country ) {
            $country -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'country-deleted',
                                                'log'     => $country
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Country "restored" event.
         * @param \App\Models\Country $country
         * @return void
         * --------------
         */
        
        public function restored ( Country $country ) {
            $country -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'country-restored',
                                                'log'     => $country
                                            ] );
        }
        
        /**
         * --------------
         * Handle the Country "force deleted" event.
         * @param \App\Models\Country $country
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Country $country ) {
            $country -> logs () -> create ( [
                                                'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                'action'  => 'country-forceDeleted',
                                                'log'     => $country
                                            ] );
        }
    }
