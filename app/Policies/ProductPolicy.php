<?php
    
    namespace App\Policies;
    
    use App\Models\Product;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class ProductPolicy {
        use HandlesAuthorization;
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewAllProducts ( User $user ) {
            if ( in_array ( 'all-products-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function viewAllProductSimple ( User $user ) {
            if ( in_array ( 'simple-products-privilege', $user -> permissions () ) )
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
        
        public function viewProductsMenu ( User $user ) {
            if ( in_array ( 'products-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Product $product
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit ( User $user, Product $product ) {
            if ( ( in_array ( 'edit-products-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Product $product
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit_variable ( User $user, Product $product ) {
            if ( ( in_array ( 'edit-variable-products-privilege', $user -> permissions () ) ) )
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
            if ( in_array ( 'add-products-privilege', $user -> permissions () ) )
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
        
        public function create_variable ( User $user ) {
            if ( in_array ( 'add-variable-products-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Product $product
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function update ( User $user, Product $product ) {
            if ( ( in_array ( 'edit-products-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Product $product
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function delete ( User $user, Product $product ) {
            if ( ( in_array ( 'delete-products-privilege', $user -> permissions () ) ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\Product $product
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function restore ( User $user, Product $product ) {
        
        }
        
        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Product $product
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function forceDelete ( User $user, Product $product ) {
        
        }
        
        public function ticket ( User $user, Product $product ) {
            if ( in_array ( 'ticket-products-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function variations ( User $user ) {
            if ( in_array ( 'variations-products-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
