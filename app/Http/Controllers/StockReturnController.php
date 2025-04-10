<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\GeneralLedgerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\StockReturnService;
    use App\Http\Services\VendorService;
    use App\Models\Product;
    use App\Models\Sale;
    use App\Models\StockReturn;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class StockReturnController extends Controller {
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllStockReturns', StockReturn::class );
            $data[ 'title' ]   = 'All Returns (Vendor)';
            $data[ 'returns' ] = ( new StockReturnService() ) -> all ();
            return view ( 'stock-returns.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'create', StockReturn::class );
            $data[ 'title' ]    = 'Add Stock Return (Vendor)';
            $data[ 'vendors' ]  = collect ( ( new VendorService() ) -> all () ) -> where ( 'active', '=', '1' );
            // $data[ 'products' ] = ( new ProductService() ) -> all ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();

            return view ( 'stock-returns.create', $data );
        }
        
        /**
         * --------------
         * Store a newly created resource in storage.
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( Request $request ) {
            $this -> authorize ( 'create', StockReturn::class );
            try {
                DB ::beginTransaction ();
                $return = ( new StockReturnService() ) -> stock_return ( $request );
                ( new StockReturnService() ) -> return_products ( $request, $return -> id );
                ( new GeneralLedgerService() ) -> save_stock_return_ledger ( $return );
                DB ::commit ();
                return redirect ( route ( 'stock-returns.edit', [ 'stock_return' => $return -> id ] ) ) -> with ( 'message', 'Stock has been returned.' );
                
            }
            catch ( QueryException | \Exception $exception ) {
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
        
        public function edit ( StockReturn $stockReturn ) {
            $this -> authorize ( 'edit', $stockReturn );
            $data[ 'title' ]   = 'Edit Stock Return (Vendor)';
            $data[ 'returns' ] = $stockReturn -> load ( 'products.product' );
            return view ( 'stock-returns.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( Request $request, StockReturn $stockReturn ) {
            $this -> authorize ( 'edit', $stockReturn );
            try {
                DB ::beginTransaction ();
                ( new StockReturnService() ) -> update_returns ( $stockReturn );
                ( new StockReturnService() ) -> delete_returned_products ( $stockReturn -> id );
                ( new StockReturnService() ) -> return_products ( $request, $stockReturn -> id );
                ( new GeneralLedgerService() ) -> update_stock_return_ledger ( $stockReturn );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Returned stock has been updated.' );
                
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
        
        public function destroy ( StockReturn $stockReturn ) {
            $this -> authorize ( 'delete', $stockReturn );
            try {
                DB ::beginTransaction ();
                ( new StockReturnService() ) -> delete_returns ( $stockReturn );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Returned stock has been deleted.' );
                
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
        
        public function add_product_for_return ( Request $request ) {
            $product_id = $request -> input ( 'product_id' );
            if ( $product_id > 0 && is_numeric ( $product_id ) ) {
                $product           = Product ::find ( $product_id );
                $data[ 'product' ] = $product;
                return view ( 'stock-returns.return-products', $data ) -> render ();
            }
        }
        
        public function get_price ( Request $request ) {
            $product_id = $request -> input ( 'product_id' );
            $sale_qty   = $request -> input ( 'sale_qty' );
            $response   = ( new StockReturnService() ) -> get_price ( $product_id, $sale_qty );
            echo json_encode ( $response );
        }
    }
