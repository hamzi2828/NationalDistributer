<?php

    namespace App\Policies;

    use App\Models\StockTake;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class StockTakePolicy {
        use HandlesAuthorization;

        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function viewStockTakeMenu ( User $user ) {
            if ( in_array ( 'stock-take-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         */

        public function viewAllStockTake ( User $user ) {
            if ( in_array ( 'all-stock-take-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockTake $stockTake
         * @return \Illuminate\Auth\Access\Response|bool
         */

        public function edit ( User $user, StockTake $stockTake ) {
            if ( in_array ( 'edit-stock-take-privilege', $user -> permissions () ) )
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
            if ( in_array ( 'add-stock-take-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        public function create_category_category ( User $user ) {
            if ( in_array ( 'add-stock-take-category-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockTake $stockTake
         * @return \Illuminate\Auth\Access\Response|bool
         */

        public function update ( User $user, StockTake $stockTake ) {
            if ( in_array ( 'edit-stock-take-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockTake $stockTake
         * @return \Illuminate\Auth\Access\Response|bool
         */

        public function delete ( User $user, StockTake $stockTake ) {
            if ( in_array ( 'delete-stock-take-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockTake $stockTake
         * @return \Illuminate\Auth\Access\Response|bool
         */
        public function restore ( User $user, StockTake $stockTake ) {
            //
        }

        /**
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\StockTake $stockTake
         * @return \Illuminate\Auth\Access\Response|bool
         */
        public function forceDelete ( User $user, StockTake $stockTake ) {
            //
        }
    }
