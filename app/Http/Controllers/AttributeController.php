<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\AttributeRequest;
    use App\Http\Services\AttributeService;
    use App\Http\Services\CustomerService;
    use App\Http\Services\ProductService;
    use App\Models\Attribute;
    use App\Models\Customer;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class AttributeController extends Controller {
        
        protected object $attributeService;
        
        public function __construct ( AttributeService $attributeService ) {
            $this -> attributeService = $attributeService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllAttributes', Attribute::class );
            $data[ 'title' ] = 'All Attributes';
            $data[ 'attributes' ] = $this -> attributeService -> all ();
            return view ( 'settings.attributes.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Attribute::class );
            $data[ 'title' ] = 'Add Attributes';
            return view ( 'settings.attributes.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( AttributeRequest $request ) {
            $this -> authorize ( 'create', Attribute::class );
            try {
                DB ::beginTransaction ();
                $attribute = $this -> attributeService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $attribute ) and $attribute -> id > 0 )
                    return redirect ( route ( 'attributes.edit', [ 'attribute' => $attribute -> id ] ) ) -> with ( 'message', 'Attribute has been added.' );
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
         * @param object $attribute
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Attribute $attribute ) {
            $this -> authorize ( 'edit', $attribute );
            $data[ 'title' ] = 'Edit Attribute';
            $data[ 'attribute' ] = $attribute;
            return view ( 'settings.attributes.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( AttributeRequest $request, Attribute $attribute ) {
            $this -> authorize ( 'edit', $attribute );
            try {
                DB ::beginTransaction ();
                $this -> attributeService -> edit ( $request, $attribute );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Attribute has been updated.' );
                
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
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( Attribute $attribute ) {
            $this -> authorize ( 'delete', $attribute );
            $attribute -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Attribute has been deleted.' );
        }
        
        public function fetch_attribute_terms ( Request $request ) {
            $attribute_id = $request -> input ( 'attribute_id' );
            
            if ( isset( $attribute_id ) && $attribute_id > 0 ) {
                $terms = ( new AttributeService() ) -> fetch_attribute_terms ( $attribute_id );
                return view ( 'settings.attributes.terms-options', compact ( 'terms' ) );
            }
        }
        
        public function get_attributes ( Request $request ) {
            $attributes = ( new AttributeService() ) -> customer_attributes ( $request -> input ( 'customer_id' ) );
            if ( count ( $attributes ) < 1 )
                $attributes = ( new AttributeService() ) -> all ();
            return view ( 'settings.attributes.attributes-options', compact ( 'attributes' ) );
        }
        
        public function get_products_by_attributes ( Request $request ) {
            $products = ( new ProductService() ) -> get_products_by_attributes ( $request -> input ( 'attribute_id' ) );
            
            if ( $request -> has ( 'customer_id' ) && $request -> filled ( 'customer_id' ) && $request -> input ( 'customer_id' ) > 0 ) {
                $customer = Customer ::find ( $request -> input ( 'customer_id' ) );
                $customer_products = ( new CustomerService() ) -> create_array_of_products ( $customer );
            }
            else
                $customer_products = [];
            
            return view ( 'sales.customer-products', compact ( 'products', 'customer_products' ) );
        }
    }
