<?php
    
    namespace App\Policies;
    
    use App\Models\Coupon;
    use App\Models\User;
    use Illuminate\Auth\Access\HandlesAuthorization;
    
    class CouponPolicy {
        use HandlesAuthorization;
        
        public function menu ( User $user ): bool {
            if ( in_array ( 'coupons-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function all ( User $user ): bool {
            if ( in_array ( 'all-coupons-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function create ( User $user ): bool {
            if ( in_array ( 'add-coupons-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function edit ( User $user, Coupon $coupon ): bool {
            if ( in_array ( 'edit-coupons-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function update ( User $user, Coupon $coupon ): bool {
            if ( in_array ( 'edit-coupons-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
        
        public function delete ( User $user, Coupon $coupon ): bool {
            if ( in_array ( 'delete-coupons-privilege', $user -> permissions () ) )
                return true;
            else
                return false;
        }
    }
