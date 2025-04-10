<?php
    
    namespace App\Policies;
    
    use App\Models\HomeSetting;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class HomeSettingPolicy {
        use HandlesAuthorization;
        
        
        public function create ( User $user ): bool {
            if ( in_array ( 'home-settings-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
