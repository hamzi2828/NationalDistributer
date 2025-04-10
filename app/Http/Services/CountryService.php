<?php

    namespace App\Http\Services;

    use App\Models\Country;

    class CountryService {

        /**
         * --------------
         * @return mixed
         * get all countries
         * --------------
         */

        public function all () {
            return Country ::latest () -> get ();
        }

        /**
         * --------------
         * @param $request
         * @return mixed
         * save countries
         * --------------
         */

        public function save ( $request ) {
            return Country ::create ( [
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
         * update countries
         * --------------
         */

        public function edit ( $request, $country ) {
            $country -> user_id = auth () -> user () -> id;
            $country -> title = $request -> input ( 'title' );
            $country -> update ();
        }

    }
