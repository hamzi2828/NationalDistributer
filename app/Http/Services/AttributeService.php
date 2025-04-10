<?php
    
    namespace App\Http\Services;
    
    use App\Models\Attribute;
    use App\Models\Term;
    use Illuminate\Support\Facades\DB;
    
    class AttributeService {
        
        /**
         * --------------
         * @return mixed
         * get all attributes
         * --------------
         */
        
        public function all () {
            return Attribute ::with ( [ 'terms' ] ) -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save attributes
         * --------------
         */
        
        public function save ( $request ) {
            return Attribute ::create ( [
                                            'user_id' => auth () -> user () -> id,
                                            'title'   => $request -> input ( 'title' ),
                                            'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                        ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $country
         * @return void
         * update attributes
         * --------------
         */
        
        public function edit ( $request, $attribute ) {
            $attribute -> user_id = auth () -> user () -> id;
            $attribute -> title = $request -> input ( 'title' );
            $attribute -> update ();
        }
        
        /**
         * --------------
         * @param $attribute_id
         * @return mixed
         * get all terms related to attribute
         * --------------
         */
        
        public function fetch_attribute_terms ( $attribute_id ) {
            return Term ::where ( [ 'attribute_id' => $attribute_id ] ) -> whereNotIn ( 'id', function ( $query ) {
                $query -> select ( 'term_id' ) -> from ( 'product_terms' );
            } ) -> get ();
        }
        
        public function customer_attributes ( $customer_id ) {
            return DB ::select ( "SELECT ims_attributes.* FROM `ims_attributes` JOIN ims_terms ON ims_attributes.id=ims_terms.attribute_id JOIN ims_product_terms ON ims_terms.id=ims_product_terms.term_id JOIN ims_customer_product_price ON ims_product_terms.product_id=ims_customer_product_price.product_id WHERE ims_customer_product_price.customer_id=$customer_id" );
        }
    }