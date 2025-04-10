<?php
    
    namespace App\Observers;
    
    use App\Models\Branch;
    
    class BranchObserver {
        
        /**
         * --------------
         * Handle the Branch "created" event.
         * @param \App\Models\Branch $branch
         * @return void
         * --------------
         */
        
        public function created ( Branch $branch ) {
            $branch -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'branch-created',
                                               'log'     => $branch
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Branch "updated" event.
         * @param \App\Models\Branch $branch
         * @return void
         * --------------
         */
        
        public function updated ( Branch $branch ) {
            $branch -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'branch-updated',
                                               'log'     => $branch
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Branch "deleted" event.
         * @param \App\Models\Branch $branch
         * @return void
         * --------------
         */
        
        public function deleted ( Branch $branch ) {
            $branch -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'branch-deleted',
                                               'log'     => $branch
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Branch "restored" event.
         * @param \App\Models\Branch $branch
         * @return void
         * --------------
         */
        
        public function restored ( Branch $branch ) {
            $branch -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'branch-restored',
                                               'log'     => $branch
                                           ] );
        }
        
        /**
         * --------------
         * Handle the Branch "force deleted" event.
         * @param \App\Models\Branch $branch
         * @return void
         * --------------
         */
        
        public function forceDeleted ( Branch $branch ) {
            $branch -> logs () -> create ( [
                                               'user_id' => ( auth () -> check () ) ? auth () -> user () -> id : null,
                                               'action'  => 'branch-forceDeleted',
                                               'log'     => $branch
                                           ] );
        }
    }
