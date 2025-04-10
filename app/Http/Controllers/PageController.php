<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\PageService;
    use App\Models\Page;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class PageController extends Controller {
        
        public function index (): View {
            $this -> authorize ( 'all', Page::class );
            $data[ 'title' ] = 'All Pages';
            $data[ 'pages' ] = ( new PageService() ) -> all ();
            return view ( 'settings.pages.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Page::class );
            $data[ 'title' ] = 'Add Page';
            return view ( 'settings.pages.create', $data );
        }
        
        public function store ( Request $request ): RedirectResponse {
            $this -> authorize ( 'create', Page::class );
            try {
                DB ::beginTransaction ();
                $page = ( new PageService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $page ) and $page -> id > 0 )
                    return redirect () -> back () -> with ( 'message', 'Page has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Page $page ): View {
            $this -> authorize ( 'edit', $page );
            $data[ 'title' ] = 'Edit Page';
            $data[ 'page' ]  = $page;
            return view ( 'settings.pages.update', $data );
        }
        
        public function update ( Request $request, Page $page ): RedirectResponse {
            $this -> authorize ( 'update', $page );
            try {
                DB ::beginTransaction ();
                ( new PageService() ) -> edit ( $request, $page );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Page has been updated.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Page $page ): RedirectResponse {
            $this -> authorize ( 'delete', $page );
            try {
                DB ::beginTransaction ();
                ( new PageService() ) -> delete ( $page );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Page has been deleted.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
