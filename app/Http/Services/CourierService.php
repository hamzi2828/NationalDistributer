<?php
    
    namespace App\Http\Services;
    
    use App\Models\Account;
    use App\Models\Category;
    use App\Models\Courier;
    
    class CourierService {
        
        public function all () {
            return Courier ::get ();
        }
        
        public function save ( $request, $account_head ): mixed {
            return Courier ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $account_head -> id,
                                          'title'           => $request -> input ( 'title' ),
                                          'email'           => $request -> input ( 'email' ),
                                          'contact_person'  => $request -> input ( 'contact-person' ),
                                          'phone'           => $request -> input ( 'phone' ),
                                          'tracking_link'   => $request -> input ( 'tracking' ),
                                      ] );
        }
        
        public function edit ( $request, $courier ): void {
            $courier -> user_id        = auth () -> user () -> id;
            $courier -> title          = $request -> input ( 'title' );
            $courier -> email          = $request -> input ( 'email' );
            $courier -> contact_person = $request -> input ( 'contact-person' );
            $courier -> phone          = $request -> input ( 'phone' );
            $courier -> tracking_link  = $request -> input ( 'tracking' );
            $courier -> update ();
        }
        
        public function delete ( $courier ): void {
            $courier -> delete ();
        }
        
        public function add_account_head ( $request ) {
            $account_head_id = config ( 'constants.vendors' );
            $account_head    = Account ::findorFail ( $account_head_id );
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $account_head_id,
                                          'account_type_id' => $account_head -> account_type_id,
                                          'name'            => $request -> input ( 'title' ),
                                          'phone'           => $request -> input ( 'phone' ),
                                      ] );
        }
        
        function update_account_head ( $courier ): void {
            $courier
                -> account_head ()
                -> update ( [
                                'name'  => $courier -> title,
                                'phone' => $courier -> phone,
                            ] );
        }
        
        function delete_account_head ( $courier ): void {
            $courier
                -> account_head ()
                -> delete ();
        }
    }