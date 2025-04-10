<?php
    
    namespace App\Policies;
    
    use App\Models\Courier;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class CourierPolicy {
        use HandlesAuthorization;
        
        public function menu ( User $user ): bool {
            if ( in_array ( 'couriers-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function all ( User $user ): bool {
            if ( in_array ( 'all-couriers-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function create ( User $user ): bool {
            if ( in_array ( 'add-couriers-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function edit ( User $user, Courier $courier ): bool {
            if ( in_array ( 'edit-couriers-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function update ( User $user, Courier $courier ): bool {
            if ( in_array ( 'edit-couriers-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function delete ( User $user, Courier $courier ): bool {
            if ( in_array ( 'delete-couriers-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
