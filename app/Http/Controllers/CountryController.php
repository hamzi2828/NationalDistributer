<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\CountryRequest;
    use App\Http\Services\CountryService;
    use App\Models\Country;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class CountryController extends Controller {

        protected object $countryService;

        public function __construct ( CountryService $countryService ) {
            $this -> countryService = $countryService;
        }

        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function index () {
            $this -> authorize ( 'viewAllCountries', Country::class );
            $data[ 'title' ] = 'All Countries';
            $data[ 'countries' ] = $this -> countryService -> all ();
            return view ( 'settings.countries.index', $data );
        }

        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function create () {
            $this -> authorize ( 'create', Country::class );
            $data[ 'title' ] = 'Add Countries';
            return view ( 'settings.countries.create', $data );
        }

        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function store ( CountryRequest $request ) {
            $this -> authorize ( 'create', Country::class );
            try {
                DB ::beginTransaction ();
                $country = $this -> countryService -> save ( $request );
                DB ::commit ();

                if ( !empty( $country ) and $country -> id > 0 )
                    return redirect ( route ( 'countries.edit', [ 'country' => $country -> id ] ) ) -> with ( 'message', 'Country has been added.' );
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
         * @param object $country
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function edit ( Country $country ) {
            $this -> authorize ( 'edit', $country );
            $data[ 'title' ] = 'Edit Countries';
            $data[ 'country' ] = $country;
            return view ( 'settings.countries.update', $data );
        }

        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\CountryRequest $request
         * @param object $country
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function update ( CountryRequest $request, Country $country ) {
            $this -> authorize ( 'edit', $country );
            try {
                DB ::beginTransaction ();
                $this -> countryService -> edit ( $request, $country );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Country has been updated.' );

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

        public function destroy ( Country $country ) {
            $this -> authorize ( 'delete', $country );
            $country -> delete ();

            return redirect () -> back () -> with ( 'message', 'Country has been deleted.' );
        }
    }
