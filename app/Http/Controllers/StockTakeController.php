<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\CategoryRequest;
    use App\Http\Services\AttributeService;
    use App\Http\Services\CategoryService;
    use App\Http\Services\ReportingService;
    use App\Http\Services\StockTakeService;
    use App\Models\StockTake;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class StockTakeController extends Controller {
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllStockTake', StockTake::class );
            $data[ 'title' ]       = 'All Stock Take';
            $data[ 'stock_takes' ] = ( new StockTakeService() ) -> all ();
            return view ( 'stock-takes.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', StockTake::class );
            $data[ 'title' ]      = 'Add Stock Take (Attribute)';
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'products' ]   = ( new ReportingService() ) -> attribute_wise_quantity_report ();
            return view ( 'stock-takes.create', $data );
        }
        
        public function create_category_wise () {
            $this -> authorize ( 'create_category_category', StockTake::class );
            $data[ 'title' ]            = 'Add Stock Take (Category)';
            $data[ 'categories' ]       = ( new CategoryService() ) -> all ();
            $data[ 'categoryProducts' ] = ( new ReportingService() ) -> category_wise_products ();
            return view ( 'stock-takes.create-category-wise', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( Request $request ) {
            $this -> authorize ( 'create', StockTake::class );
            try {
                DB ::beginTransaction ();
                $uuid = ( new StockTakeService() ) -> save ( $request );
                DB ::commit ();
                
                if ( !empty( trim ( $uuid ) ) )
                    return redirect ( route ( 'stock-takes.edit', [ 'stock_take' => $uuid ] ) ) -> with ( 'message', 'Stock take has been added.' );
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
         * @param object $stockTake
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( StockTake $stock_take ) {
            $this -> authorize ( 'edit', $stock_take );
            $stockTake = StockTake ::where ( [ 'uuid' => $stock_take -> uuid ] ) -> get ();
            $title     = 'Edit Stock Take';
            $products  = ( new StockTakeService() ) -> get_stock_take_by_uuid ( $stock_take -> uuid );
            return view ( 'stock-takes.update', compact ( 'products', 'stock_take', 'title' ) );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $stockTake
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( Request $request, StockTake $stockTake ) {
            $this -> authorize ( 'edit', $stockTake );
            try {
                DB ::beginTransaction ();
                ( new StockTakeService() ) -> edit ( $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Stock take has been updated.' );
                
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
         * @param object $stockTake
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function destroy ( StockTake $stockTake ) {
            $this -> authorize ( 'delete', $stockTake );
            ( new StockTakeService() ) -> delete ( $stockTake );
            
            return redirect () -> back () -> with ( 'message', 'Stock take has been deleted.' );
        }
    }
