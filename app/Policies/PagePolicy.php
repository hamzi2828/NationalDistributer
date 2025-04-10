<?php
    
    namespace App\Policies;
    
    use App\Models\Page;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class PagePolicy {
        use HandlesAuthorization;
        
        public function viewMenu ( User $user ): bool {
            if ( in_array ( 'pages-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function all ( User $user ): bool {
            if ( in_array ( 'all-pages-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function edit ( User $user, Page $page ): bool {
            if ( in_array ( 'edit-pages-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function create ( User $user ): bool {
            if ( in_array ( 'add-pages-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function update ( User $user, Page $page ): bool {
            if ( in_array ( 'edit-pages-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function delete ( User $user, Page $page ): bool {
            if ( in_array ( 'delete-pages-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
