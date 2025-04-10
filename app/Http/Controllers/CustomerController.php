<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CustomerRequest;
    use App\Http\Services\AccountService;
    use App\Http\Services\AttributeService;
    use App\Http\Services\CustomerService;
    use App\Http\Services\ProductService;
    use App\Models\Account;
    use App\Models\Customer;
    use App\Models\Product;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CustomerController extends Controller {
        
        protected object $customerService;
        protected object $productService;
        
        public function __construct ( CustomerService $customerService, ProductService $productService ) {
            $this -> customerService = $customerService;
            $this -> productService  = $productService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllCustomers', Customer::class );
            $data[ 'title' ]     = 'All Customers';
            $data[ 'customers' ] = $this -> customerService -> all ();
            return view ( 'customers.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Customer::class );
            $data[ 'title' ] = 'Add Customers';
            return view ( 'customers.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( CustomerRequest $request ) {
            $this -> authorize ( 'create', Customer::class );
            try {
                DB ::beginTransaction ();
                $account  = $this -> customerService -> save_account_head ( $request );
                $customer = $this -> customerService -> save ( $request, $account -> id );
                DB ::commit ();
                
                if ( !empty( $customer ) and $customer -> id > 0 )
                    return redirect ( route ( 'customers.edit', [ 'customer' => $customer -> id ] ) ) -> with ( 'message', 'Customer has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $customer
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Customer $customer ) {
            $this -> authorize ( 'edit', $customer );
            $data[ 'title' ]                  = 'Edit Customers';
            $data[ 'customer' ]               = $customer -> load ( 'prices.product' );
            $data[ 'attributes' ]             = ( new AttributeService() ) -> all ();
            $data[ 'products' ]               = $this -> productService -> all ();
            $data[ 'simple_products' ]        = $this -> productService -> get_simple_products ( $customer -> id );
            $data[ 'prices' ]                 = $this -> productService -> product_prices ( $customer -> id );
            $data[ 'simple_products_prices' ] = $this -> productService -> get_simple_added_products_prices ( $customer -> id );
            $data[ 'products_prices' ]        = $this -> customerService -> create_array_of_products ( $customer );
            return view ( 'customers.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( CustomerRequest $request, Customer $customer ) {
            $this -> authorize ( 'edit', $customer );
            try {
                DB ::beginTransaction ();
                $this -> customerService -> edit ( $request, $customer );
                $this -> customerService -> delete_product_prices ( $customer -> id );
                $this -> customerService -> add_product_prices ( $request, $customer -> id );
                ( new AccountService() ) -> update_account_head ( $customer );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Customer has been updated.' );
                
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        /**
         * --------------
         * Remove the specified resource from storage.
         * @param object $customer
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( Customer $customer ) {
            $this -> authorize ( 'delete', $customer );
            $customer -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Customer has been deleted.' );
        }
        
        public function status ( Customer $customer ) {
            $this -> authorize ( 'status', $customer );
            $customer -> active = !$customer -> active;
            $customer -> update ();
            
            $accountHead = Account ::find ( $customer -> account_head_id );
            if ( $accountHead ) {
                $accountHead -> active = !$accountHead -> active;
                $accountHead -> update ();
            }
            
            return redirect () -> back () -> with ( 'message', 'Customer status has been updated.' );
        }
        
        /**
         * --------------
         * @param Request $request
         * @return string|void
         * load added product for sale
         * --------------
         */
        
        public function add_product ( Request $request ) {
            $product_id  = $request -> input ( 'product_id' );
            $customer_id = $request -> input ( 'customer_id' );
            
            if ( $request -> has ( 'add_all' ) && $request -> input ( 'add_all' ) == 'true' ) {
                $products           = explode ( ',', $request -> input ( 'products' ) );
                $data[ 'products' ] = Product ::whereIn ( 'id', array_filter ( $products ) ) -> get ();
                return view ( 'customers.add-products', $data ) -> render ();
            }
            else if ( $product_id > 0 && is_numeric ( $product_id ) ) {
                $data[ 'product' ] = Product ::find ( $product_id );
                return view ( 'customers.add-product', $data ) -> render ();
            }
        }
        
        /**
         * --------------
         * @param Request $request
         * @return string|void
         * get customer products
         * --------------
         */
        
        public function get_customer_products ( Request $request ) {
            $customer_id = $request -> input ( 'customer_id' );
            if ( $customer_id > 0 && is_numeric ( $customer_id ) ) {
                $customer = Customer ::find ( $customer_id );
                if ( request () -> has ( 'attribute_id' ) && $request -> input ( 'attribute_id' ) > 0 ) {
                    $data[ 'customer' ] = $customer -> load ( [
                                                                  'prices.product',
                                                                  'prices' => function ( $query ) {
                                                                      $query -> whereIn ( 'product_id', function ( $query ) {
                                                                          $query -> select ( 'product_id' ) -> from ( 'product_terms' ) -> whereIn ( 'term_id', function ( $query ) {
                                                                              $query -> select ( 'id' ) -> from ( 'terms' ) -> where ( [ 'attribute_id' => request ( 'attribute_id' ) ] );
                                                                          } );
                                                                      } );
                                                                  }
                                                              ] );
                }
                else {
                    $data[ 'customer' ] = $customer -> load ( [ 'prices.product' ] );
                }
                
                if ( !empty( $customer -> prices ) && count ( $customer -> prices ) < 1 )
                    $data[ 'products' ] = $this -> productService -> products_by_branch ();
                
                return view ( 'sales.customer-products', $data ) -> render ();
            }
        }
    }
