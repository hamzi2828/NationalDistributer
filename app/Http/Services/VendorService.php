<?php
    
    namespace App\Http\Services;
    
    use App\Models\Account;
    use App\Models\Stock;
    use App\Models\Vendor;
    use App\Services\GeneralService;
    
    class VendorService {
        
        public function all () {
            return Vendor ::all ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save vendors
         * --------------
         */
        
        public function save ( $request, $account_head_id ) {
            return Vendor ::create ( [
                                         'user_id'         => auth () -> user () -> id,
                                         'account_head_id' => $account_head_id,
                                         'name'            => $request -> input ( 'name' ),
                                         'email'           => $request -> input ( 'email' ),
                                         'license'         => $request -> input ( 'license' ),
                                         'representative'  => $request -> input ( 'representative' ),
                                         'mobile'          => $request -> input ( 'mobile' ),
                                         'phone'           => $request -> input ( 'phone' ),
                                         'address'         => $request -> input ( 'address' ),
                                         'picture'         => ( new GeneralService() ) -> upload_image ( $request, './uploads/vendors/' ),
                                     ] );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save account heads
         * --------------
         */
        
        public function save_account_head ( $request ) {
            $account_head_id = config ( 'constants.vendors' );
            $account_head    = Account ::findorFail ( $account_head_id );
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $account_head_id,
                                          'account_type_id' => $account_head -> account_type_id,
                                          'name'            => $request -> input ( 'name' ),
                                          'phone'           => $request -> input ( 'phone' ),
                                      ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $vendor
         * @return void
         * update vendors
         * --------------
         */
        
        public function edit ( $request, $vendor ) {
            $vendor -> user_id        = auth () -> user () -> id;
            $vendor -> name           = $request -> input ( 'name' );
            $vendor -> license        = $request -> input ( 'license' );
            $vendor -> email          = $request -> input ( 'email' );
            $vendor -> representative = $request -> input ( 'representative' );
            $vendor -> mobile         = $request -> input ( 'mobile' );
            $vendor -> phone          = $request -> input ( 'phone' );
            $vendor -> address        = $request -> input ( 'address' );
            
            if ( $request -> hasFile ( 'image' ) )
                $vendor -> picture = ( new GeneralService() ) -> upload_image ( $request, './uploads/vendors/' );
            
            $vendor -> update ();
        }
        
        public function get_vendor_stocks ( $account_head_id, $account ) {
            if ( $account -> account_head_id != config ( 'constants.vendors' ) )
                return [];
            
            $vendor = Vendor ::where ( [ 'account_head_id' => $account_head_id ] ) -> first ();
            return Stock ::where ( [ 'vendor_id' => $vendor -> id ] )
                -> whereNotIn ( 'id', function ( $query ) use ( $account_head_id ) {
                    $query
                        -> select ( 'stock_id' )
                        -> from ( 'general_ledger_transaction_details' )
                        -> where ( [ 'vendor_id' => $account_head_id ] )
                        -> whereIn ( 'voucher', [ 'cpv', 'bpv' ] );
                } )
                -> get ();
        }
        
    }