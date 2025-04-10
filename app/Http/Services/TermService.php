<?php
    
    namespace App\Http\Services;
    
    use App\Models\Term;
    
    class TermService {
        
        /**
         * --------------
         * @return mixed
         * get all terms
         * --------------
         */
        
        public function all () {
            return Term ::with ( [ 'attribute' ] ) -> latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save terms
         * --------------
         */
        
        public function save ( $request ) {
            $terms = $request -> input ( 'title' );
            if ( count ( $terms ) > 0 ) {
                foreach ( $terms as $term ) {
                    if ( !empty( trim ( $term ) ) ) {
                        Term ::create ( [
                                            'user_id'      => auth () -> user () -> id,
                                            'attribute_id' => $request -> input ( 'attribute-id' ),
                                            'title'        => $term,
                                            'slug'         => str ( $term ) -> slug ( '-' )
                                        ] );
                    }
                }
            }
        }
        
        /**
         * --------------
         * @param $request
         * @param $term
         * @return void
         * update terms
         * --------------
         */
        
        public function edit ( $request, $term ) {
            $term -> user_id = auth () -> user () -> id;
            $term -> attribute_id = $request -> input ( 'attribute-id' );
            $term -> title = $request -> input ( 'title' );
            $term -> update ();
        }
    }