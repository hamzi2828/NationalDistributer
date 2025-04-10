<?php
    
    namespace App\Policies;
    
    use App\Models\StockReturn;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class StockReturnPolicy {
        use HandlesAuthorization;
        
        /**
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function viewAllStockReturns ( User $user ) {
            if ( in_array ( 'all-stock-return-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockReturn $stockReturn
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function edit ( User $user, StockReturn $stockReturn ) { // && $stockReturn -> user_id == $user -> id
            if ( ( in_array ( 'edit-stock-return-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
        
        /**
         * Determine whether the user can create models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function create ( User $user ) {
            if ( in_array ( 'add-stock-return-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockReturn $stockReturn
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function update ( User $user, StockReturn $stockReturn ) { // && $stockReturn -> user_id == $user -> id
            if ( ( in_array ( 'edit-stock-return-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
        
        /**
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockReturn $stockReturn
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function delete ( User $user, StockReturn $stockReturn ) {
            if ( ( in_array ( 'delete-stock-return-privilege', $user -> permissions () ) && $stockReturn -> user_id == $user -> id ) )
                return true;
            else
                return false;
        }
        
        /**
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockReturn $stockReturn
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function restore ( User $user, StockReturn $stockReturn ) {
            //
        }
        
        /**
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockReturn $stockReturn
         * @return \Illuminate\Auth\Access\Response|bool
         */
        
        public function forceDelete ( User $user, StockReturn $stockReturn ) {
            //
        }
    }
