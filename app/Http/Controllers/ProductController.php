<?php

    namespace App\Http\Controllers;

    use App\Http\Requests\ProductRequest;
    use App\Http\Services\AttributeService;
    use App\Http\Services\CategoryService;
    use App\Http\Services\ManufacturerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\TaxService;

    use App\Http\Services\ProductVariationService;
    use App\Http\Services\ReportingService;
    use App\Http\Services\SiteSettingService;
    use App\Models\Category;
    use App\Models\Product;
    use App\Models\ProductImage;
    use App\Models\Stock;
    use App\Models\User;
    use App\Services\GeneralService;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    use Illuminate\Support\Facades\Log;

    class ProductController extends Controller {

        protected object $productService;
        protected object $manufacturerService;
        protected object $categoryService;
        protected object $attributeService;
        protected object $taxService;

        public function __construct ( ProductService $productService, ManufacturerService $manufacturerService, CategoryService $categoryService, AttributeService $attributeService, TaxService $taxService ) {
            $this -> productService      = $productService;
            $this -> manufacturerService = $manufacturerService;
            $this -> categoryService     = $categoryService;
            $this -> attributeService    = $attributeService;
            $this -> taxService          = $taxService;
        }

        public function index (): View {
            $this -> authorize ( 'viewAllProducts', Product::class );
            $data[ 'title' ]         = 'All Products (Detailed)';
            $data[ 'products' ]      = $this -> productService -> all ();
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            $data['taxes']          = $this->taxService->all();
            $tree                    = ( new GeneralService() ) -> buildTree ( collect ( ( new CategoryService() ) -> all () ) -> toArray () );
            $options                 = ( new GeneralService() ) -> convertToOptions ( $tree, false, 0, request ( 'category-id' ) );
            $data[ 'categories' ]    = $options;
            return view ( 'products.index', $data );
        }

        public function simple_products (): View {
            $this -> authorize ( 'viewAllProductSimple', Product::class );
            $data[ 'title' ]         = 'All Products';
            $data[ 'products' ]      = $this -> productService -> all ();
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            $data['taxes']          = $this->taxService->all();
            $tree                    = ( new GeneralService() ) -> buildTree ( collect ( ( new CategoryService() ) -> all () ) -> toArray () );
            $options                 = ( new GeneralService() ) -> convertToOptions ( $tree, false, 0, request ( 'category-id' ) );
            $data[ 'categories' ]    = $options;
            return view ( 'products.simple', $data );
        }

        public function create (): View {
            $this -> authorize ( 'create', Product::class );
            $data[ 'title' ]         = 'Add Products (Simple)';
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            $tree                    = ( new GeneralService() ) -> buildTree ( collect ( ( new CategoryService() ) -> all () ) -> toArray () );
            $options                 = ( new GeneralService() ) -> convertToOptions ( $tree, false );
            $data[ 'categories' ]    = $options;
            $data[ 'settings' ]      = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            $data[ 'taxes' ]         = $this -> taxService -> all ();
            return view ( 'products.create', $data );
        }

        public function store ( ProductRequest $request ): RedirectResponse {
            $this -> authorize ( 'create', Product::class );
            try {
                DB ::beginTransaction ();
                $product = $this -> productService -> save ( $request );
                $this -> productService -> save_product_images ( $request, $product -> id );
                DB ::commit ();

                if ( !empty( $product ) and $product -> id > 0 )
                    return redirect () -> back () -> with ( 'message', 'Product has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function create_variable (): View {
            $this -> authorize ( 'create_variable', Product::class );
            $data[ 'title' ]         = 'Add Products (Variable)';
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            $data[ 'categories' ]    = $this -> categoryService -> all ();
            $data[ 'attributes' ]    = $this -> attributeService -> all ();
            $data[ 'settings' ]      = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'products.create-variable', $data );
        }

        public function store_variable ( ProductRequest $request ): RedirectResponse {
            $this -> authorize ( 'create_variable', Product::class );
            try {
                DB ::beginTransaction ();
                $product = $this -> productService -> save ( $request );
                $this -> productService -> save_term ( $request, $product -> id );
                $this -> productService -> save_product_images ( $request, $product -> id );
                DB ::commit ();

                $this -> productService -> link_product_to_customer_prices ( $product -> id );

                if ( !empty( $product ) and $product -> id > 0 )
                    return redirect () -> back () -> with ( 'message', 'Product has been added.' );
                else
                    return redirect () -> back () -> with ( 'error', 'Unexpected error occurred. Please contact administrator.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit ( Product $product ): View {
            $this -> authorize ( 'edit', $product );
            $data[ 'title' ]         = 'Edit Products (Simple)';
            $data[ 'product' ]       = $product;
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            $data[ 'categories' ]    = $this -> categoryService -> all ();
            $data[ 'settings' ]      = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            $data[ 'taxes' ]          = $this -> taxService -> all ();
            return view ( 'products.update', $data );
        }

        public function update ( ProductRequest $request, Product $product ): RedirectResponse {
            $this -> authorize ( 'edit', $product );
            try {
                DB ::beginTransaction ();
                $this -> productService -> edit ( $request, $product );
                $this -> productService -> save_product_images ( $request, $product -> id );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Product has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function edit_variable ( Product $product ): View {
            $this -> authorize ( 'edit_variable', $product );
            $data[ 'title' ]         = 'Edit Products (Variable)';
            $data[ 'product' ]       = $product;
            $data[ 'manufacturers' ] = $this -> manufacturerService -> all ();
            $data[ 'categories' ]    = $this -> categoryService -> all ();
            $data[ 'attributes' ]    = $this -> attributeService -> all ();
            $data[ 'settings' ]      = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'products.update-variable', $data );
        }

        public function update_variable ( ProductRequest $request, Product $product ): RedirectResponse {
            $this -> authorize ( 'edit', $product );
            try {
                DB ::beginTransaction ();
                $this -> productService -> edit ( $request, $product );
                $this -> productService -> save_product_images ( $request, $product -> id );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Product has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function destroy ( Product $product ): RedirectResponse {
            $this -> authorize ( 'delete', $product );
            $product -> delete ();

            return redirect () -> back () -> with ( 'message', 'Product has been deleted.' );
        }

        public function status ( Product $product ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                $this -> productService -> status ( $product );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Product status has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function stock ( Product $product ): View {
            $data[ 'title' ]   = 'Product Stock';
            $data[ 'product' ] = $this -> productService -> get_stock ( $product );
            return view ( 'products.stock', $data );
        }

        public function get_products_branch_wise ( Request $request ): string {
            $products = $this -> productService -> get_products_branch_wise ( $request );
            return view ( 'products.branch-wise', compact ( 'products' ) ) -> render ();
        }

        public function transfer_product ( Request $request ) {
            $product_id = $request -> input ( 'product_id' );
            if ( $product_id > 0 && is_numeric ( $product_id ) ) {
                $product           = Product ::find ( $product_id );
                $data[ 'product' ] = $product;
                return view ( 'products.transfer-product', $data ) -> render ();
            }
        }

        public function bulk_update_prices ( Product $product ): View {
            $this -> authorize ( 'bulkUpdatePrices', User::class );
            $data[ 'title' ]      = 'Bulk Price Update (Attribute Wise)';
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'products' ]   = ( new ReportingService() ) -> attribute_wise_quantity_report ();
            return view ( 'products.bulk-prices-update', $data );
        }

        public function bulk_update_prices_category_wise ( Product $product ): View {
            $this -> authorize ( 'bulkUpdatePricesCategoryWise', User::class );
            $data[ 'title' ]            = 'Bulk Price Update (Category Wise)';
            $data[ 'categories' ]       = ( new CategoryService() ) -> all ();
            $data[ 'products' ]         = ( new ReportingService() ) -> category_wise_quantity_report ();
            $data[ 'searchedCategory' ] = Category ::where ( [ 'id' => request ( 'category-id' ) ] ) -> first ();
            return view ( 'products.bulk-prices-update-category-wise', $data );
        }

        public function update_bulk_update_prices ( Request $request ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                $this -> productService -> update_bulk_update_prices ( $request );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Prices have been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function validate_sku ( Request $request ) {
            try {
                DB ::beginTransaction ();
                $products = $this -> productService -> validate_sku ( $request );
                DB ::commit ();

                echo $products > 0 ? '1' : '0';

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function validate_barcode ( Request $request ) {
            try {
                DB ::beginTransaction ();
                $products = $this -> productService -> validate_barcode ( $request );
                DB ::commit ();

                echo $products > 0 ? '1' : '0';

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function add_new_product ( Request $request ): string {
            $manufacturers = $this -> manufacturerService -> all ();
            $categories    = $this -> categoryService -> all ();
            $attributes    = $this -> attributeService -> all ();
            return view ( 'products.add-new-product', compact ( 'manufacturers', 'categories', 'attributes', 'request' ) ) -> render ();
        }

        public function add_more_stock_product ( Stock $stock ): string {
            $data[ 'stock_products' ] = $this -> productService -> active_products ();
            $data[ 'stock' ]          = $stock;
            return view ( 'products.add-more-stock-product', $data ) -> render ();
        }

        public function delete_product_image ( ProductImage $product_image ) {
            File ::delete ( $product_image -> image );
            $product_image -> delete ();
            return redirect () -> back () -> with ( 'message', 'Product image has been deleted.' );
        }

        public function variations ( Product $product ): View {
            $this -> authorize ( 'variations', Product::class );
            $data[ 'title' ]    = 'Product Variations';
            $data[ 'product' ]  = $product;
            $data[ 'products' ] = $product -> variations;
            return view ( 'products.variations', $data );
        }

        public function create_variations ( Product $product ): View {
            $this -> authorize ( 'variations', Product::class );
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'product' ]    = $product;
            return view ( 'products.add-variations', $data );
        }

        public function store_variations ( Request $request, Product $product ): RedirectResponse {
            $this -> authorize ( 'variations', Product::class );
            $attributes = collect ( $request -> input ( 'attributes' ) );
            $terms      = collect ( $request -> input ( 'terms' ) ) -> sortKeys ();

            try {
                DB ::beginTransaction ();
                $this -> productService -> store_variations ( $request, $product, $attributes );
                ( new ProductVariationService() ) -> createProductVariations ( $product, $terms );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Product variations have been created.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }

        public function quick_edit ( Product $product ): View {
            $this -> authorize ( 'edit', $product );
            $manufacturers = $this -> manufacturerService -> all ();
            $categories    = $this -> categoryService -> all ();
            $settings      = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );
            return view ( 'products.quick-edit', compact ( 'product', 'categories', 'manufacturers', 'settings' ) );
        }

        public function quick_update ( ProductRequest $request, Product $product ): RedirectResponse {
            $this -> authorize ( 'edit', $product );
            try {
                DB ::beginTransaction ();
                $this -> productService -> quick_update ( $request, $product );
                DB ::commit ();

                return redirect () -> back () -> with ( 'message', 'Product has been updated.' );

            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
    }
