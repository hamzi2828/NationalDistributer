<?php

    namespace App\Http\Controllers;

    use App\Http\Services\AccountService;
    use App\Http\Services\AnalyticsService;
    use App\Http\Services\AttributeService;
    use App\Http\Services\BranchService;
    use App\Http\Services\CategoryService;
    use App\Http\Services\StockService;

    use App\Http\Services\CustomerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\ReportingService;
    use App\Http\Services\UserService;
    use App\Http\Services\CouponService;
    use App\Http\Services\VendorService;
    use App\Models\Account;
    use App\Models\Category;
    use App\Models\User;
    use Illuminate\Contracts\View\View;
    use Illuminate\Http\Request;

    class ReportingController extends Controller {

        public function __construct () {
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * general sales report
         * --------------
         */

        public function general_sales_report ( Request $request ) {
            $this -> authorize ( 'viewGeneralSalesReport', User::class );
            $data[ 'title' ]      = 'General Sales Report';
            $data[ 'products' ]   = ( new ProductService() ) -> active_products ();
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'sales' ]      = ( new ReportingService() ) -> filter_sales ();
            $data[ 'branches' ]   = ( new BranchService() ) -> all ();
            $data[ 'users' ]      = ( new UserService() ) -> all ();
            $data[ 'customers' ]  = ( new CustomerService() ) -> all ();
            return view ( 'reporting.general-sales-report', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * general sales report
         * --------------
         */

        public function general_sales_report_attribute_wise ( Request $request ) {
            $this -> authorize ( 'viewGeneralSalesReportAttributeWise', User::class );
            $data[ 'title' ]      = 'General Sales Report (Attribute Wise)';
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'branches' ]   = ( new BranchService() ) -> all ();
            $data[ 'users' ]      = ( new UserService() ) -> all ();
            $data[ 'customers' ]  = ( new CustomerService() ) -> all ();
            $data[ 'sales' ]      = ( new ReportingService() ) -> filter_sales_attributes_wise ();
            return view ( 'reporting.general-sales-report-attributes-wise', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * general sales report
         * --------------
         */

        public function general_sales_report_product_wise ( Request $request ) {
            $this -> authorize ( 'viewGeneralSalesReportProductWise', User::class );
            $data[ 'title' ]     = 'General Sales Report (Product Wise)';
            $data[ 'products' ]  = ( new ProductService() ) -> active_products ();
            $data[ 'branches' ]  = ( new BranchService() ) -> all ();
            $data[ 'users' ]     = ( new UserService() ) -> all ();
            $data[ 'customers' ] = ( new CustomerService() ) -> all ();
            $data[ 'sales' ]     = ( new ReportingService() ) -> filter_sales_products_wise ();
            return view ( 'reporting.general-sales-report-products-wise', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * get trial balance sheet
         * --------------
         */

        public function trial_balance_sheet () {
            $this -> authorize ( 'viewTrialBalanceSheet', User::class );
            $data[ 'title' ]         = 'Trial Balance Sheet';
            $data[ 'account_heads' ] = ( new AccountService() ) -> trialBalance ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            return view ( 'reporting.trial-balance-sheet', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * get stock valuation report TP Wise
         * --------------
         */

        public function stock_valuation_tp_report () {
            $this -> authorize ( 'viewStockValuationTPReport', User::class );
            $data[ 'title' ]      = 'Stock Valuation Report (TP Wise)';
            $data[ 'branches' ]   = ( new BranchService() ) -> all ();
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'products' ]   = ( new ReportingService() ) -> stock_valuation_report ();
            $data[ 'categories' ] = ( new CategoryService() ) -> all ();
            $data[ 'vendors' ]    = collect ( ( new VendorService() ) -> all () ) -> sortBy ( 'name' );
            return view ( 'reporting.stock-valuation-tp-report', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * get stock threshold report Sale Wise
         * --------------
         */

        public function stock_valuation_sale_report () {
            $this -> authorize ( 'viewStockValuationSaleReport', User::class );
            $data[ 'title' ]      = 'Stock Valuation Report (Sale Wise)';
            $data[ 'branches' ]   = ( new BranchService() ) -> all ();
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'products' ]   = ( new ReportingService() ) -> stock_valuation_report ();
            $data[ 'categories' ] = ( new CategoryService() ) -> all ();
            $data[ 'vendors' ]    = collect ( ( new VendorService() ) -> all () ) -> sortBy ( 'name' );
            return view ( 'reporting.stock-valuation-sale-report', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * get stock threshold report
         * --------------
         */

        public function threshold_report () {
            $this -> authorize ( 'viewThresholdReport', User::class );
            $data[ 'title' ]    = 'Threshold Report';
            $data[ 'branches' ] = ( new BranchService() ) -> all ();
            $data[ 'products' ] = ( new ReportingService() ) -> stock_valuation_report ();
            return view ( 'reporting.threshold-report', $data );
        }

        /**
         * --------------
         * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * get profit report
         * --------------
         */

        public function profit_report () {
            $this -> authorize ( 'viewProfitReport', User::class );
            $data[ 'title' ]      = 'Profit Report';
            $data[ 'products' ]   = ( new ProductService() ) -> active_products ();
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'branches' ]   = ( new BranchService() ) -> all ();
            $data[ 'users' ]      = ( new UserService() ) -> all ();
            $data[ 'sales' ]      = ( new ReportingService() ) -> profit_report ();
            $data[ 'customers' ]  = ( new CustomerService() ) -> all ();
            $data[ 'categories' ] = ( new CategoryService() ) -> all ();
            return view ( 'reporting.profit-report', $data );
        }

        public function customer_receivable_report () {
            $this -> authorize ( 'customerPayableReport', User::class );
            $data[ 'title' ]         = 'Customers Receivable Report';
            $data[ 'account_heads' ] = ( new AccountService() ) -> customersTrialBalance ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            $data[ 'users' ]         = ( new UserService() ) -> all ();
            return view ( 'reporting.customer-payable-report', $data );
        }

        public function vendor_payable_report () {
            $this -> authorize ( 'vendorPayableReport', User::class );
            $data[ 'title' ]         = 'Vendors Payable Report';
            $data[ 'account_heads' ] = ( new AccountService() ) -> vendorsTrialBalance ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            return view ( 'reporting.vendor-payable-report', $data );
        }

        public function attribute_wise_quantity_report () {
            $this -> authorize ( 'attributeWiseQuantityReport', User::class );
            $data[ 'title' ]      = 'Available Stock Report (Attribute Wise)';
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'products' ]   = ( new ReportingService() ) -> attribute_wise_quantity_report ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();

            return view ( 'reporting.attribute-wise-quantity-report', $data );
        }

        public function product_sales_analysis_report (Request $request) {
            $this -> authorize ( 'productSalesAnalysisReport', User::class );
            $data[ 'title' ]    = 'Sales Analysis Report (Products)';
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
             $data[ 'sales' ]    = ( new AnalyticsService() ) -> sales_analysis_report_product_wise ();
            // dd($data['sales']);
            return view ( 'reporting.product-sales-analysis-report', $data );
        }

        public function attribute_sales_analysis_report () {
            $this -> authorize ( 'attributeSalesAnalysisReport', User::class );
            $data[ 'title' ]      = 'Sales Analysis Report (Attributes)';
            $data[ 'attributes' ] = ( new AttributeService() ) -> all ();
            $data[ 'sales' ]      = ( new AnalyticsService() ) -> sales_analysis_report_attribute_wise ();
            return view ( 'reporting.attribute-sales-analysis-report', $data );
        }

        public function profit_and_loss_report () {
            $this -> authorize ( 'profitAndLossReport', User::class );
            $data[ 'title' ]                  = 'Profit & Loss Report';
            $data[ 'sales_return' ]           = ( new ReportingService() ) -> filter_sales_return_total ();
            $data[ 'sales' ]                  = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'credit' );
            $data[ 'sales_refund' ]           = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'debit' );
            $data[ 'sale_discounts' ]         = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.discount_on_invoices' ) );
            $data[ 'direct_costs' ]           = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.direct_cost' ) );
            $data[ 'general_admin_expenses' ] = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.expenses' ) );
            $data[ 'income' ]                 = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.income' ) );
            $data[ 'taxes' ]                  = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.tax' ) );
            $data[ 'branches' ]               = ( new BranchService() ) -> all ();
            return view ( 'reporting.profit-and-loss-report', $data );
        }

        public function customer_return_report () {
            $this -> authorize ( 'customerReturnReport', User::class );
            $data[ 'title' ]     = 'Customer Return Report';
            $data[ 'customers' ] = collect ( ( new CustomerService() ) -> all () ) -> sortBy ( 'name' );
            $data[ 'stocks' ]    = ( new ReportingService() ) -> customer_returns ();
            return view ( 'reporting.customer-return-report', $data );
        }

        public function vendor_return_report () {
            $this -> authorize ( 'vendorReturnReport', User::class );
            $data[ 'title' ]   = 'Vendor Return Report';
            $data[ 'vendors' ] = collect ( ( new VendorService() ) -> all () ) -> sortBy ( 'name' );
            $data[ 'returns' ] = ( new ReportingService() ) -> vendor_returns ();
            return view ( 'reporting.vendor-return-report', $data );
        }

        public function supplier_wise_report () {
            $this -> authorize ( 'supplierWiseReport', User::class );
            $data[ 'title' ]   = 'Supplier Wise Report';
            $data[ 'vendors' ] = ( new VendorService() ) -> all ();
            $data[ 'stocks' ]  = ( new ReportingService() ) -> filter_stocks ();
            return view ( 'reporting.supplier-wise-report', $data );
        }

        public function purchase_analysis_report () {
            $this -> authorize ( 'purchaseAnalysisReport', User::class );
            $data[ 'title' ]    = 'Analysis Report (Purchase)';
            $data[ 'vendors' ]  = ( new VendorService() ) -> all ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            $data[ 'stocks' ]   = ( new ReportingService() ) -> filter_stocks ();
            return view ( 'reporting.purchase-analysis-report', $data );
        }

        public function balance_sheet (): View {
            $data[ 'title' ]              = 'Balance Sheet';
            $data[ 'current_assets' ]     = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.current_assets' ) );
            $data[ 'non_current_assets' ] = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.non_current_assets' ) );
            $data[ 'liabilities' ]        = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.liabilities' ) );
            $data[ 'capital' ]            = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.capital' ) );
            $data[ 'profit' ]             = ( new ReportingService() ) -> profit ();
            $data[ 'branches' ]           = ( new BranchService() ) -> all ();
            return view ( 'reporting.balance-sheet', $data );
        }

        public function price_list_catalog (): View {
            $data[ 'title' ]      = 'Price List Catalog';
            $data[ 'categories' ] = ( new CategoryService() ) -> all ();
            $data[ 'products' ]   = ( new ProductService() ) -> filter_products ();
            return view ( 'reporting.price-list-catalog', $data );
        }

        public function customer_ageing_report () {
            $this -> authorize ( 'customer_ageing_report', Account::class );
            $data[ 'title' ]         = 'Customer Ageing Report';
            $data[ 'account_heads' ] = ( new AccountService() ) -> customer_ageing_report ();
            $data[ 'users' ]         = ( new UserService() ) -> all ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            return view ( 'reporting.customer-ageing-report', $data );
        }

        public function vendor_ageing_report () {
            $this -> authorize ( 'vendor_ageing_report', Account::class );
            $data[ 'title' ]         = 'Vendor Ageing Report';
            $data[ 'account_heads' ] = ( new AccountService() ) -> vendor_ageing_report ();
            $data[ 'users' ]         = ( new UserService() ) -> all ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();
            return view ( 'reporting.vendor-ageing-report', $data );
        }

        public function category_wise_quantity_report () {
            $this -> authorize ( 'categoryWiseQuantityReport', User::class );
            $data[ 'title' ]            = 'Available Stock Report (Category Wise)';
            $data[ 'categories' ]       = ( new CategoryService() ) -> all ();
            $data[ 'products' ]         = ( new ReportingService() ) -> category_wise_quantity_report ();
            $data[ 'searchedCategory' ] = Category ::where ( [ 'id' => request ( 'category-id' ) ] ) -> first ();
            $data[ 'branches' ]      = ( new BranchService() ) -> all ();

            return view ( 'reporting.category-wise-quantity-report', $data );
        }



        public function high_low_sale_reports () {

            $data[ 'title' ]            = 'High Low Sale Report (online)';
            // $data[ 'products' ]         = ( new ReportingService() ) -> high_low_sale_reports ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            $data[ 'branches' ]         = ( new BranchService() ) -> all ();
            return view ( 'reporting.high-low-sale-report', $data );
        }



        public function high_low_sale_reports_pos () {

            $data[ 'title' ]            = 'High Low Sale Report (pos)';
            // $data[ 'products' ]         = ( new ReportingService() ) -> high_low_sale_reports ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            $data[ 'branches' ]         = ( new BranchService() ) -> all ();
            return view ( 'reporting.high-low-sale-report-pos', $data );
        }



        public function high_low_sale_reports_pos_vs_online  () {

            $data[ 'title' ]            = 'High Low Sale Report (pos vs online)';
            // $data[ 'products' ]         = ( new ReportingService() ) -> high_low_sale_reports ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            $data[ 'branches' ]         = ( new BranchService() ) -> all ();
            return view ( 'reporting.high-low-sale-report-pos-vs-online', $data );
        }


        public function daily_closing_summary_report  () {

            $data[ 'title' ]            = 'Daily Closing Report (Summary)';
            // $data[ 'products' ]         = ( new ReportingService() ) -> high_low_sale_reports ();
            $data[ 'products' ] = ( new ProductService() ) -> active_products ();
            $data[ 'branches' ]         = ( new BranchService() ) -> all ();
            $data[ 'users' ]         = ( new UserService() ) -> all ();
            return view ( 'reporting.daily-closing-summary-report', $data );
        }




        public function sale_analysis_report () {
            $this -> authorize ( 'saleAnalysisReport', User::class );
            $data[ 'title' ]     = 'Analysis Report (Sale)';
            $data[ 'products' ]  = ( new ProductService() ) -> active_products ();
            $data[ 'customers' ] = ( new CustomerService() ) -> all ();
            $data[ 'sales' ]     = ( new ReportingService() ) -> sale_analysis_report ();
            return view ( 'reporting.sale-analysis-report', $data );
        }

       // ReportingController.php

        public function coupon_report()
        {
            $this->authorize('couponReport', User::class);
            $data['title'] = 'Coupon Usage Report';
            $data['coupons'] = (new CouponService())->all();
            $data['coupons_report'] = (new CouponService())->coupon_report();

            // dd($data['coupons_report']);

            return view('reporting.coupon-report', $data);
        }

        public function coupon_search_report(Request $request)
        {
            $this -> authorize ( 'couponReport', User::class );

            $request->validate([
                'coupon-id' => 'nullable|exists:coupons,id',
                'start-date' => 'nullable|date',
                'end-date' => 'nullable|date|after_or_equal:start-date',
            ]);
            // Get search parameters
            $couponId = $request->input('coupon-id');
            $startDate = $request->input('start-date');
            $endDate = $request->input('end-date');

            // Fetch the coupons
            $coupons = (new CouponService())->all();

            // Fetch the filtered coupon reports
            $couponsReport = (new CouponService())->coupon_search_report($couponId, $startDate, $endDate);

            $data['title'] = 'Coupon Usage Report';
            $data['coupons'] = $coupons;
            $data['coupons_report'] = $couponsReport;


            // Return view with data
            return view('reporting.coupon-report', $data);
        }

        // public function stock_statement_report () {
        //     // dd( 'stock_statement_report' );

        //     // $this -> authorize ( 'viewStockValuationSaleReport', User::class );

        //     $data[ 'title' ]      = 'Stock Statement Report (Current Available)';
        //     $data[ 'branches' ]   = ( new BranchService() ) -> all ();

        //     // $data[ 'products' ]   = ( new ReportingService() ) -> stock_valuation_report ();
        //     $data[ 'products' ]    = ( new ProductService() ) -> all ();
        //     $data['stock']        = (new StockService())->all();
        //     $data[ 'stock_products' ]   = ( new ReportingService() ) -> stock_statement_report ();
        //     // dd($data['stock_products']);
        //     $data[ 'categories' ] = ( new CategoryService() ) -> all ();
        //     $data[ 'vendors' ]    = collect ( ( new VendorService() ) -> all () ) -> sortBy ( 'name' );
        //     return view ( 'reporting.stock-statement-report', $data );


        // }

        public function stock_statement_report () {
            $this -> authorize ( 'viewStockValuationTPReport', User::class );

            $data[ 'title' ]      = 'Stock Statement Report (Current Available)';
            $data[ 'branches' ]   = ( new BranchService() ) -> all ();
            $data[ 'products' ]   = ( new ReportingService() ) -> stock_statement_report ();

                return view ( 'reporting.stock-statement-report', $data );

        }

        public function stock_moment_report(){

            $data['title'] = 'Stock Moment Report';
            // $data[ 'products' ]   = ( new ProductService() ) -> active_products ();
            // $data[ 'products' ]   = ( new ReportingService() ) -> stock_movement_report ();
                // Get both sets of products from the ReportingService
            $productData = (new ReportingService())->stock_movement_report();

            // Separate the current and old products
            $data['products'] = $productData['current_products'];
            $data['previos_products'] = $productData['old_products'];

            // dd($data['products']);
            return view('reporting.stock-moment-report',$data);

        }


        public function stock_out_summary_report(Request $request) {

            $data[ 'title' ]      = 'Stock Out Summary Report';

             // Check if both 'filter_date' and 'customer-id' are present in the request
            if ($request->has('filter_date') && $request->has('user-id')) {
                $data['products'] = (new ProductService())->active_products();
            } else {
                $data['products'] = collect();
            }

            $data[ 'customers' ] = ( new CustomerService() ) -> all ();
            $data[ 'users' ]      = ( new UserService() ) -> all ();



            return view ( 'reporting.stock-out-summary-report', $data );
        }

    }
