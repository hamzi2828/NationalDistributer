<?php

    use App\Http\Controllers\AccountController;
    use App\Http\Controllers\AccountRoleController;
    use App\Http\Controllers\AccountTypeController;
    use App\Http\Controllers\AdjustmentController;
    use App\Http\Controllers\AnalyticsController;
    use App\Http\Controllers\AttributeController;
    use App\Http\Controllers\BranchController;
    use App\Http\Controllers\CategoryController;
    use App\Http\Controllers\CountryController;
    use App\Http\Controllers\CouponController;
    use App\Http\Controllers\CourierController;
    use App\Http\Controllers\CustomerController;
    use App\Http\Controllers\DashboardController;
    use App\Http\Controllers\FinancialYearController;
    use App\Http\Controllers\HomeSettingController;
    use App\Http\Controllers\InvoiceController;
    use App\Http\Controllers\IssuanceController;
    use App\Http\Controllers\LicenseController;
    use App\Http\Controllers\LoginController;
    use App\Http\Controllers\ManufacturerController;
    use App\Http\Controllers\PageController;
    use App\Http\Controllers\ProductController;
    use App\Http\Controllers\ProductUserReviewController;
    use App\Http\Controllers\ReportingController;
    use App\Http\Controllers\RoleController;
    use App\Http\Controllers\SaleController;
    use App\Http\Controllers\SiteSettingsController;
    use App\Http\Controllers\StockController;
    use App\Http\Controllers\StockReturnController;
    use App\Http\Controllers\StockTakeController;
    use App\Http\Controllers\TermController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\VendorController;
    use App\Http\Controllers\TaxController;
    use Illuminate\Support\Facades\Route;


    Route ::middleware ( [ 'guest', 'license', 'throttle:10' ] ) -> group ( function () {

        Route ::get ( '/', [
            LoginController::class,
            'login'
        ] ) -> name ( 'login' );

        Route ::post ( '/', [
            LoginController::class,
            'authenticate'
        ] ) -> name ( 'authenticate.user' );

        Route ::get ( '/product-verification', [
            LicenseController::class,
            'product_verification'
        ] ) -> name ( 'product-verification' ) -> withoutMiddleware ( [ 'guest', 'license' ] );

        Route ::post ( '/verify-product', [
            LicenseController::class,
            'verify_product'
        ] ) -> name ( 'verify-product' ) -> withoutMiddleware ( [ 'guest', 'license' ] );

    } );

    Route ::middleware ( [ 'auth', 'license' ] ) -> group ( function () {
        Route ::get ( '/home', [
            DashboardController::class,
            'home'
        ] ) -> name ( 'home' );

        Route ::get ( '/dashboard', [
            DashboardController::class,
            'index'
        ] ) -> name ( 'dashboard' );

        Route ::get ( '/analytics/open_orders_count', [
            AnalyticsController::class,
            'open_orders_count'
        ] );

        Route ::get ( '/analytics/get_closed_orders_count', [
            AnalyticsController::class,
            'get_closed_orders_count'
        ] );

        Route ::get ( '/analytics/get_payable_count', [
            AnalyticsController::class,
            'get_payable_count'
        ] );

        Route ::get ( '/analytics/get_receivable_count', [
            AnalyticsController::class,
            'get_receivable_count'
        ] );

        Route ::get ( '/analytics/get_sales_count', [
            AnalyticsController::class,
            'get_sales_count'
        ] );

        Route ::get ( '/analytics/get_daily_sales_count', [
            AnalyticsController::class,
            'get_daily_sales_count'
        ] );

        Route ::get ( '/analytics/get_daily_profit_count', [
            AnalyticsController::class,
            'get_daily_profit_count'
        ] );

        Route ::get ( '/analytics/get_inventory_value_tp_wise', [
            AnalyticsController::class,
            'get_inventory_value_tp_wise'
        ] );

        Route ::get ( '/analytics/inventory_value_sale_wise', [
            AnalyticsController::class,
            'inventory_value_sale_wise'
        ] );

        Route ::get ( '/analytics/get_revenue_report_chart', [
            AnalyticsController::class,
            'get_revenue_report_chart'
        ] );

        Route ::get ( '/analytics/get_daily_sales_chart', [
            AnalyticsController::class,
            'get_daily_sales_chart'
        ] );

        Route ::get ( '/analytics/get_monthly_sales_chart', [
            AnalyticsController::class,
            'get_monthly_sales_chart'
        ] );

        Route ::get ( '/analytics/get_open_sales', [
            AnalyticsController::class,
            'get_open_sales'
        ] );

        Route ::get ( '/logout', [
            LoginController::class,
            'logout'
        ] ) -> name ( 'logout' );

        Route ::get ( 'users/theme', [
            UserController::class,
            'theme'
        ] );

        // Route ::get ( 'users/{user}/status', [
        //     UserController::class,
        //     'status'
        // ] ) -> name ( 'users.status' );
        Route::patch('/users/{user}/status', [UserController::class, 'status'])->name('users.status');



    Route::patch('/categories/{category}/status', [CategoryController::class, 'updateStatus'])->name('category.status');



        Route ::resource ( 'users', UserController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'settings' ) -> group ( function () {
            Route ::resource ( 'countries', CountryController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'taxes', TaxController::class ) -> except ( [ 'show' ] );


            Route ::get ( 'taxes/apply', [
                TaxController::class,
                'apply'
            ] ) -> name ( 'taxes.apply' );

            Route ::post ( 'taxes/applyOnProduct', [
                TaxController::class,
                'applyOnProduct'
            ] ) -> name ( 'taxes.applyonproduct' );

            Route ::resource ( 'branches', BranchController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'categories', CategoryController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'pages', PageController::class ) -> except ( [ 'show' ] );
            Route ::get ( '/fetch-attribute-terms', [
                AttributeController::class,
                'fetch_attribute_terms'
            ] );
            Route ::resource ( 'attributes', AttributeController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'terms', TermController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'manufacturers', ManufacturerController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'site-settings', SiteSettingsController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'home-settings', HomeSettingController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'couriers', CourierController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'coupons', CouponController::class ) -> except ( [ 'show' ] );
        } );
        Route ::get('/home-settings/newsletter_email', [HomeSettingController::class, 'newsletter_email'])->name('home-settings.newsletter_email');

        Route::patch('/coupons/{coupon}/status', [CouponController::class, 'updateStatus'])->name('coupons.status');



        Route ::get ( 'products/create/variable', [
            ProductController::class,
            'create_variable'
        ] ) -> name ( 'products.create.variable' );

        Route ::post ( 'products/store/variable', [
            ProductController::class,
            'store_variable'
        ] ) -> name ( 'products.store.variable' );

        Route ::get ( 'products/edit/{product}/variable', [
            ProductController::class,
            'edit_variable'
        ] ) -> name ( 'products.edit.variable' );

        Route ::put ( 'products/update/{product}/variable', [
            ProductController::class,
            'update_variable'
        ] ) -> name ( 'products.update.variable' );

        Route ::get ( 'products/{product}/status', [
            ProductController::class,
            'status'
        ] ) -> name ( 'products.status' );

        Route ::get ( 'products/{product}/stock', [
            ProductController::class,
            'stock'
        ] ) -> name ( 'products.stock' );

        Route ::get ( 'get-products-branch-wise', [
            ProductController::class,
            'get_products_branch_wise'
        ] ) -> name ( 'products.get-products-branch-wise' );

        Route ::get ( 'bulk-update-prices', [
            ProductController::class,
            'bulk_update_prices'
        ] ) -> name ( 'products.bulk-update-prices' );

        Route ::get ( 'bulk-update-prices-category-wise', [
            ProductController::class,
            'bulk_update_prices_category_wise'
        ] ) -> name ( 'products.bulk-update-prices-category-wise' );

        Route ::post ( 'bulk-update-prices', [
            ProductController::class,
            'update_bulk_update_prices'
        ] ) -> name ( 'products.update-bulk-update-prices' );

        Route ::get ( '/transfer-product', [
            ProductController::class,
            'transfer_product'
        ] ) -> name ( 'sales.transfer-product' );

        Route ::get ( '/simple-products', [
            ProductController::class,
            'simple_products'
        ] ) -> name ( 'products.simple-products' );

        Route ::get ( '/validate-sku', [
            ProductController::class,
            'validate_sku'
        ] ) -> name ( 'products.validate-sku' );

        Route ::get ( '/validate-barcode', [
            ProductController::class,
            'validate_barcode'
        ] ) -> name ( 'products.validate-barcode' );

        Route ::get ( '/add-new-product', [
            ProductController::class,
            'add_new_product'
        ] ) -> name ( 'products.add-new-product' );

        Route ::get ( '/add-more-stock-product/{stock}', [
            ProductController::class,
            'add_more_stock_product'
        ] ) -> name ( 'products.add-more-stock-product' );

        Route ::get ( 'products/delete-product-image/{product_image}', [
            ProductController::class,
            'delete_product_image'
        ] ) -> name ( 'products.delete-product-image' );

        Route ::get ( 'products/{product}/variations', [
            ProductController::class,
            'variations'
        ] ) -> name ( 'products.variations' );

        Route ::get ( 'products/{product}/variations/create', [
            ProductController::class,
            'create_variations'
        ] ) -> name ( 'products.variations.create' );

        Route ::post ( 'products/{product}/variations/create', [
            ProductController::class,
            'store_variations'
        ] ) -> name ( 'products.variations.store' );

        Route ::get ( 'products/{product}/quick-edit', [
            ProductController::class,
            'quick_edit'
        ] ) -> name ( 'products.quick-edit' );

        Route ::put ( 'products/{product}/quick-edit', [
            ProductController::class,
            'quick_update'
        ] ) -> name ( 'products.quick-update' );

        Route ::resource ( 'products', ProductController::class ) -> except ( [ 'show' ] );

        Route ::group ( [ 'prefix' => 'products' ], function () {
            Route ::resource ( 'reviews', ProductUserReviewController::class );
        } );
        Route ::get ( 'reviews/report', [ProductUserReviewController::class, 'reviews_report'])->name('reviews.report');
        Route::post('edit-reviews/{id}', [ProductUserReviewController::class, 'edit_review'])->name('edit-reviews');
        Route ::get ('/review-search-report', [ProductUserReviewController::class, 'review_search_report'])->name('review-search-report');



        Route ::get ( 'stock-takes/create-category', [
            StockTakeController::class,
            'create_category_wise'
        ] ) -> name ( 'stock-takes.create-category' );
        Route ::resource ( 'stock-takes', StockTakeController::class ) -> except ( [ 'show' ] );

        Route ::group ( [ 'prefix' => 'adjustments', 'as' => 'adjustments.' ], function () {
            Route ::get ( 'decrease', [ AdjustmentController::class, 'decrease' ] ) -> name ( 'decrease' );
            Route ::get ( 'add-decrease', [ AdjustmentController::class, 'add_decrease' ] ) -> name ( 'add-decrease' );
            Route ::post ( 'add-decrease', [ AdjustmentController::class, 'store_adjustment_decrease' ] ) -> name ( 'store-adjustment-decrease' );
            Route ::get ( 'edit-adjustment-decrease/{stock_return}', [ AdjustmentController::class, 'edit_decrease' ] ) -> name ( 'edit-adjustment-decrease' );
            Route ::put ( 'edit-adjustment-decrease/{stock_return}', [ AdjustmentController::class, 'update_adjustment_decrease' ] ) -> name ( 'update-adjustment-decrease' );
            Route ::delete ( 'delete-adjustment-decrease/{stock_return}', [ AdjustmentController::class, 'delete_adjustment_decrease' ] ) -> name ( 'delete-adjustment-decrease' );

            Route ::get ( 'damage-stocks', [ AdjustmentController::class, 'damage_stocks' ] ) -> name ( 'damage-stocks' );
            Route ::get ( 'add-damage-stocks', [ AdjustmentController::class, 'add_damage_stocks' ] ) -> name ( 'add-damage-stocks' );
            Route ::post ( 'store-damage-stocks', [ AdjustmentController::class, 'store_damage_stocks' ] ) -> name ( 'store-damage-stocks' );
            Route ::get ( 'edit-damage-stocks/{stock_return}', [ AdjustmentController::class, 'edit_damage_stocks' ] ) -> name ( 'edit-damage-stocks' );
            Route ::put ( 'edit-damage-stocks/{stock_return}', [ AdjustmentController::class, 'update_damage_stocks' ] ) -> name ( 'update-damage-stocks' );
            Route ::delete ( 'delete-damage-stocks/{stock_return}', [ AdjustmentController::class, 'delete_damage_stocks' ] ) -> name ( 'delete-damage-stocks' );
            Route ::get ( 'add-stock-increase-products', [
                AdjustmentController::class,
                'add_stock_increase_products'
            ] ) -> name ( 'add-stock-increase-products' );
        } );

        Route ::resource ( 'adjustments', AdjustmentController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'user-management' ) -> group ( function () {
            Route ::resource ( 'roles', RoleController::class ) -> except ( [ 'show' ] );
        } );

        Route ::get ( '/vendors/{vendor}/status', [
            VendorController::class,
            'status'
        ] ) -> name ( 'vendors.status' );
        Route ::resource ( 'vendors', VendorController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'products' ) -> group ( function () {

            Route ::get ( 'stocks/customers', [
                StockController::class,
                'customers'
            ] ) -> name ( 'stocks.customers' );

            Route ::get ( 'stocks/add-customer', [
                StockController::class,
                'add_customer'
            ] ) -> name ( 'stocks.add-customer' );

            Route ::post ( 'stocks/add-customer', [
                StockController::class,
                'return_customer_stock'
            ] ) -> name ( 'stocks.return-customer-stock' );

            Route ::get ( 'stocks/check-stock', [
                StockController::class,
                'check_stock'
            ] ) -> name ( 'stocks.check-stock' );

            Route ::post ( 'stocks/add-more-products/{stock}', [
                StockController::class,
                'add_more_products'
            ] ) -> name ( 'stocks.add-more-products' );

            Route ::get ( 'stocks/add-stock-products', [
                StockController::class,
                'add_stock_products'
            ] ) -> name ( 'stocks.add-stock-products' );

            Route ::get ( 'stocks/add-customer-return-stock-products', [
                StockController::class,
                'add_customer_return_stock_products'
            ] ) -> name ( 'stocks.add-customer-return-stock-products' );

            Route ::resource ( 'stocks', StockController::class ) -> except ( [ 'show' ] );

            Route ::get ( '/stock/product/{product_stock}/delete', [
                StockController::class,
                'delete_stock_product'
            ] ) -> name ( 'stock.product.delete' );

            Route ::resource ( 'stock-returns', StockReturnController::class ) -> except ( [ 'show' ] );
        } );

        Route ::get ( '/add-product-for-return', [
            StockReturnController::class,
            'add_product_for_return'
        ] );

        Route ::get ( '/validate-invoice-no', [
            StockController::class,
            'validate_invoice_no'
        ] ) -> name ( 'validate-invoice-no' );

        Route ::prefix ( 'account-settings' ) -> group ( function () {
            Route ::resource ( 'account-types', AccountTypeController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'account-roles', AccountRoleController::class ) -> except ( [ 'show' ] );
            Route ::resource ( 'financial-year', FinancialYearController::class ) -> except ( [ 'show' ] );
        } );

        Route ::get ( 'chat-of-accounts', [
            AccountController::class,
            'chat_of_accounts'
        ] ) -> name ( 'accounts.chat-of-accounts' );

        Route ::get ( 'general-ledger', [
            AccountController::class,
            'general_ledger'
        ] ) -> name ( 'accounts.general-ledger' );

        Route ::get ( 'add-transactions', [
            AccountController::class,
            'add_transactions'
        ] ) -> name ( 'accounts.add-transactions' );

        Route ::post ( 'add-transactions', [
            AccountController::class,
            'process_add_transactions'
        ] ) -> name ( 'accounts.process-add-transactions' );

        Route ::get ( 'add-transactions-quick', [
            AccountController::class,
            'add_transactions_quick'
        ] ) -> name ( 'accounts.add-transactions-quick' );

        Route ::post ( 'add-transactions-quick', [
            AccountController::class,
            'process_add_transactions_quick'
        ] ) -> name ( 'accounts.process-add-transactions-quick' );

        Route ::get ( 'add-transactions-quick-pay', [
            AccountController::class,
            'add_transactions_quick_pay'
        ] ) -> name ( 'accounts.add-transactions-quick-pay' );

        Route ::post ( 'add-transactions-quick-pay', [
            AccountController::class,
            'process_add_transactions_quick_pay'
        ] ) -> name ( 'accounts.process-add-transactions-quick-pay' );

        Route ::get ( 'add-transactions-quick-expense', [
            AccountController::class,
            'add_transactions_quick_expense'
        ] ) -> name ( 'accounts.add-transactions-quick-expense' );

        Route ::post ( 'add-transactions-quick-expense', [
            AccountController::class,
            'process_add_transactions_quick_expense'
        ] ) -> name ( 'accounts.process-add-transactions-quick-expense' );

        Route ::get ( 'get-account-head-type', [
            AccountController::class,
            'get_account_head_type'
        ] ) -> name ( 'accounts.get-account-head-type' );

        Route ::get ( 'add-opening-balance', [
            AccountController::class,
            'add_opening_balance'
        ] ) -> name ( 'accounts.add-opening-balance' );

        Route ::post ( 'add-opening-balance', [
            AccountController::class,
            'process_add_opening_balance'
        ] ) -> name ( 'accounts.process-add-opening-balance' );

        Route ::get ( 'add-multiple-transactions', [
            AccountController::class,
            'add_multiple_transactions'
        ] ) -> name ( 'accounts.add-multiple-transactions' );

        Route ::get ( 'add-more-transactions', [
            AccountController::class,
            'add_more_transactions'
        ] ) -> name ( 'accounts.add-more-transactions' );

        Route ::post ( 'process-add-multiple-transactions', [
            AccountController::class,
            'process_add_multiple_transactions'
        ] ) -> name ( 'accounts.process-add-multiple-transactions' );

        Route ::get ( 'search-transactions', [
            AccountController::class,
            'search_transactions'
        ] ) -> name ( 'accounts.search-transactions' );

        Route ::post ( 'search-transactions', [
            AccountController::class,
            'update_transactions'
        ] ) -> name ( 'accounts.update-transactions' );

        Route ::get ( '/accounts/delete-transactions', [
            AccountController::class,
            'delete_transactions'
        ] ) -> name ( 'accounts.delete-transactions' );

        Route ::get ( '/accounts/account-heads-dropdown', [
            AccountController::class,
            'account_heads_dropdown'
        ] ) -> name ( 'accounts.account-heads-dropdown' );

        Route ::get ( '/accounts/transaction-detail-dropdown', [
            AccountController::class,
            'transaction_detail_dropdown'
        ] ) -> name ( 'accounts.transaction-detail-dropdown' );

        Route ::get ( '/accounts/transaction-detail/{general_ledger}', [
            AccountController::class,
            'transaction_detail'
        ] ) -> name ( 'accounts.transaction-detail' );

        Route ::post ( '/accounts/transaction-detail/{general_ledger}', [
            AccountController::class,
            'update_transaction_detail'
        ] ) -> name ( 'accounts.update-transaction-details' );

        Route ::get ( '/accounts/general-ledgers', [
            AccountController::class,
            'general_ledgers'
        ] ) -> name ( 'accounts.general-ledgers' );

        Route ::get ( 'add-transactions-complex-jv', [ AccountController::class, 'add_transactions_complex_jv' ] ) -> name ( 'accounts.add-transactions-complex-jv' );
        Route ::get ( 'add-more-transactions-complex-jv', [ AccountController::class, 'add_more_transactions_complex_jv' ] ) -> name ( 'accounts.add-more-transactions-complex-jv' );
        Route ::get ( 'status/{account}', [ AccountController::class, 'status' ] ) -> name ( 'accounts.status' );
        Route ::get ( 'get-account-head-type-id', [ AccountController::class, 'get_account_head_type_id' ] ) -> name ( 'accounts.get-account-head-type-id' );
        Route ::get ( 'get-account-head-running-balance', [ AccountController::class, 'get_account_head_running_balance' ] ) -> name ( 'accounts.get-account-head-running-balance' );
        Route ::get ( 'get-banks', [ AccountController::class, 'get_banks' ] ) -> name ( 'accounts.get-banks' );
        Route ::resource ( 'accounts', AccountController::class ) -> except ( [ 'show' ] );

        Route ::get ( '/add-product', [
            CustomerController::class,
            'add_product'
        ] ) -> name ( 'customers.add-product' );

        Route ::get ( '/get-customer-products', [
            CustomerController::class,
            'get_customer_products'
        ] ) -> name ( 'customers.get-customer-products' );

        Route ::get ( '/get-attributes', [
            AttributeController::class,
            'get_attributes'
        ] );

        Route ::get ( '/get-products-by-attributes', [
            AttributeController::class,
            'get_products_by_attributes'
        ] );

        Route ::get ( '/sale-products-by-attributes', [
            SaleController::class,
            'sale_products_by_attributes'
        ] );

        Route ::get ( '/customers/{customer}/status', [
            CustomerController::class,
            'status'
        ] ) -> name ( 'customers.status' );

        Route ::resource ( 'customers', CustomerController::class ) -> except ( [ 'show' ] );

        Route ::get ( '/add-product-for-sale', [
            SaleController::class,
            'add_product_for_sale'
        ] ) -> name ( 'sales.add-product-for-sale' );

        Route ::get ( '/add-tax-to-product', [
            TaxController::class,
            'add_tax_to_product'
        ] ) -> name ( 'add-tax-to-product');


        Route ::get ( '/add-product-for-quick-sale', [
            SaleController::class,
            'add_product_for_quick_sale'
        ] ) -> name ( 'sales.add-product-for-quick-sale' );

        Route ::get ( '/get-stock-available-quantity', [
            StockController::class,
            'get_stock_available_quantity'
        ] ) -> name ( 'stocks.get-stock-available-quantity' );

        Route ::get ( '/get-price-by-sale-quantity', [
            SaleController::class,
            'get_price_by_sale_quantity'
        ] ) -> name ( 'sales.get-price-by-sale-quantity' );

        Route ::get ( '/get-price', [
            StockReturnController::class,
            'get_price'
        ] );

        Route ::get ( '/close-sale/{sale}', [
            SaleController::class,
            'close_sale'
        ] ) -> name ( 'sales.close-sale' );

        Route ::get ( '/sale/{sale}/status', [
            SaleController::class,
            'status'
        ] ) -> name ( 'sales.status' );

        Route ::get ( '/refund-sale/{sale}', [
            SaleController::class,
            'refund_sale'
        ] ) -> name ( 'sales.refund-sale' );

        Route ::get ( '/sales/create/attribute', [
            SaleController::class,
            'sale_by_attribute'
        ] ) -> name ( 'sales.create.attribute' );

        Route ::get ( '/sales/{sale}/edit_2', [
            SaleController::class,
            'edit_2'
        ] );

        Route ::get ( '/sales/{sale}/tracking', [
            SaleController::class,
            'tracking'
        ] ) -> name ( 'sales.tracking' );

        Route ::put ( '/sales/{sale}/add-tracking', [
            SaleController::class,
            'add_tracking'
        ] ) -> name ( 'sales.add-tracking' );

        Route ::get ( '/sales/quick', [
            SaleController::class,
            'quick_sale'
        ] ) -> name ( 'quick-sale' );

        Route ::resource ( 'sales', SaleController::class ) -> except ( [ 'show' ] );

        Route ::get ( '/received/{issuance}', [
            IssuanceController::class,
            'received'
        ] ) -> name ( 'issuance.received' );

        Route ::resource ( 'issuance', IssuanceController::class ) -> except ( [ 'show' ] );

        Route ::prefix ( 'invoice' ) -> group ( function () {
            Route ::get ( '/sale/invoice/{sale}', [
                InvoiceController::class,
                'sale_invoice'
            ] ) -> name ( 'sales.invoice' );

            Route ::get ( '/sale/invoice-html/{sale}', [
                InvoiceController::class,
                'sale_invoice_html'
            ] ) -> name ( 'sales.invoice-html' );

            Route ::get ( '/sale/invoice-commerce/{sale}', [
                InvoiceController::class,
                'sale_invoice_commerce'
            ] ) -> name ( 'sales.invoice-commerce' );

            Route ::get ( '/sale/c-invoice/{sale}', [
                InvoiceController::class,
                'sale_customer_invoice'
            ] ) -> name ( 'sales.c-invoice' );

            Route ::get ( '/refund/invoice/{sale}', [
                InvoiceController::class,
                'refund_invoice'
            ] ) -> name ( 'refund.invoice' );

            Route ::get ( '/stock/invoice/{stock}', [
                InvoiceController::class,
                'stock_invoice'
            ] ) -> name ( 'stock.invoice' );

            Route ::get ( '/stock/return-customer-invoice/{stock}', [
                InvoiceController::class,
                'stock_return_customer_invoice'
            ] ) -> name ( 'stock.return-customer-invoice' );

            Route ::get ( '/stock/issuance/{issuance}', [
                InvoiceController::class,
                'issuance_invoice'
            ] ) -> name ( 'issuance.invoice' );

            Route ::get ( '/stock/p-issuance/{issuance}', [
                InvoiceController::class,
                'p_issuance_invoice'
            ] ) -> name ( 'issuance.p-invoice' );

            Route ::get ( '/accounts/general-ledger', [
                InvoiceController::class,
                'general_ledger'
            ] ) -> name ( 'accounts.ledger' );

            Route ::get ( '/general-sales-report', [
                InvoiceController::class,
                'general_sales_report'
            ] ) -> name ( 'general-sales-invoice' );

            Route ::get ( '/transaction', [
                InvoiceController::class,
                'transaction'
            ] ) -> name ( 'transaction' );

            Route ::get ( '/trial-balance', [
                InvoiceController::class,
                'trial_balance'
            ] ) -> name ( 'trial-balance' );

            Route ::get ( '/customer-receivable', [
                InvoiceController::class,
                'customer_receivable'
            ] ) -> name ( 'customer-receivable' );

            Route ::get ( '/vendor-payable', [
                InvoiceController::class,
                'vendor_payable'
            ] ) -> name ( 'vendor-payable' );

            Route ::get ( '/stock-return/{stock_return}', [
                InvoiceController::class,
                'stock_return'
            ] ) -> name ( 'stock-return.invoice' );

            Route ::get ( '/vendor-stock-return/{stock_return}', [
                InvoiceController::class,
                'vendor_stock_return'
            ] ) -> name ( 'vendor-stock-return.invoice' );

            Route ::get ( '/adjustment-decrease-invoice/{stock_return}', [
                InvoiceController::class,
                'adjustment_decrease_invoice'
            ] ) -> name ( 'adjustment-decrease-invoice' );

            Route ::get ( '/damage-stock-invoice/{stock_return}', [
                InvoiceController::class,
                'damage_stock_invoice'
            ] ) -> name ( 'damage-stock-invoice' );

            Route ::get ( '/stock-valuation-tp-invoice', [
                InvoiceController::class,
                'stock_valuation_tp_invoice'
            ] ) -> name ( 'stock-valuation-tp-invoice' );

            Route ::get ( '/stock-valuation-sale-invoice', [
                InvoiceController::class,
                'stock_valuation_sale_invoice'
            ] ) -> name ( 'stock-valuation-sale-invoice' );

            Route ::get ( '/threshold-invoice', [
                InvoiceController::class,
                'threshold_invoice'
            ] ) -> name ( 'threshold-invoice' );

            Route ::get ( '/profit-invoice', [
                InvoiceController::class,
                'profit_invoice'
            ] ) -> name ( 'profit-invoice' );

            Route ::get ( '/customer-products-rate-list/{customer}', [
                InvoiceController::class,
                'customer_products_rate_list'
            ] ) -> name ( 'customer-products-rate-list' );

            Route ::get ( '/general-sales-invoice-attributes-wise/', [
                InvoiceController::class,
                'general_sales_report_attribute_wise'
            ] ) -> name ( 'general-sales-invoice-attributes-wise' );

            Route ::get ( '/general-sales-invoice-product-wise/', [
                InvoiceController::class,
                'general_sales_report_product_wise'
            ] ) -> name ( 'general-sales-invoice-product-wise' );

            Route ::get ( '/attribute-wise-quantity-invoice', [
                InvoiceController::class,
                'attribute_wise_quantity_invoice'
            ] ) -> name ( 'attribute-wise-quantity-invoice' );

            Route ::get ( '/category-wise-quantity-invoice', [
                InvoiceController::class,
                'category_wise_quantity_invoice'
            ] ) -> name ( 'category-wise-quantity-invoice' );


            Route ::get ( '/high-low-sale-report-pos-invoice', [
                InvoiceController::class,
                'high_low_sale_reports_pos_invoice'
            ] ) -> name ( 'high-low-sale-report-pos-invoice' );



            Route ::get ( '/high-low-sale-report-online-invoice', [
                InvoiceController::class,
                'high_low_sale_reports_online_invoice'
            ] ) -> name ( 'high-low-sale-report-online-invoice' );


            Route ::get ( '/daily-closing-summary-invoice', [
                InvoiceController::class,
                'daily_closing_summary_invoice'
            ] ) -> name ( 'daily-closing-summary-invoice' );




            Route ::get ( '/high-low-sale-report-pos-vs-online-invoice', [
                InvoiceController::class,
                'high_low_sale_reports_pos_vs_online'
            ] ) -> name ( 'high-low-sale-report-pos-vs-online-invoice' );


            Route ::get ( '/product-sales-analysis-invoice', [
                InvoiceController::class,
                'product_sales_analysis_invoice'
            ] ) -> name ( 'product-sales-analysis-invoice' );

            Route ::get ( '/attribute-sales-analysis-invoice', [
                InvoiceController::class,
                'attribute_sales_analysis_invoice'
            ] ) -> name ( 'attribute-sales-analysis-invoice' );

            Route ::get ( '/profit-and-loss-invoice', [
                InvoiceController::class,
                'profit_and_loss_invoice'
            ] ) -> name ( 'profit-and-loss-invoice' );

            Route ::get ( '/customer-return-invoice', [
                InvoiceController::class,
                'customer_return_invoice'
            ] ) -> name ( 'customer-return-invoice' );

            Route ::get ( '/vendor-return-invoice', [
                InvoiceController::class,
                'vendor_return_invoice'
            ] ) -> name ( 'vendor-return-invoice' );

            Route ::get ( '/supplier-wise-invoice', [
                InvoiceController::class,
                'supplier_wise_invoice'
            ] ) -> name ( 'supplier-wise-invoice' );

            Route ::get ( '/purchase-analysis-invoice', [
                InvoiceController::class,
                'purchase_analysis_invoice'
            ] ) -> name ( 'purchase-analysis-invoice' );

            Route ::get ( '/sales-analysis-invoice', [
                InvoiceController::class,
                'sales_analysis_invoice'
            ] ) -> name ( 'sales-analysis-invoice' );

            Route ::get ( '/adjustment-increase-invoice/{stock}', [
                InvoiceController::class,
                'adjustment_increase_invoice'
            ] ) -> name ( 'adjustment-increase-invoice' );

            Route ::get ( '/sale/{sale}/ticket', [
                InvoiceController::class,
                'sale_ticket'
            ] ) -> name ( 'sales.ticket' );

            Route ::get ( '/stock-take/{stock_take}', [
                InvoiceController::class,
                'stock_take'
            ] ) -> name ( 'stock-take' );

            Route ::get ( '/general-ledgers', [
                InvoiceController::class,
                'general_ledgers'
            ] ) -> name ( 'general-ledgers' );

            Route ::get ( '/balance-sheet-report', [
                InvoiceController::class,
                'balance_sheet_report'
            ] ) -> name ( 'balance-sheet-report' );

            Route ::get ( '/price-list-catalog-report', [
                InvoiceController::class,
                'price_list_catalog'
            ] ) -> name ( 'price-list-catalog-report' );

            Route ::get ( '/product-ticket/{product}', [
                InvoiceController::class,
                'product_ticket'
            ] ) -> name ( 'product-ticket' );

            Route ::get ( 'customer-ageing-invoice', [
                InvoiceController::class,
                'customer_ageing_invoice'
            ] ) -> name ( 'customer-ageing-invoice' );

            Route ::get ( 'vendor-ageing-invoice', [
                InvoiceController::class,
                'vendor_ageing_invoice'
            ] ) -> name ( 'vendor-ageing-invoice' );
        } );

        Route ::prefix ( 'reporting' ) -> group ( function () {
            Route ::get ( '/general-sales-report', [
                ReportingController::class,
                'general_sales_report'
            ] ) -> name ( 'general-sales-report' );

            Route ::get ( '/general-sales-report-attribute-wise', [
                ReportingController::class,
                'general_sales_report_attribute_wise'
            ] ) -> name ( 'general-sales-report-attribute-wise' );

            Route ::get ( '/trial-balance-sheet', [
                ReportingController::class,
                'trial_balance_sheet'
            ] ) -> name ( 'trial-balance-sheet' );

            Route ::get ( '/stock-valuation-tp-report', [
                ReportingController::class,
                'stock_valuation_tp_report'
            ] ) -> name ( 'stock-valuation-tp-report' );

            Route ::get ( '/stock-valuation-sale-report', [
                ReportingController::class,
                'stock_valuation_sale_report'
            ] ) -> name ( 'stock-valuation-sale-report' );


            Route ::get ( '/stock-statement-report', [
                ReportingController::class,
                'stock_statement_report'
            ] ) -> name ( 'stock-statement-report' );



            Route ::get ( '/threshold-report', [
                ReportingController::class,
                'threshold_report'
            ] ) -> name ( 'threshold-report' );

            Route ::get ( '/general-sales-report-product-wise', [
                ReportingController::class,
                'general_sales_report_product_wise'
            ] ) -> name ( 'general-sales-report-product-wise' );

            Route ::get ( '/customer-receivable-report', [
                ReportingController::class,
                'customer_receivable_report'
            ] ) -> name ( 'customer-receivable-report' );

            Route ::get ( '/vendor-payable-report', [
                ReportingController::class,
                'vendor_payable_report'
            ] ) -> name ( 'vendor-payable-report' );

            Route ::get ( '/attribute-wise-quantity-report', [
                ReportingController::class,
                'attribute_wise_quantity_report'
            ] ) -> name ( 'attribute-wise-quantity-report' );

            Route ::get ( '/category-wise-quantity-report', [
                ReportingController::class,
                'category_wise_quantity_report'
            ] ) -> name ( 'category-wise-quantity-report' );


            Route ::get ( '/high-low-sale-reports', [
                ReportingController::class,
                'high_low_sale_reports'
            ] ) -> name ( 'high-low-sale-report' );

            Route ::get ( '/high-low-sale-reports-pos', [
                ReportingController::class,
                'high_low_sale_reports_pos'
            ] ) -> name ( 'high-low-sale-report-pos' );


            Route ::get ( '/high-low-sale-reports-pos-vs-online', [
                ReportingController::class,
                'high_low_sale_reports_pos_vs_online'
            ] ) -> name ( 'high-low-sale-report-pos-vs-online' );


            Route ::get ( '/daily-closing-summary-report', [
                ReportingController::class,
                'daily_closing_summary_report'
            ] ) -> name ( 'daily-closing-summary-report' );






            Route ::get ( '/product-sales-analysis-report', [
                ReportingController::class,
                'product_sales_analysis_report'
            ] ) -> name ( 'product-sales-analysis-report' );

            Route ::get ( '/attribute-sales-analysis-report', [
                ReportingController::class,
                'attribute_sales_analysis_report'
            ] ) -> name ( 'attribute-sales-analysis-report' );

            Route ::get ( '/profit-and-loss-report', [
                ReportingController::class,
                'profit_and_loss_report'
            ] ) -> name ( 'profit-and-loss-report' );

            Route ::get ( '/customer-return-report', [
                ReportingController::class,
                'customer_return_report'
            ] ) -> name ( 'customer-return-report' );

            Route ::get ( '/vendor-return-report', [
                ReportingController::class,
                'vendor_return_report'
            ] ) -> name ( 'vendor-return-report' );

            Route ::get ( '/supplier-wise-report', [
                ReportingController::class,
                'supplier_wise_report'
            ] ) -> name ( 'supplier-wise-report' );

            Route ::get ( '/purchase-analysis-report', [
                ReportingController::class,
                'purchase_analysis_report'
            ] ) -> name ( 'purchase-analysis-report' );

            Route ::get ( '/sale-analysis-report', [
                ReportingController::class,
                'sale_analysis_report'
            ] ) -> name ( 'sale-analysis-report' );

            Route ::get ( '/profit-report', [
                ReportingController::class,
                'profit_report'
            ] ) -> name ( 'profit-report' );

            Route ::get ( '/balance-sheet', [
                ReportingController::class,
                'balance_sheet'
            ] ) -> name ( 'balance-sheet' );

            Route ::get ( '/customer-ageing-report', [
                ReportingController::class,
                'customer_ageing_report'
            ] ) -> name ( 'customer-ageing-report' );

            Route ::get ( '/price-list-catalog', [
                ReportingController::class,
                'price_list_catalog'
            ] ) -> name ( 'price-list-catalog' );

            Route ::get ( '/vendor-ageing-report', [
                ReportingController::class,
                'vendor_ageing_report'
            ] ) -> name ( 'vendor-ageing-report' );

            Route ::get ( '/stock-moment-report', [
                ReportingController::class,
                'stock_moment_report'
            ] ) -> name ( 'stock-moment-report' );

            Route ::get ( '/stock-out-summary-report', [
                ReportingController::class,
                'stock_out_summary_report'
            ] ) -> name ( 'stock-out-summary-report' );


            Route ::get ('/coupon-report', [ReportingController::class, 'coupon_report'])->name('coupon-genral-report');
            Route ::get ('/coupon-search-report', [ReportingController::class, 'coupon_search_report'])->name('coupon-search-report');

        } );
    } );
