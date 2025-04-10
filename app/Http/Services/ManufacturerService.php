<?php
    
    namespace App\Http\Services;
    
    use App\Models\Manufacturer;
    
    class ManufacturerService {
        
        /**
         * --------------
         * @return mixed
         * get all manufacturers
         * --------------
         */
        
        public function all () {
            return Manufacturer ::latest () -> get ();
        }
        
        /**
         * --------------
         * @param $request
         * @return mixed
         * save manufacturers
         * --------------
         */
        
        public function save ( $request ) {
            return Manufacturer ::create ( [
                                               'user_id' => auth () -> user () -> id,
                                               'title'   => $request -> input ( 'title' ),
                                               'slug'    => str ( $request -> input ( 'title' ) ) -> slug ( '-' )
                                           ] );
        }
        
        /**
         * --------------
         * @param $request
         * @param $manufacturer
         * @return void
         * update manufacturers
         * --------------
         */
        
        public function edit ( $request, $manufacturer ) {
            $manufacturer -> user_id = auth () -> user () -> id;
            $manufacturer -> title = $request -> input ( 'title' );
            $manufacturer -> update ();
        }
    }