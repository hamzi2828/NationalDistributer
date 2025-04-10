<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\ManufacturerRequest;
    use App\Http\Services\ManufacturerService;
    use App\Models\Manufacturer;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class ManufacturerController extends Controller {
        
        protected object $manufacturerService;
        
        public function __construct ( ManufacturerService $manufacturerService ) {
            $this -> manufacturerService = $manufacturerService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllManufacturers', Manufacturer::class );
            $data[ 'title' ] = 'All Manufacturers';
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            return view ( 'settings.manufacturers.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Manufacturer::class );
            $data[ 'title' ] = 'Add Manufacturers';
            return view ( 'settings.manufacturers.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( ManufacturerRequest $request ) {
            $this -> authorize ( 'create', Manufacturer::class );
            try {
                DB ::beginTransaction ();
                $manufacturer = $this -> manufacturerService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $manufacturer ) and $manufacturer -> id > 0 )
                    return redirect ( route ( 'manufacturers.edit', [ 'manufacturer' => $manufacturer -> id ] ) ) -> with ( 'message', 'Manufacturer has been added.' );
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
         * @param object $manufacturer
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Manufacturer $manufacturer ) {
            $this -> authorize ( 'edit', $manufacturer );
            $data[ 'title' ] = 'Edit Manufacturers';
            $data[ 'manufacturer' ] = $manufacturer;
            return view ( 'settings.manufacturers.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( ManufacturerRequest $request, Manufacturer $manufacturer ) {
            $this -> authorize ( 'edit', $manufacturer );
            try {
                DB ::beginTransaction ();
                $this -> manufacturerService -> edit ( $request, $manufacturer );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Manufacturer has been updated.' );
                
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
         * @param object $manufacturer
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( Manufacturer $manufacturer ) {
            $this -> authorize ( 'delete', $manufacturer );
            $manufacturer -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Manufacturer has been deleted.' );
        }
    }
