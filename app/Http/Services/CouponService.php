<?php
    
    namespace App\Http\Services;
    
    use App\Models\Coupon;
    
    class CouponService {
        
        public function all () {
            return Coupon ::get ();
        }
        
        public function coupon_report()
        {
            // Retrieve all coupons with their related sales
             $coupons = Coupon::with(['sales.user'])->get();
            // Return the result as a JSON response
            return $coupons->toArray(); // Convert to array
        }

        public function coupon_search_report($couponId = null, $startDate = null, $endDate = null)
        {
            $query = Coupon::query();
        
            if ($couponId) {
                $query->where('id', $couponId);
            }
        
            $query->whereHas('sales', function ($query) use ($startDate, $endDate) {
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
            });
        
            $query->with(['sales' => function ($query) use ($startDate, $endDate) {
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
            }]);
            $coupons = $query->get();
        
            // Optionally transform the result if needed
            return $coupons;
        }
        

        public function save ( $request ): mixed {
            $start_date = date ( 'Y-m-d', strtotime ( $request -> input ( 'start-date' ) ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $request -> input ( 'end-date' ) ) );
            
            return Coupon ::create ( [
                                         'title'       => $request -> input ( 'title' ),
                                         'code'        => $request -> input ( 'code' ),
                                         'discount'    => $request -> input ( 'discount' ),
                                         'start_date'  => $request -> filled ( 'start-date' ) ? $start_date : null,
                                         'end_date'    => $request -> filled ( 'end-date' ) ? $end_date : null,
                                         'use_frequency' => $request -> input ( 'use-frequency' ),
                                         'description' => $request -> input ( 'description' ),
                                     ] );
        }
        
        public function edit ( $request, $courier ): void {
            $start_date = date ( 'Y-m-d', strtotime ( $request -> input ( 'start-date' ) ) );
            $end_date   = date ( 'Y-m-d', strtotime ( $request -> input ( 'end-date' ) ) );
            
            $courier -> title       = $request -> input ( 'title' );
            $courier -> code        = $request -> input ( 'code' );
            $courier -> discount    = $request -> input ( 'discount' );
            $courier -> start_date  = $request -> filled ( 'start-date' ) ? $start_date : null;
            $courier -> end_date    = $request -> filled ( 'end-date' ) ? $end_date : null;
            $courier -> use_frequency = $request -> input ( 'use-frequency' );
            $courier -> description = $request -> input ( 'description' );
            $courier -> update ();
        }
        
        public function delete ( $courier ): void {
            $courier -> delete ();
        }
    }