<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CategoryRequest;
    use App\Http\Services\CategoryService;
    use App\Models\Category;
    use App\Services\GeneralService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class CategoryController extends Controller {
        
        protected object $categoryService;
        
        public function __construct ( CategoryService $categoryService ) {
            $this -> categoryService = $categoryService;
        }
        
        public function index (): View {
            $this -> authorize ( 'viewAllCategories', Category::class );
            $data[ 'title' ]      = 'All Categories';
            $data[ 'categories' ] = $this -> categoryService -> all ();
            return view ( 'settings.categories.index', $data );
        }
        
        public function create (): View {
            $this -> authorize ( 'create', Category::class );
            $data[ 'title' ]      = 'Add Categories';
            $tree                 = ( new GeneralService() ) -> buildTree ( collect ( ( new CategoryService() ) -> all () ) -> toArray () );
            $options              = ( new GeneralService() ) -> convertToOptions ( $tree, false );
            $data[ 'categories' ] = $options;
            return view ( 'settings.categories.create', $data );
        }
        
        public function store ( CategoryRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Category::class );
            try {
                DB ::beginTransaction ();
                $category = $this -> categoryService -> save ( $request );
                DB ::commit ();
                
                if ( !empty( $category ) and $category -> id > 0 )
                    return redirect () -> back () -> with ( 'message', 'Category has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( Category $category ): View {
            $this -> authorize ( 'edit', $category );
            $data[ 'title' ]      = 'Edit Countries';
            $data[ 'category' ]   = $category;
            $tree                 = ( new GeneralService() ) -> buildTree ( collect ( ( new CategoryService() ) -> all () ) -> toArray () );
            $options              = ( new GeneralService() ) -> convertToOptions ( $tree, false, 0, $category -> parent_id );
            $data[ 'categories' ] = $options;
            return view ( 'settings.categories.update', $data );
        }
        
        public function update ( CategoryRequest $request, Category $category ): RedirectResponse {
            $this -> authorize ( 'edit', $category );
            try {
                DB ::beginTransaction ();
                $this -> categoryService -> edit ( $request, $category );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Category has been updated.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function destroy ( Category $category ): RedirectResponse {
            $this -> authorize ( 'delete', $category );
            $category -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Category has been deleted.' );
        }

        public function updateStatus(Request $request, Category $category)
        {
            $this->authorize('delete', $category);
    
            $category->status = $category->status === 'active' ? 'inactive' : 'active';
            $category->save();
    
            return redirect()->back()->with('success', 'Category status updated successfully.');
        }
    }
