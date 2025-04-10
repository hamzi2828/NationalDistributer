<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Helpers\AdjustmentService;
    use App\Http\Services\BranchService;
    use App\Http\Services\GeneralLedgerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\StockReturnService;
    use App\Models\Product;
    use App\Models\Stock;
    use App\Models\StockReturn;
    use App\Models\User;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use PHPUnit\Exception;
    
    class AdjustmentController extends Controller {
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function index () {
            $this -> authorize ( 'viewAllAdjustmentsIncrease', User::class );
            $data[ 'title' ]  = 'All Adjustments (Increase)';
            $data[ 'stocks' ] = ( new AdjustmentService() ) -> all ();
            return view ( 'adjustments.index', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * show add adjustment increase form
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function create () {
            $this -> authorize ( 'addAdjustmentsIncrease', User::class );
            $data[ 'title' ]    = 'Add Adjustments (Increase)';
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            $data[ 'branches' ] = ( new BranchService() ) -> all ();
            return view ( 'adjustments.create', $data );
        }
        
        public function add_stock_increase_products ( Request $request ): string {
            $product = Product ::findorFail ( $request -> input ( 'product_id' ) );
            $row     = $request -> input ( 'nextRow' );
            return view ( 'adjustments.add-stock-increase-products', compact ( 'product', 'row' ) ) -> render ();
        }
        
        /**
         * --------------
         * Store a newly created resource in storage
         * @param \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function store ( Request $request ) {
            try {
                DB ::beginTransaction ();
                $stock = ( new AdjustmentService() ) -> save ( $request );
                ( new AdjustmentService() ) -> save_stock_products ( $stock -> id, $request );
                ( new GeneralLedgerService() ) -> save_adjustment_added_ledger ( $stock );
                DB ::commit ();
                
                if ( !empty( $stock ) and $stock -> id > 0 )
                    return redirect ( route ( 'adjustments.edit', [ 'adjustment' => $stock -> id ] ) ) -> with ( 'message', 'Adjustment has been added.' );
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
        
        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function edit ( Stock $adjustment ) {
            $this -> authorize ( 'editAdjustmentsIncrease', User::class );
            $data[ 'title' ] = 'Edit Adjust (Increase)';
            $data[ 'stock' ] = $adjustment -> load ( [
                                                         'products' => function ( $query ) {
                                                             $query -> orderBy ( 'id', 'DESC' );
                                                         }
                                                     ] );
            return view ( 'adjustments.update', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update ( Request $request, Stock $adjustment ) {
            $this -> authorize ( 'editAdjustmentsIncrease', User::class );
            try {
                DB ::beginTransaction ();
                ( new AdjustmentService() ) -> edit ( $request, $adjustment );
                ( new AdjustmentService() ) -> update_stock_products ( $request );
                ( new GeneralLedgerService() ) -> update_adjustment_added_ledger ( $adjustment );
                
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Adjustment has been updated.' );
                
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
        
        public function destroy ( Stock $adjustment ) {
            $this -> authorize ( 'deleteAdjustmentsIncrease', User::class );
            try {
                DB ::beginTransaction ();
                
                $adjustment -> load ( 'products', 'ledgers' );
                
                if ( count ( $adjustment -> products ) > 0 ) {
                    foreach ( $adjustment -> products as $item ) {
                        $item -> delete ();
                    }
                }
                
                if ( count ( $adjustment -> ledgers ) > 0 ) {
                    foreach ( $adjustment -> ledgers as $ledgers ) {
                        $ledgers -> delete ();
                    }
                }
                
                $adjustment -> delete ();
                DB ::commit ();
                
                return redirect () -> back () -> with ( 'message', 'Adjustment has been deleted.' );
            }
            catch ( QueryException $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
            catch ( Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () );
            }
        }
        
        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function decrease () {
            $this -> authorize ( 'viewAllAdjustmentsDecrease', User::class );
            $data[ 'title' ]   = 'All Adjustments (Decrease)';
            $data[ 'returns' ] = ( new StockReturnService() ) -> all ( 'adjustment-decrease' );
            return view ( 'adjustments.decrease', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function add_decrease () {
            $this -> authorize ( 'addAdjustmentsDecrease', User::class );
            $data[ 'title' ]    = 'Add Adjustment (Decrease)';
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            return view ( 'adjustments.add_decrease', $data );
        }
        
        /**
         * --------------
         * @param Request $request
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * store adjustment decrease
         * --------------
         */
        
        public function store_adjustment_decrease ( Request $request ) {
            $this -> authorize ( 'addAdjustmentsDecrease', User::class );
            try {
                DB ::beginTransaction ();
                $stock = ( new AdjustmentService() ) -> add_adjustment_decrease ( $request );
                ( new StockReturnService() ) -> return_products ( $request, $stock -> id );
                ( new GeneralLedgerService() ) -> save_adjustment_decrease_ledger ( $stock );
                DB ::commit ();
                return redirect ( route ( 'adjustments.edit-adjustment-decrease', [ 'stock_return' => $stock -> id ] ) ) -> with ( 'message', 'Adjustment decrease has been added.' );
                
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
        
        public function edit_decrease ( StockReturn $stockReturn ) {
            $this -> authorize ( 'editAdjustmentsDecrease', User::class );
            $data[ 'title' ]   = 'Edit Adjustment (Decrease)';
            $data[ 'returns' ] = $stockReturn -> load ( 'products.product' );
            return view ( 'adjustments.edit-decrease', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update_adjustment_decrease ( Request $request, StockReturn $stockReturn ) {
            $this -> authorize ( 'editAdjustmentsDecrease', User::class );
            try {
                DB ::beginTransaction ();
                ( new StockReturnService() ) -> update_returns ( $stockReturn );
                ( new StockReturnService() ) -> delete_returned_products ( $stockReturn -> id );
                ( new StockReturnService() ) -> return_products ( $request, $stockReturn -> id );
                ( new GeneralLedgerService() ) -> update_adjustment_decrease_ledger ( $stockReturn );
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
        
        public function delete_adjustment_decrease ( StockReturn $stockReturn ) {
            $this -> authorize ( 'deleteAdjustmentsDecrease', User::class );
            try {
                DB ::beginTransaction ();
                ( new StockReturnService() ) -> delete_returns ( $stockReturn );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Adjustment has been deleted.' );
                
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
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function damage_stocks () {
            $this -> authorize ( 'allDamageLoss', User::class );
            $data[ 'title' ]   = 'All Damage/Loss';
            $data[ 'returns' ] = ( new StockReturnService() ) -> all ( 'damage-loss-stock' );
            return view ( 'adjustments.damage-stocks', $data );
        }
        
        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function add_damage_stocks () {
            $this -> authorize ( 'addDamageLoss', User::class );
            $data[ 'title' ]    = 'Add Damage/Loss';
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            return view ( 'adjustments.add-damage-stock', $data );
        }
        
        /**
         * --------------
         * @param Request $request
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * store adjustment decrease
         * --------------
         */
        
        public function store_damage_stocks ( Request $request ) {
            $this -> authorize ( 'addDamageLoss', User::class );
            try {
                DB ::beginTransaction ();
                $stock = ( new AdjustmentService() ) -> add_damage_stock ( $request );
                ( new StockReturnService() ) -> return_products ( $request, $stock -> id );
                ( new GeneralLedgerService() ) -> save_damage_stock_ledger ( $stock );
                DB ::commit ();
                return redirect ( route ( 'adjustments.edit-damage-stocks', [ 'stock_return' => $stock -> id ] ) ) -> with ( 'message', 'Damage/loss stock has been added.' );
                
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
        
        public function edit_damage_stocks ( StockReturn $stockReturn ) {
            $this -> authorize ( 'editDamageLoss', User::class );
            $data[ 'title' ]   = 'Edit Damage/Loss';
            $data[ 'returns' ] = $stockReturn -> load ( 'products.product' );
            return view ( 'adjustments.edit-damage-stock', $data );
        }
        
        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param int $id
         * @return \Illuminate\Http\Response
         * --------------
         */
        
        public function update_damage_stocks ( Request $request, StockReturn $stockReturn ) {
            $this -> authorize ( 'editDamageLoss', User::class );
            try {
                DB ::beginTransaction ();
                ( new StockReturnService() ) -> update_returns ( $stockReturn );
                ( new StockReturnService() ) -> delete_returned_products ( $stockReturn -> id );
                ( new StockReturnService() ) -> return_products ( $request, $stockReturn -> id );
                ( new GeneralLedgerService() ) -> update_damage_stock_ledger ( $stockReturn );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Damage/loss stock has been updated.' );
                
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
        
        public function delete_damage_stocks ( StockReturn $stockReturn ) {
            $this -> authorize ( 'deleteDamageLoss', User::class );
            try {
                DB ::beginTransaction ();
                ( new StockReturnService() ) -> delete_returns ( $stockReturn );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Damage/loss stock has been deleted.' );
                
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
    }
