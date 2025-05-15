<?php

    namespace App\Policies;

    use App\Models\Sale;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class SalePolicy {
        use HandlesAuthorization;

        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function viewSalesMenu ( User $user ) {
            if ( in_array ( 'sales-privilege', $user -> permissions () ) )
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

        public function viewAllSales ( User $user ) {
            if ( in_array ( 'all-sales-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function edit ( User $user, Sale $sale ) {
            if ( ( in_array ( 'edit-sales-privilege', $user -> permissions () ) && $sale -> sale_closed == '0'
            && $sale -> refunded == '0' && $sale -> user_id == $user -> id
            //  && $sale -> is_online == '0'
            )
            || ( in_array ( 'admin', $user -> user_roles () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0'
            // && $sale -> is_online == '0'
            )
            )
                return true;
            else
                return false;
        }


        public function edit_online ( User $user, Sale $sale ) {
            if ( ( in_array ( 'edit-sales-online-privilege', $user -> permissions () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0' && $sale -> user_id == $user -> id
              && $sale -> is_online == '1'
            ) || ( in_array ( 'admin', $user -> user_roles () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0'
              && $sale -> is_online == '1'  ) )
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
            if ( in_array ( 'add-sales-privilege', $user -> permissions () ) )
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

        public function create_sale_attribute ( User $user ) {
            if ( in_array ( 'add-sales-attribute-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function update ( User $user, Sale $sale ) {
            if ( ( in_array ( 'edit-sales-privilege', $user -> permissions () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0' && $sale -> user_id == $user -> id ) || ( in_array ( 'admin', $user -> user_roles () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0' ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function close_bill ( User $user, Sale $sale ) {
            if ( ( ( in_array ( 'close-sales-privilege', $user -> permissions () ) ) && $sale -> user_id == $user -> id && $sale -> sale_closed == '0' && $sale -> status == '1' && $sale -> refunded == '0' ) || in_array ( 'admin', $user -> user_roles () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0' && $sale -> status == '1' )
                return true;
            else
                return false;
        }

        public function status ( User $user, Sale $sale ) {
            if ( ( ( in_array ( 'status-sales-privilege', $user -> permissions () ) ) && $sale -> user_id == $user -> id && $sale -> sale_closed == '0' && $sale -> refunded == '0' ) || in_array ( 'admin', $user -> user_roles () ) && $sale -> sale_closed == '0' && $sale -> refunded == '0' )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function sale_refund ( User $user, Sale $sale ) {
            if ( ( in_array ( 'sale-refund-privilege', $user -> permissions () ) && $sale -> sale_closed == '1' && $sale -> refunded == '0' ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function delete ( User $user, Sale $sale ) {
            if ( ( in_array ( 'delete-sales-privilege', $user -> permissions () ) && $sale -> user_id == $user -> id && $sale -> sale_closed == '0' && $sale -> refunded == '0' ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function restore ( User $user, Sale $sale ) {
            //
        }

        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Sale $sale
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function forceDelete ( User $user, Sale $sale ) {
            //
        }

        public function quick_sale ( User $user ) {
            if ( in_array ( 'add-quick-sales-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can access C-Print
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function sales_c_print_privilege ( User $user ) {
            if ( in_array ( 'sales-c-print-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can access View/Print
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function sales_view_print_privilege ( User $user ) {
            if ( in_array ( 'sales-view-print-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can access Print (P)
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function sales_print_p_privilege ( User $user ) {
            if ( in_array ( 'sales-print-p-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can access Print (H)
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function sales_print_h_privilege ( User $user ) {
            if ( in_array ( 'sales-print-h-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

        /**
         * --------------
         * Determine whether the user can access Print (C)
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */

        public function sales_print_c_privilege ( User $user ) {
            if ( in_array ( 'sales-print-c-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }

}
