<?php
    
    namespace App\Policies;
    
    use App\Models\Stock;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class StockPolicy {
        use HandlesAuthorization;
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewStockMenu ( User $user ) {
            if ( in_array ( 'stocks-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
    
        public function viewAllCustomerStockReturns ( User $user ) {
            if ( in_array ( 'all-stock-return-customer-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
    
        public function createCustomerStockReturn ( User $user ) {
            if ( in_array ( 'add-stock-return-customer-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewAllStocks ( User $user ) {
            if ( in_array ( 'all-stocks-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Stock $stock
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit ( User $user, Stock $stock ) {
            if ( in_array ( 'edit-stocks-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can create models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function create ( User $user ) {
            if ( in_array ( 'add-stocks-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Stock $stock
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function update ( User $user, Stock $stock ) {
            if ( in_array ( 'edit-stocks-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Stock $stock
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function delete ( User $user, Stock $stock ) {
            if ( in_array ( 'delete-stocks-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\Stock $stock
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function restore ( User $user, Stock $stock ) {
            //
        }
        
        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Stock $stock
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function forceDelete ( User $user, Stock $stock ) {
            //
        }
    }
