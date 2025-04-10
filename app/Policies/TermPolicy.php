<?php
    
    namespace App\Policies;
    
    use App\Models\Term;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class TermPolicy {
        use HandlesAuthorization;
        
        /**
         * --------------
         * Determine whether the user can view any models.
         * @param \App\Models\User $user
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function viewTermMenu ( User $user ) {
            if ( in_array ( 'terms-privilege', $user -> permissions () ) )
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
        
        public function viewAllTerms ( User $user ) {
            if ( in_array ( 'all-terms-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can view the model.
         * @param \App\Models\User $user
         * @param \App\Models\Term $term
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function edit ( User $user, Term $term ) {
            if ( in_array ( 'edit-terms-privilege', $user -> permissions () ) )
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
            if ( in_array ( 'add-terms-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can update the model.
         * @param \App\Models\User $user
         * @param \App\Models\Term $term
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function update ( User $user, Term $term ) {
            if ( in_array ( 'edit-terms-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Term $term
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function delete ( User $user, Term $term ) {
            if ( in_array ( 'delete-terms-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        /**
         * --------------
         * Determine whether the user can restore the model.
         * @param \App\Models\User $user
         * @param \App\Models\Term $term
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function restore ( User $user, Term $term ) {
            //
        }
        
        /**
         * --------------
         * Determine whether the user can permanently delete the model.
         * @param \App\Models\User $user
         * @param \App\Models\Term $term
         * @return \Illuminate\Auth\Access\Response|bool
         * --------------
         */
        
        public function forceDelete ( User $user, Term $term ) {
            //
        }
    }
