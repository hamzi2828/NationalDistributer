<?php
    
    namespace App\Policies;
    
    use App\Models\Account;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class AccountPolicy {
        use HandlesAuthorization;
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewAccountsMenu ( User $user ) {
            if ( in_array ( 'accounts-privilege', $user -> permissions () ) )
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
        
        public function viewAllAccounts ( User $user ) {
            if ( in_array ( 'all-accounts-privilege', $user -> permissions () ) )
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
        
        public function viewGeneralLedger ( User $user ) {
            if ( in_array ( 'view-general-ledger', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Account $account
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit ( User $user, Account $account ) {
            if ( in_array ( 'edit-accounts-privilege', $user -> permissions () ) )
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
            if ( in_array ( 'add-accounts-privilege', $user -> permissions () ) )
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
        
        public function add_transactions ( User $user ) {
            if ( in_array ( 'add-transactions-privilege', $user -> permissions () ) )
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
        
        public function add_opening_balance ( User $user ) {
            if ( in_array ( 'add-opening-balance-privilege', $user -> permissions () ) )
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
        
        public function add_multiple_transactions ( User $user ) {
            if ( in_array ( 'add-multiple-transactions-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function add_transactions_complex_jv ( User $user ) {
            if ( in_array ( 'add-transactions-complex-jv-privilege', $user -> permissions () ) )
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
        
        public function search_transactions ( User $user ) {
            if ( in_array ( 'search-transactions-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Account $account
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function update ( User $user, Account $account ) {
            if ( in_array ( 'edit-accounts-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Account $account
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function delete ( User $user, Account $account ) {
            if ( in_array ( 'delete-accounts-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\Account $account
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function restore ( User $user, Account $account ) {
            //
        }
        
        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Account $account
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function forceDelete ( User $user, Account $account ) {
            //
        }
        
        public function delete_transactions ( User $user ) {
            if ( in_array ( 'delete-transactions-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function status ( User $user, Account $account ): bool {
            $permissions = $user -> permissions ();
            return in_array ( 'active-inactive-account-heads', $permissions );
        }
        
        public function add_transactions_quick ( User $user ) {
            if ( in_array ( 'add-transactions-quick-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function add_transactions_quick_pay ( User $user ) {
            if ( in_array ( 'add-transactions-quick-pay-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function add_transactions_quick_expense ( User $user ) {
            if ( in_array ( 'add-transactions-quick-expense-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function balance_sheet ( User $user ) {
            if ( in_array ( 'balance-sheet-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function customer_ageing_report ( User $user ) {
            if ( in_array ( 'customer-ageing-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function vendor_ageing_report ( User $user ) {
            if ( in_array ( 'vendor-ageing-report-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
