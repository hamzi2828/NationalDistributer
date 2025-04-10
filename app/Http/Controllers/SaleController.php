<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\SaleRequest;
    use App\Http\Services\AttributeService;
    use App\Http\Services\CourierService;
    use App\Http\Services\CustomerService;
    use App\Http\Services\GeneralLedgerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\SaleService;
    use App\Http\Services\SiteSettingService;
    use App\Http\Services\UserService;
    use App\Models\Customer;
    use App\Models\Product;
    use App\Models\Sale;
    use App\Notifications\SendTrackingEmailNotification;
    use Exception;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class SaleController extends Controller {

        protected object $saleService;
        protected object $productService;
        protected object $customerService;
        protected object $generalLedgerService;

        public function __construct ( SaleService $saleService, CustomerService $customerService, ProductService $productService, GeneralLedgerService $generalLedgerService ) {
            $this -> saleService          = $saleService;
            $this -> productService       = $productService;
            $this -> customerService      = $customerService;
            $this -> generalLedgerService = $generalLedgerService;
        }

        /**
         * --------------
         * Display a listing of the resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function index () {
            $this -> authorize ( 'viewAllSales', Sale::class );
            $data[ 'title' ]     = 'All Sales';
            $data[ 'sales' ]     = $this -> saleService -> all ();
            $data[ 'customers' ] = $this -> customerService -> all ();
            $data[ 'users' ]     = ( new UserService() ) -> all ();
            return view ( 'sales.index', $data );
        }

        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function create () {
            $this -> authorize ( 'create', Sale::class );
            $data[ 'title' ]     = 'Sale Product(s)';
            $data[ 'customers' ] = collect ( $this -> customerService -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'products' ]  = $this -> productService -> active_products_with_stock ();
            $data[ 'couriers' ]  = ( new CourierService() ) -> all ();
            $data[ 'settings' ]  = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'sales.create', $data );
        }

        public function store ( SaleRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Sale::class );

            try {

                DB ::beginTransaction ();
                $sale = $this -> saleService -> sale ( $request );
                $this -> saleService -> sale_products ( $request, $sale );

                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Sale has been created.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        /**
         * --------------
         * Show the form for creating a new resource.
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function sale_by_attribute () {
            $this -> authorize ( 'create_sale_attribute', Sale::class );
            $data[ 'title' ]      = 'Sale Product(s)';
            $data[ 'customers' ]  = collect ( $this -> customerService -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'products' ]   = $this -> productService -> products_with_stock ();
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            return view ( 'sales.create-attribute', $data );
        }

        /**
         * --------------
         * Show the form for editing the specified resource.
         * @param object $sale
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function edit ( Sale $sale ) {
            $this -> authorize ( 'edit', $sale );

            $data[ 'title' ]             = 'Edit Sale';
            $data[ 'sale' ]              = $sale;
            $data[ 'products' ]          = $this -> productService -> active_products_with_stock ();
            $data[ 'sales' ]             = $this -> saleService -> get_sale_by_attribute_wise ( $sale -> id );
            $data[ 'simple_sales' ]      = $this -> saleService -> get_simple_sold_products ( $sale -> id );
            $data[ 'selected_products' ] = $this -> saleService -> create_array_of_sold_products ( $sale );
            $data[ 'customers' ]         = collect ( $this -> customerService -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'couriers' ]          = ( new CourierService() ) -> all ();
            $data[ 'settings' ]          = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'sales.update-2', $data );
        }

        //        public function edit ( Sale $sale ) {
        //            $this -> authorize ( 'edit', $sale );
        //
        //            $customer = Customer ::find ( $sale -> customer_id );
        //            $data[ 'title' ] = 'Edit Sale';
        //            //            $data[ 'customer' ] = $customer -> load ( 'prices.product' );
        //            $data[ 'products' ] = ( new ProductService() ) -> all ();
        //            $data[ 'sale' ] = $sale -> load ( 'products.product' );
        //            $data[ 'selected_products' ] = $this -> saleService -> create_array_of_sold_products ( $sale );
        //            return view ( 'sales.update', $data );
        //        }

        public function edit_2 ( Sale $sale ) {
            $customer        = Customer ::find ( $sale -> customer_id );
            $data[ 'title' ] = 'Edit Sale';
            //            $data[ 'customer' ] = $customer -> load ( 'prices.product' );
            $data[ 'sale' ]              = $sale;
            $data[ 'products' ]          = ( new ProductService() ) -> all ();
            $data[ 'sales' ]             = $this -> saleService -> get_sale_by_attribute_wise ( $sale -> id );
            $data[ 'selected_products' ] = $this -> saleService -> create_array_of_sold_products ( $sale );
            $data[ 'couriers' ]          = ( new CourierService() ) -> all ();
            $data[ 'settings' ]          = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'sales.update-2', $data );
        }

        /**
         * --------------
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $sale
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function update ( Request $request, Sale $sale ) {
            $this -> authorize ( 'edit', $sale );
            try {
                DB ::beginTransaction ();
                $this -> saleService -> edit_sale ( $request, $sale );
                $this -> saleService -> delete_sold_products ( $sale -> id );
                $this -> saleService -> sale_products ( $request, $sale );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Sale has been updated.' );

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
         * Update the specified resource in storage.
         * @param \Illuminate\Http\Request $request
         * @param object $sale
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function close_sale ( Request $request, Sale $sale ) {
            $this -> authorize ( 'close_bill', $sale );
            try {

                if ( $sale -> sale_closed == '1' )
                    return redirect ( route ( 'sales.index' ) ) -> with ( 'error', 'Sale has already been closed.' );

                $validated = $this -> saleService -> validate_sale ( $sale );

                if ( $validated ) {
                    DB ::beginTransaction ();
                    $this -> saleService -> close_sale ( $sale );
                    $this -> generalLedgerService -> save_sale_ledger ( $sale );
                    DB ::commit ();
                    return redirect ( route ( 'sales.index' ) ) -> with ( 'message', 'Sale has been closed.' );
                }
                else
                    return redirect ( route ( 'sales.index' ) ) -> with ( 'error', '1 or more products are out of stock.' );
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
         * @param object $sale
         * @return \Illuminate\Http\Response
         * --------------
         */

        public function destroy ( Sale $sale ) {
            $this -> authorize ( 'delete', $sale );
            try {
                DB ::beginTransaction ();
                $this -> saleService -> delete_sale ( $sale );
                DB ::commit ();
                return redirect () -> back () -> with ( 'message', 'Sale has been deleted.' );

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
         * @param Request $request
         * @return string|void
         * load added product for sale
         * --------------
         */

        public function add_product_for_sale ( Request $request ) {
            $product_id  = $request -> input ( 'product_id' );
            $customer_id = $request -> input ( 'customer_id' );
            if ( $product_id > 0 && is_numeric ( $product_id ) && $customer_id > 0 && is_numeric ( $customer_id ) ) {
                $product           = Product ::find ( $product_id );
                $data[ 'product' ] = $product;
                $data[ 'row' ]     = $request -> input ( 'row' );
                return view ( 'sales.add-product-for-sale', $data ) -> render ();
            }
        }

        public function add_product_for_quick_sale ( Request $request ) {
            $product_id  = $request -> input ( 'product_id' );
            $customer_id = $request -> input ( 'customer_id' );
            if ( $product_id > 0 && is_numeric ( $product_id ) && $customer_id > 0 && is_numeric ( $customer_id ) ) {
                $product           = Product ::find ( $product_id );
                $data[ 'product' ] = $product;
                $data[ 'row' ]     = $request -> input ( 'row' );
                return view ( 'sales.add-product-for-quick-sale', $data ) -> render ();
            }
        }

        /**
         * --------------
         * @param Request $request
         * @return string|void
         * load added product for sale by barcode
         * --------------
         */

        public function add_product_for_sale_by_barcode ( Request $request ) {
            $barcode     = $request -> input ( 'barcode' );
            $customer_id = $request -> input ( 'customer_id' );
            if ( !empty( trim ( $barcode ) ) && $customer_id > 0 && is_numeric ( $customer_id ) ) {
                $product           = Product ::where ( [ 'barcode' => $barcode ] ) -> first ();
                $data[ 'product' ] = $product;
                $data[ 'data' ]    = view ( 'sales.add-product-for-sale', $data ) -> render ();
                echo json_encode ( $data );
            }
        }

        /**
         * --------------
         * @param Request $request
         * @return void
         * calculate price of product
         * --------------
         */

        public function get_price_by_sale_quantity ( Request $request ) {
            $product_id = $request -> input ( 'product_id' );
            $sale_qty   = $request -> input ( 'sale_qty' );
            $response   = $this -> saleService -> get_price_by_sale_quantity ( $product_id, $sale_qty );
            echo json_encode ( $response );
        }

        /**
         * --------------
         * @param Request $request
         * @param Sale $sale
         * @return \Illuminate\Http\RedirectResponse|void
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * refund sale
         * --------------
         */

        public function refund_sale ( Request $request, Sale $sale ) {
            $this -> authorize ( 'sale_refund', $sale );
            try {

                if ( $sale -> refunded == '1' )
                    return redirect ( route ( 'sales.index' ) ) -> with ( 'error', 'Sale has already been refunded.' );

                DB ::beginTransaction ();
                $this -> generalLedgerService -> reverse_sale_ledger ( $sale );
                $this -> saleService -> refund_sale ( $sale );
                DB ::commit ();
                return redirect ( route ( 'sales.index' ) ) -> with ( 'message', 'Sale has been refunded.' );
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

        public function sale_products_by_attributes ( Request $request ) {
            $products = ( new ProductService() ) -> get_products_by_attributes ( $request -> input ( 'attribute_id' ) );
            return view ( 'sales.attribute-products', compact ( 'products' ) );
        }

        public function quick_sale (): View {
            $this -> authorize ( 'quick_sale', Sale::class );
            $data[ 'title' ]     = 'Quick Sale';
            $data[ 'customers' ] = collect ( $this -> customerService -> all () ) -> where ( 'active', '=', '1' );
            $data[ 'products' ]  = $this -> productService -> active_products_with_stock ();
            $data[ 'couriers' ]  = ( new CourierService() ) -> all ();
            $data[ 'settings' ]  = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'sales.quick-sale', $data );
        }

        public function tracking ( Sale $sale ) {
            $data[ 'title' ] = 'Sale Tracking No';
            $data[ 'sale' ]  = $sale;
            return view ( 'sales.tracking', $data );
        }

        public function add_tracking ( Request $request, Sale $sale ) {
            try {
                DB ::beginTransaction ();
                $this -> saleService -> add_tracking ( $request, $sale );
                DB ::commit ();

                if ( $sale -> wasChanged ( 'tracking_no' ) )
                    $sale -> customer -> notify ( new SendTrackingEmailNotification( $sale ) );

                return redirect () -> back () -> with ( 'message', 'Tracking no has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function status ( Request $request, Sale $sale ) {
            $this -> authorize ( 'status', $sale );
            try {
                DB ::beginTransaction ();
                $sale -> status = !$sale -> status;
                $sale -> update ();
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Sale status has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

    }
