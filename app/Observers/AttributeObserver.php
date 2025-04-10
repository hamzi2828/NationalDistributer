<?php
    
    namespace App\Observers;
    
    use App\Models\Attribute;
    
    class AttributeObserver {
        
        /**
         * --------------
         * Handle the Attribute "created" event.
         * @param \App\Models\Attribute $attribute
         * @return void
         * --------------
         */
        
        public function created ( Attribute $attribute ) {
            $attribute -> logs () -> create ( [
                                                  'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                  'action'  => 'attribute-created',
                                                  'log'     => $attribute
                                              ] );
        }
        
        /**
         * --------------
         * Handle the Attribute "updated" event.
         * @param \App\Models\Attribute $attribute
         * @return void
         * --------------
         */
        
        public function updated ( Attribute $attribute ) {
            $attribute -> logs () -> create ( [
                                                  'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                  'action'  => 'attribute-updated',
                                                  'log'     => $attribute
                                              ] );
        }
        
        /**
         * --------------
         * Handle the Attribute "deleted" event.
         * @param \App\Models\Attribute $attribute
         * @return void
         * --------------
         */
        
        public function deleted ( Attribute $attribute ) {
            $attribute -> logs () -> create ( [
                                                  'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                                  'action'  => 'attribute-deleted',
                                                  'log'     => $attribute
                                              ] );
        }
        
        /**
         * --------------
         * Handle the Attribute "restored" event.
         * @param \App\Models\Attribute $attribute
         * @return void
         * --------------
         */
        
        public function restored ( Attribute $attribute ) {
            //
        }
        
        /**
         * --------------
         * Handle the Attribute "force deleted" event.
         * @param \App\Models\Attribute $attribute
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Attribute $attribute ) {
            //
        }
    }
