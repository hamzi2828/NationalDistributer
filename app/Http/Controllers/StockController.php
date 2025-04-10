<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Requests\StockRequest;
    use App\Http\Services\BranchService;
    use App\Http\Services\CustomerService;
    use App\Http\Services\GeneralLedgerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\StockService;
    use App\Http\Services\VendorService;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\Stock;
    use App\Models\User;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use PHPUnit\Exception;
    
    class StockController extends Controller {
        
        protected object $stockService;
        protected object $vendorService;
        protected object $productService;
        protected object $generalLedgerService;
        protected object $branchService;
        
        public function __construct ( StockService $stockService, VendorService $vendorService, ProductService $productService, GeneralLedgerService $generalLedgerService, BranchService $branchService ) {
            $this -> stockService         = $stockService;
            $this -> vendorService        = $vendorService;
            $this -> productService       = $productService;
            $this -> generalLedgerService = $generalLedgerService;
            $this -> branchService        = $branchService;
        }
        
        public function index () {
            $this -> authorize ( 'viewAllStocks', Stock::class );
            $data[ 'title' ]  = 'All Stocks';
            $data[ 'stocks' ] = $this -> stockService -> all ();
            return view ( 'stocks.index', $data );
        }
        
        public function customers () {
            $this -> authorize ( 'viewAllCustomerStockReturns', Stock::class );
            $data[ 'title' ]  = 'All Stock Returns (Customer)';
            $data[ 'stocks' ] = $this -> stockService -> all ( 'customer-return' );
            return view ( 'stocks.customers', $data );
        }
        
        
        public function create () {
            $this -> authorize ( 'create', Stock::class );
            $data[ 'title' ]    = 'Add Stocks';
            $data[ 'vendors' ]  = collect ( $this -> vendorService -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'products' ] = $this -> productService -> active_products ();
            $data[ 'branches' ] = $this -> branchService -> all ();
            return view ( 'stocks.create', $data );
        }
        
        public function store ( StockRequest $request ) {
            $this -> authorize ( 'create', Stock::class );
            try {
                DB ::beginTransaction ();
                $stock = $this -> stockService -> save ( $request );
                $this -> stockService -> save_stock_products ( $stock -> id, $request );
                $this -> generalLedgerService -> save_stock_added_ledger ( $stock );
                DB ::commit ();
                
                if ( !empty( $stock ) and $stock -> id > 0 )
                    return redirect ( route ( 'stocks.edit', [ 'stock' => $stock -> id ] ) ) -> with ( 'message', 'Stock has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' ) -> withInput ();
                
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
        
        public function edit ( Stock $stock ) {
            $this -> authorize ( 'edit', $stock );
            $data[ 'title' ] = $stock -> stock_type == 'vendor' ? 'Edit Stock' : 'Edit Stock Return (Customer)';
            
            $data[ 'stock' ]          = $stock;
            $data[ 'attributes' ]     = ( new StockService() ) -> get_stock_attribute_wise ( $stock );
            $data[ 'simple_stock' ]   = ( new StockService() ) -> get_simple_stock ( $stock );
            $data[ 'vendors' ]        = collect ( $this -> vendorService -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'branches' ]       = $this -> branchService -> all ();
            $data[ 'customers' ]      = ( new CustomerService() ) -> all ();
            $data[ 'stock_products' ] = $this -> productService -> active_products ();
            return view ( 'stocks.update', $data );
        }
        
        public function update ( StockRequest $request, Stock $stock ) {
            $this -> authorize ( 'edit', $stock );
            try {
                DB ::beginTransaction ();
                $this -> stockService -> edit ( $request, $stock );
                $this -> stockService -> update_stock_products ( $request );
                
                if ( $stock -> stock_type == 'customer-return' ) {
//                    $this -> generalLedgerService -> update_stock_customer_return_ledger ( $stock );
                    $this -> generalLedgerService -> upsert_stock_customer_return_ledger ( $stock );
                }
                else
                    $this -> generalLedgerService -> update_stock_added_ledger ( $stock );
                
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Stock has been updated.' );
                
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
        
        public function destroy ( Stock $stock ) {
            $this -> authorize ( 'delete', $stock );
            
            $stock -> load ( 'products', 'ledgers' );
            
            if ( count ( $stock -> products ) > 0 ) {
                foreach ( $stock -> products as $item ) {
                    $item -> delete ();
                }
            }
            
            if ( count ( $stock -> ledgers ) > 0 ) {
                foreach ( $stock -> ledgers as $ledgers ) {
                    $ledgers -> delete ();
                }
            }
            
            $stock -> delete ();
            
            return redirect () -> back () -> with ( 'message', 'Stock has been deleted.' );
        }
        
        public function validate_invoice_no ( Request $request ) {
            try {
                $exists = $this -> stockService -> validate_invoice_no ( $request );
                return $exists ? 'true' : 'false';
            }
            catch ( QueryException $exception ) {
                return $exception -> getMessage ();
            }
            catch ( Exception $exception ) {
                return $exception -> getMessage ();
            }
        }
        
        public function delete_stock_product ( ProductStock $productStock ) {
            try {
                DB ::beginTransaction ();
                $this -> stockService -> delete_stock_product ( $productStock );
                DB ::commit ();
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
        
        public function add_customer () {
            $this -> authorize ( 'createCustomerStockReturn', Stock::class );
            $data[ 'title' ]     = 'Add Stock Return (Customer)';
            $data[ 'customers' ] = collect ( ( new CustomerService() ) -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'products' ]  = $this -> productService -> active_products ();
            $data[ 'branches' ]  = $this -> branchService -> all ();
            return view ( 'stocks.create-customer-stock', $data );
        } 
        
        public function return_customer_stock ( StockRequest $request ) {
            $this -> authorize ( 'create', Stock::class );
            try {
                DB ::beginTransaction ();
                $stock = $this -> stockService -> save ( $request );
                $this -> stockService -> save_stock_products ( $stock -> id, $request );
                $this -> generalLedgerService -> upsert_stock_customer_return_ledger ( $stock );
                DB ::commit ();
                
                if ( !empty( $stock ) and $stock -> id > 0 )
                    return redirect ( route ( 'stocks.edit', [ 'stock' => $stock -> id ] ) ) -> with ( 'message', 'Stock has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' ) -> withInput ();
                
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
        
        public function check_stock () {
            $this -> authorize ( 'checkStock', User::class );
            $data[ 'title' ]    = 'Check Stock';
            $data[ 'products' ] = $this -> productService -> products_with_stock ();
            return view ( 'stocks.check-stock', $data );
        }
        
        public function get_stock_available_quantity ( Request $request ) {
            $product_id = $request -> input ( 'product_id' );
            
            if ( $product_id > 0 && is_numeric ( $product_id ) ) {
                $product           = Product ::find ( $product_id );
                $data[ 'product' ] = $product;
                $data[ 'row' ]     = $request -> input ( 'row' );
                return view ( 'stocks.product-stock-quantity', $data ) -> render ();
            }
        }
        
        public function add_more_products ( Stock $stock, Request $request ) {
            $this -> authorize ( 'edit', $stock );
            try {
                DB ::beginTransaction ();
                $this -> stockService -> add_more_stock_products ( $stock, $request );
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Stock products have been added.' );
                
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
        
        public function add_stock_products ( Request $request ): string {
            $product = Product ::findorFail ( $request -> input ( 'product_id' ) );
            $row     = $request -> input ( 'nextRow' );
            return view ( 'stocks.add-stock-product', compact ( 'product', 'row' ) ) -> render ();
        }
        
        public function add_customer_return_stock_products ( Request $request ): string {
            $product = Product ::findorFail ( $request -> input ( 'product_id' ) );
            $row     = $request -> input ( 'nextRow' );
            return view ( 'stocks.add-customer-return-stock-products', compact ( 'product', 'row' ) ) -> render ();
        }
        
    }
