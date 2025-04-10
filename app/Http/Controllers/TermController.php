<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\TermRequest;
    use App\Http\Services\AttributeService;
    use App\Http\Services\TermService;
    use App\Models\Term;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class TermController extends Controller {
        
        protected object $termService;
        protected object $attributeService;
        
        public function __construct ( TermService $termService, AttributeService $attributeService ) {
            $this -> termService = $termService;
            $this -> attributeService = $attributeService;
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllTerms', Term::class );
            $data[ 'title' ] = 'All Terms';
            $data[ 'terms' ] = $this -> termService -> all ();
            return view ( 'settings.terms.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', Term::class );
            $data[ 'title' ] = 'Add Terms';
            $data[ 'attributes' ] = $this -> attributeService -> all ();
            return view ( 'settings.terms.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( TermRequest $request ) {
            $this -> authorize ( 'create', Term::class );
            try {
                DB ::beginTransaction ();
                $this -> termService -> save ( $request );
                DB ::commit ();
                
                return redirect ( route ( 'terms.index' ) ) -> with ( 'message', 'Term(s) has been added.' );
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
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Term $term ) {
            $this -> authorize ( 'edit', $term );
            $data[ 'title' ] = 'Edit Terms';
            $data[ 'term' ] = $term;
            $data[ 'attributes' ] = $this -> attributeService -> all ();
            return view ( 'settings.terms.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( TermRequest $request, Term $term ) {
            $this -> authorize ( 'edit', $term );
            try {
                DB ::beginTransaction ();
                $this -> termService -> edit ( $request, $term );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Term has been updated.' );
                
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
        
        public function destroy ( Term $term ) {
            $this -> authorize ( 'delete', $term );
            $term -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Term has been deleted.' );
        }
    }
