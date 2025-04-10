<?php
    
    namespace App\Http\Services;
    
    use App\Models\Account;
    use App\Models\Customer;
    use App\Models\CustomerProductPrice;
    use App\Services\GeneralService;
    use Illuminate\Support\Facades\DB;
    
    class CustomerService {
        
        /**
         * --------------
         * @return mixed
         * get all customers
         * --------------
         */
        
        public function all () {
            return Customer ::latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save account heads
         * --------------
         */
        
        public function save_account_head ( $request ) {
            $account_head_id = config ( 'constants.customers' );
            $account_head    = Account ::findorFail ( $account_head_id );
            return Account ::create ( [
                                          'user_id'         => auth () -> user () -> id,
                                          'account_head_id' => $account_head_id,
                                          'account_type_id' => $account_head -> account_type_id,
                                          'name'            => $request -> input ( 'name' ),
                                          'phone'           => $request -> input ( 'mobile' ),
                                      ] );
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save customers
         * --------------
         */
        
        public function save ( $request, $account_head_id ) {
            return Customer ::create ( [
                                           'user_id'         => auth () -> user () -> id,
                                           'account_head_id' => $account_head_id,
                                           'name'            => $request -> input ( 'name' ),
                                           'email'           => $request -> input ( 'email' ),
                                           'mobile'          => $request -> input ( 'mobile' ),
                                           'license'         => $request -> input ( 'license' ),
                                           'phone'           => $request -> input ( 'phone' ),
                                           'representative'  => $request -> input ( 'representative' ),
                                           'gender'          => $request -> input ( 'gender' ),
                                           'address'         => $request -> input ( 'address' ),
                                           'picture'         => ( new GeneralService() ) -> upload_image ( $request, './uploads/customers/' ),
                                       ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $customer
         * @return void
         * update customers
         * --------------
         */
        
        public function edit ( $request, $customer ) {
            $customer -> user_id        = auth () -> user () -> id;
            $customer -> name           = $request -> input ( 'name' );
            $customer -> email          = $request -> input ( 'email' );
            $customer -> mobile         = $request -> input ( 'mobile' );
            $customer -> license        = $request -> input ( 'license' );
            $customer -> phone          = $request -> input ( 'phone' );
            $customer -> representative = $request -> input ( 'representative' );
            $customer -> gender         = $request -> input ( 'gender' );
            $customer -> address        = $request -> input ( 'address' );
            
            if ( $request -> hasFile ( 'image' ) )
                $customer -> picture = ( new GeneralService() ) -> upload_image ( $request, './uploads/customers/' );
            
            $customer -> update ();
        }
        
        /**
         * --------------
         * @param $customer_id
         * @return int
         * delete customer product prices
         * --------------
         */
        
        public function delete_product_prices ( $customer_id ) {
            return DB ::table ( 'customer_product_price' ) -> where ( [ 'customer_id' => $customer_id ] ) -> delete ();
        }
        
        /**
         * --------------
         * @param $request
         * @param $customer_id
         * @return void
         * add customer product prices
         * --------------
         */
        
        public function add_product_prices ( $request, $customer_id ) {
            $products = $request -> input ( 'products' );
            
            if ( $request -> has ( 'products' ) && count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    $info = array (
                        'user_id'     => auth () -> user () -> id,
                        'customer_id' => $customer_id,
                        'product_id'  => $product_id,
                        'price'       => $request -> input ( 'price.' . $key )
                    );
                    CustomerProductPrice ::create ( $info );
                }
            }
        }
        
        /**
         * --------------
         * @param $customer
         * @return array
         * create array of products
         * --------------
         */
        
        public function create_array_of_products ( $customer ) {
            $products = array ();
            if ( count ( $customer -> prices ) > 0 ) {
                foreach ( $customer -> prices as $price ) {
                    if ( !in_array ( $price -> product_id, $products ) )
                        array_push ( $products, $price -> product_id );
                }
            }
            return $products;
        }
        
        public function customers_not_linked_with_user ( $user_id = 0 ) {
            
            $customers = Customer ::whereNotIn ( 'id', function ( $query ) {
                $query -> select ( 'customer_id' ) -> from ( 'user_customers' );
            } );
            
            if ( $user_id > 0 ) {
                $customers -> orWhereIn ( 'id', function ( $query ) use ( $user_id ) {
                    $query -> select ( 'customer_id' )
                        -> from ( 'user_customers' )
                        -> where ( 'user_id', $user_id );
                } );
            }
            
            return $customers -> get ();
            
        }
    }