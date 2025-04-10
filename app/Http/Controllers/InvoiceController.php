<?php

    namespace App\Http\Controllers;

    use App\Http\Services\AccountService;
    use App\Http\Services\AnalyticsService;
    use App\Http\Services\GeneralLedgerService;
    use App\Http\Services\ProductService;
    use App\Http\Services\ReportingService;
    use App\Http\Services\SaleService;
    use App\Http\Services\StockService;
    use App\Http\Services\StockTakeService;
    use App\Http\Services\InvoiceService;
    use App\Models\Attribute;
    use App\Models\Category;
    use App\Models\Customer;
    use App\Models\Issuance;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\Sale;
    use App\Models\Stock;
    use App\Models\StockReturn;
    use App\Models\StockTake;
    use Illuminate\Http\Request;
    use Dompdf\Dompdf;
    use Dompdf\Options;

    class InvoiceController extends Controller {

        private object $pdf;
        private object $generalLedgerService;

        public function __construct ( GeneralLedgerService $generalLedgerService ) {
            $options = new Options();
            $options -> set ( 'defaultFont', 'DejaVu Sans' );
            $options -> set ( 'isRemoteEnabled', true );
            $options -> set ( 'defaultMediaType', 'all' );
            $options -> set ( 'isFontSubsettingEnabled', true );
            $this -> pdf                  = new Dompdf ( $options );
            $this -> generalLedgerService = $generalLedgerService;
        }

        /**
         * --------------
         * @param Request $request
         * @param Sale $sale
         * @return void
         * sales invoice
         * --------------
         */

        public function sale_invoice ( Request $request, Sale $sale ) {
            $sale -> load ( [ 'customer' ] );
            $summary         = ( new SaleService() ) -> summary ( $sale -> id );
            $closing_balance = ( new AccountService() ) -> get_account_head_running_balance ( $sale -> customer -> account_head_id, $sale );
            $sales           = ( new SaleService() ) -> get_sale_by_attribute_wise ( $sale -> id );
            $simple_sales    = ( new SaleService() ) -> get_simple_sold_products ( $sale -> id );

            $this -> pdf -> loadHtml ( view ( 'invoices.sales.invoice', compact ( 'sale', 'summary', 'closing_balance', 'sales', 'simple_sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $sale -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        public function sale_invoice_html ( Request $request, Sale $sale ) {
            $sale -> load ( [ 'customer' ] );

            $summary         = ( new SaleService() ) -> summary ( $sale -> id );
            $closing_balance = ( new AccountService() ) -> get_account_head_running_balance ( $sale -> customer -> account_head_id, $sale );
            $sales           = ( new SaleService() ) -> get_sale_by_attribute_wise ( $sale -> id );
            $simple_sales    = ( new SaleService() ) -> get_simple_sold_products ( $sale -> id );

            return view ( 'invoices.sales.invoice-html', compact ( 'sale', 'summary', 'closing_balance', 'sales', 'simple_sales' ) );
        }

        public function sale_invoice_commerce ( Request $request, Sale $sale ) {
            $sale -> load ( [ 'customer' ] );
            $this -> pdf -> loadHtml ( view ( 'invoices.sales.invoice-commerce', compact ( 'sale' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );
            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $sale -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Sale $sale
         * @return void
         * sales invoice
         * --------------
         */

        public function sale_customer_invoice ( Request $request, Sale $sale ) {
            $sale -> load ( [
                                'customer',
                                'products.product'
                            ] );

            $summary         = ( new SaleService() ) -> summary ( $sale -> id );
            $simple_sales    = ( new SaleService() ) -> get_simple_sold_products ( $sale -> id );
            $closing_balance = ( new AccountService() ) -> get_account_head_running_balance ( $sale -> customer -> account_head_id, $sale );

            $this -> pdf -> loadHtml ( view ( 'invoices.sales.c-invoice', compact ( 'sale', 'summary', 'closing_balance', 'simple_sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $sale -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Stock $stock
         * @return void
         * stock invoice
         * --------------
         */

        public function stock_invoice ( Request $request, Stock $stock ) {
//            $stock -> load ( [
//                                 'products.product',
//                                 'products' => function ( $query ) {
//                                     $query -> orderBy ( 'id', 'DESC' );
//                                 },
//                                 'vendor',
//                                 'customer'
//                             ] );

            $stock -> load ( [ 'vendor', 'customer' ] );
            $attributes   = ( new StockService() ) -> get_stock_attribute_wise ( $stock );
            $simple_stock = ( new StockService() ) -> get_simple_stock ( $stock );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.invoice', compact ( 'stock', 'attributes', 'simple_stock' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock -> invoice_no . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Stock $stock
         * @return void
         * stock customer return invoice
         * --------------
         */

        public function stock_return_customer_invoice ( Request $request, Stock $stock ) {
            $stock -> load ( [
                                 'products.product',
                                 'products' => function ( $query ) {
                                     $query -> orderBy ( 'id', 'DESC' );
                                 },
                                 'vendor',
                                 'customer'
                             ] );

            $stock -> load ( [ 'vendor', 'customer' ] );
            $attributes = ( new StockService() ) -> get_stock_attribute_wise ( $stock );
            $this -> pdf -> loadHtml ( view ( 'invoices.stock.stock-customer-return-invoice', compact ( 'stock', 'attributes' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock -> invoice_no . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Stock $stock
         * @return void
         * stock customer return invoice
         * --------------
         */

        public function adjustment_decrease_invoice ( Request $request, StockReturn $stock_return ) {
            $stock_return -> load ( [
                                        'products.product',
                                        'products' => function ( $query ) {
                                            $query -> orderBy ( 'id', 'DESC' );
                                        },
                                        'vendor',
                                    ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.adjustment-decrease-invoice', compact ( 'stock_return' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock_return -> reference_no . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Stock $stock
         * @return void
         * stock customer return invoice
         * --------------
         */

        public function damage_stock_invoice ( Request $request, StockReturn $stock_return ) {
            $stock_return -> load ( [
                                        'products.product',
                                        'products' => function ( $query ) {
                                            $query -> orderBy ( 'id', 'DESC' );
                                        },
                                        'vendor',
                                    ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.damage-stock-invoice', compact ( 'stock_return' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock_return -> reference_no . '.pdf', array ( 'Attachment' => false ) );
        }

        public function stock_return ( Request $request, StockReturn $stock_return ) {
            $stock_return -> load ( [
                                        'products.product',
                                        'products' => function ( $query ) {
                                            $query -> orderBy ( 'id', 'DESC' );
                                        },
                                        'vendor',
                                    ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.stock-return-invoice', compact ( 'stock_return' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock_return -> reference_no . '.pdf', array ( 'Attachment' => false ) );
        }

        public function vendor_stock_return ( Request $request, StockReturn $stock_return ) {
            $stock_return -> load ( [
                                        'products.product',
                                        'products' => function ( $query ) {
                                            $query -> orderBy ( 'id', 'DESC' );
                                        },
                                        'vendor',
                                    ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.vendor-stock-return-invoice', compact ( 'stock_return' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock_return -> reference_no . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Issuance $issuance
         * @return void
         * stock issuance invoice
         * --------------
         */

        public function issuance_invoice ( Request $request, Issuance $issuance ) {
            $issuance -> load ( [
                                    'products.product',
                                    'issuance_from_branch',
                                    'issuance_to_branch'
                                ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.issuance', compact ( 'issuance' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $issuance -> invoice_no . '.pdf', array ( 'Attachment' => false ) );
        }

        public function p_issuance_invoice ( Request $request, Issuance $issuance ) {
            $issuance -> load ( [ 'products.product', 'issuance_from_branch', 'issuance_to_branch' ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.p-issuance', compact ( 'issuance' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $issuance -> invoice_no . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @return void
         * general ledger
         * --------------
         */

        public function general_ledger ( Request $request ) {

            $data[ 'ledgers' ]         = $this -> generalLedgerService -> filter_general_ledgers ();
            $data[ 'running_balance' ] = $this -> generalLedgerService -> get_running_balance ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.general-ledger', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'General Ledger -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @return voidluminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * general sales report
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * general sales report
         * --------------
         */

        public function general_sales_report (Request $request) {

            $data[ 'sales' ] = ( new ReportingService() ) -> filter_sales ();
            //  dd($request->all());
            $this -> pdf -> loadHtml ( view ( 'invoices.sales.general-sales-report', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'General Sales Report -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @return voidluminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * general sales report
         * @throws \Illuminate\Auth\Access\AuthorizationException
         * profit report
         * --------------
         */

        public function profit_invoice () {

            $data[ 'sales' ] = ( new ReportingService() ) -> profit_report ();

            $this -> pdf -> loadHtml ( view ( 'invoices.sales.profit-report', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a3' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Profit Report -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @return void
         * get transaction
         * --------------
         */

        public function transaction ( Request $request ) {

            $data[ 'transactions' ] = ( new ReportingService() ) -> search_transactions ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.transaction', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Transaction -' . $request -> input ( 'voucher-no' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * trial balance sheet
         * --------------
         */

        public function trial_balance () {

            $data[ 'account_heads' ] = ( new AccountService() ) -> trialBalance ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.trial-balance', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Trial Balance -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * customer payable sheet
         * --------------
         */

        public function customer_receivable () {

            $data[ 'account_heads' ] = ( new AccountService() ) -> customersTrialBalance ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.customer-paybale', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Customer Receivable -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * vendor payable sheet
         * --------------
         */

        public function vendor_payable () {

            $data[ 'account_heads' ] = ( new AccountService() ) -> vendorsTrialBalance ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.vendor-paybale', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Vendor Payable -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @param Request $request
         * @param Sale $sale
         * @return void
         * refund invoice
         * --------------
         */

        public function refund_invoice ( Request $request, Sale $sale ) {
            $sale -> load ( [ 'customer' ] );

            $summary         = ( new SaleService() ) -> summary ( $sale -> id );
            $closing_balance = ( new AccountService() ) -> get_account_head_running_balance ( $sale -> customer -> account_head_id );
            $sales           = ( new SaleService() ) -> get_sale_by_attribute_wise ( $sale -> id );
            $simple_sales    = ( new SaleService() ) -> get_simple_sold_products ( $sale -> id );

            $this -> pdf -> loadHtml ( view ( 'invoices.sales.refund-invoice', compact ( 'sale', 'summary', 'closing_balance', 'sales', 'simple_sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'refund-invoice-no-' . $sale -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * stock valuation report tp wise
         * --------------
         */

        public function stock_valuation_tp_invoice () {

            $data[ 'products' ] = ( new ReportingService() ) -> stock_valuation_report ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.stock-valuation-tp-report', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Stock Valuation Report TP Wise -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * stock valuation report sale wise
         * --------------
         */

        public function stock_valuation_sale_invoice () {

            $data[ 'products' ] = ( new ReportingService() ) -> stock_valuation_report ();

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.stock-valuation-sale-report', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Stock Valuation Report Sale Wise -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * threshold report
         * --------------
         */

        public function threshold_invoice () {

            $data[ 'products' ] = ( new ReportingService() ) -> stock_valuation_report ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.threshold-report', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Threshold Report -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * customer products rate list
         * --------------
         */

        public function customer_products_rate_list ( Customer $customer ) {

            $data[ 'customer' ]               = $customer;
            $data[ 'prices' ]                 = ( new ProductService() ) -> product_prices ( $customer -> id );
            $data[ 'simple_products_prices' ] = ( new ProductService() ) -> get_simple_added_products_prices ( $customer -> id );

            $this -> pdf -> loadHtml ( view ( 'invoices.products.customer-products-rate-list', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Customer Products Rate List -' . $customer -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * general sales report attributes wise
         * --------------
         */

        public function general_sales_report_attribute_wise () {

            $sales = ( new ReportingService() ) -> filter_sales_attributes_wise ();

            $this -> pdf -> loadHtml ( view ( 'invoices.sales.general-sales-report-attributes-wise', compact ( 'sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'General Sales Report (Attributes Wise).pdf', array ( 'Attachment' => false ) );
        }

        /**
         * --------------
         * @return void
         * general sales report product wise
         * --------------
         */

        public function general_sales_report_product_wise ( Request $request ) {
            // dd($request->all());
            $sales = ( new ReportingService() ) -> filter_sales_products_wise ();
            $this -> pdf -> loadHtml ( view ( 'invoices.sales.general-sales-report-products-wise', compact ( 'sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'General Sales Report (Products Wise).pdf', array ( 'Attachment' => false ) );
        }

        public function attribute_wise_quantity_invoice () {

            $products = ( new ReportingService() ) -> attribute_wise_quantity_report ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.attribute-wise-quantity-invoice', compact ( 'products' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Stock Report Attribute Wise.pdf', array ( 'Attachment' => false ) );
        }

        public function category_wise_quantity_invoice () {

            $products         = ( new ReportingService() ) -> category_wise_quantity_report ();
            $searchedCategory = Category ::where ( [ 'id' => request ( 'category-id' ) ] ) -> first ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.category-wise-quantity-invoice', compact ( 'products', 'searchedCategory' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Stock Report Category Wise.pdf', array ( 'Attachment' => false ) );
        }


        public function high_low_sale_reports_pos_vs_online () {
           // Get the start and end date, branch id from the request
            $startDate = request('start-date');
            $endDate = request('end-date');
            $branchId = request('branch-id', auth()->user()->branch_id);

            // Use the InvoiceService to get the report data
            $invoiceService = new InvoiceService();
            $reportData = $invoiceService->high_low_sale_report_pos_vs_online_service($startDate, $endDate, $branchId);

            // Pass data to the view for rendering the PDF
            $this->pdf->loadHtml(view('invoices.reports.high-low-sale-report-pos-vs-online-invoice', [
                'products' => $reportData['products'],
                'totalSoldQuantity' => $reportData['totalSoldQuantity'],
                'totalSaleValue' => $reportData['totalSaleValue'],
                'totalSoldQuantityPos' => $reportData['totalSoldQuantityPos'],
                'totalSaleValuePos' => $reportData['totalSaleValuePos'],
            ])->render());

            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'High Low Sale Report (Pos Vs Online).pdf', array ( 'Attachment' => false ) );
        }

        public function high_low_sale_reports_pos_invoice () {
            $startDate = request('start-date');
            $endDate = request('end-date');
            $branchId = request('branch-id', auth()->user()->branch_id);

            // Use the InvoiceService to get the POS data
            $invoiceService  = new InvoiceService();
            $reportData = $invoiceService->high_low_sale_reports_pos_service($startDate, $endDate, $branchId);

            // Pass data to the view
            $this->pdf->loadHtml(view('invoices.reports.high-low-sale-report-pos-invoice', [
                'products' => $reportData['products'],
                'totalSoldQuantity' => $reportData['totalSoldQuantity'],
                'totalSaleValue' => $reportData['totalSaleValue'],
            ])->render());


            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'High Low Sale Report (Pos).pdf', array ( 'Attachment' => false ) );
        }


        public function high_low_sale_reports_online_invoice () {
            // Get the start and end date, branch id from the request
            $startDate = request('start-date');
            $endDate = request('end-date');
            $branchId = request('branch-id', auth()->user()->branch_id); // Use branch from auth if none is selected
            // Use the HighLowSaleService to get the necessary data
            $highLowSaleService = new InvoiceService();
            $reportData = $highLowSaleService->high_low_sale_reports_online_service($startDate, $endDate, $branchId);

            // dd($reportData);
            // Pass the data to the view for rendering the PDF
            $this->pdf->loadHtml(view('invoices.reports.high-low-sale-report-online-invoice', [
                'products' => $reportData['products'],
                'totalSoldQuantity' => $reportData['totalSoldQuantity'],
                'totalSaleValue' => $reportData['totalSaleValue'],
            ])->render());

            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'High Low Sale Report (Online).pdf', array ( 'Attachment' => false ) );
        }


        public function daily_closing_summary_invoice()
        {
            // Get the start and end date, user id, and branch id from the request
            $startDate = request('start-date');
            $endDate = request('end-date');
            $userId = request('user-id');
            $branchId = request('branch-id', auth()->user()->branch_id); // Use branch from auth if none is selected

            // Use the InvoiceService to get the required data
            $invoiceService = new InvoiceService();
            $invoiceData = $invoiceService->daily_closing_summary_service($startDate, $endDate, $branchId, $userId);

            // Pass the data to the view for rendering the PDF
            $this->pdf->loadHtml(view('invoices.reports.daily-closing-summary-invoice', [
                'products' => $invoiceData['products'],
                'totalRevenue' => $invoiceData['totalRevenue'],
                'totalReturnAmount' => $invoiceData['totalReturnAmount'],
                'totalRefundedAmount' => $invoiceData['totalRefundedAmount'],
                'netSale' => $invoiceData['netSale'],
            ])->render());

             $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Daily Closing Report(Summary).pdf', array ( 'Attachment' => false ) );
        }



        public function product_sales_analysis_invoice () {

            $sales = ( new AnalyticsService() ) -> sales_analysis_report_product_wise ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.product-sales-analysis-report', compact ( 'sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Sales Analysis Report (Products).pdf', array ( 'Attachment' => false ) );
        }

        public function attribute_sales_analysis_invoice () {

            $sales = ( new AnalyticsService() ) -> sales_analysis_report_attribute_wise ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.attribute-sales-analysis-report', compact ( 'sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Sales Analysis Report (Attributes).pdf', array ( 'Attachment' => false ) );
        }

        public function customer_return_invoice () {

            $stocks = ( new ReportingService() ) -> customer_returns ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.customer-return-report', compact ( 'stocks' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Customer Return Report.pdf', array ( 'Attachment' => false ) );
        }

        public function vendor_return_invoice () {

            $stocks = ( new ReportingService() ) -> vendor_returns ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.vendor-return-report', compact ( 'stocks' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Vendor Return Report.pdf', array ( 'Attachment' => false ) );
        }

        public function supplier_wise_invoice () {

            $stocks = ( new ReportingService() ) -> filter_stocks ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.supplier-wise-invoice', compact ( 'stocks' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Supplier Wise Report.pdf', array ( 'Attachment' => false ) );
        }

        public function purchase_analysis_invoice () {

            $stocks = ( new ReportingService() ) -> filter_stocks ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.purchase-analysis-invoice', compact ( 'stocks' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Analysis Report (Purchase).pdf', array ( 'Attachment' => false ) );
        }

        public function adjustment_increase_invoice ( Stock $stock ) {

            $stock -> load ( [
                                 'products.product',
                                 'products' => function ( $query ) {
                                     $query -> orderBy ( 'id', 'DESC' );
                                 },
                                 'vendor',
                                 'customer'
                             ] );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.adjustment-increase-invoice', compact ( 'stock' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock -> invoice_no . '.pdf', array ( 'Attachment' => false ) );
        }

        public function sale_ticket ( Sale $sale ) {
            $sale -> load ( 'customer' );
            $this -> pdf -> loadHtml ( view ( 'invoices.sales.sale-ticket', compact ( 'sale' ) ) -> render () );
            $customPaper = array ( 0, 0, 386, 223 );
            $this -> pdf -> setPaper ( $customPaper );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'ticket-' . $sale -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        public function stock_take ( StockTake $stock_take ) {

            $products       = ( new StockTakeService() ) -> get_stock_take_by_uuid ( $stock_take -> uuid );
            $simpleProducts = ( new StockTakeService() ) -> get_simple_stock_take_by_uuid ( $stock_take -> uuid );

            $this -> pdf -> loadHtml ( view ( 'invoices.stock.stock-take-invoice', compact ( 'products', 'simpleProducts' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'invoice-no-' . $stock_take -> uuid . '.pdf', array ( 'Attachment' => false ) );
        }

        public function profit_and_loss_invoice () {

            $data[ 'sales_return' ]           = ( new ReportingService() ) -> filter_sales_return_total ();
            $data[ 'sales' ]                  = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'credit' );
            $data[ 'sales_refund' ]           = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.cash_sale.sales' ), 'debit' );
            $data[ 'sale_discounts' ]         = ( new ReportingService() ) -> calculate_sales_ledger ( config ( 'constants.discount_on_invoices' ) );
            $data[ 'direct_costs' ]           = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.direct_cost' ) );
            $data[ 'general_admin_expenses' ] = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.expenses' ) );
            $data[ 'income' ]                 = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.income' ) );
            $data[ 'taxes' ]                  = ( new ReportingService() ) -> get_ledgers_by_account_head ( config ( 'constants.tax' ) );

            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.profit-loss-report', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Profit & Loss Report -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        public function general_ledgers ( Request $request ) {
            $object                 = ( new AccountService() );
            $account_heads          = ( new AccountService() ) -> getRecursiveAccountHeads ( request ( 'account-head-id' ) );
            $parent_account_head    = $object -> get_account_head_by_id ( request ( 'account-head-id' ) );
            $account_head[]         = $parent_account_head;
            $data[ 'account_head' ] = $parent_account_head;
            $account_heads_list     = array_merge ( $account_head, $account_heads );
            $data[ 'ledgers' ]      = $this -> generalLedgerService -> build_ledgers_table ( $account_heads_list );
            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.general-ledgers', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'General Ledger -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        public function balance_sheet_report ( Request $request ) {
            $data[ 'current_assets' ]     = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.current_assets' ) );
            $data[ 'non_current_assets' ] = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.non_current_assets' ) );
            $data[ 'liabilities' ]        = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.liabilities' ) );
            $data[ 'capital' ]            = ( new ReportingService() ) -> filter_balance_sheet ( config ( 'constants.capital' ) );
            $data[ 'profit' ]             = ( new ReportingService() ) -> profit ();
            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.balance-sheet', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Balance Sheet -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        public function price_list_catalog (): void {
            $data[ 'products' ] = ( new ProductService() ) -> filter_products ();
            $this -> pdf -> loadHtml ( view ( 'invoices.products.price-list-catalog', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Price List Catalog -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        public function product_ticket ( Product $product ): void {
            $this -> pdf -> loadHtml ( view ( 'invoices.sales.product-ticket', compact ( 'product' ) ) -> render () );
            $customPaper = array ( 0, 0, 250, 100 );
            $this -> pdf -> setPaper ( $customPaper );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'product-' . $product -> id . '.pdf', array ( 'Attachment' => false ) );
        }

        public function customer_ageing_invoice ( Request $request ) {
            $data[ 'account_heads' ] = ( new AccountService() ) -> customer_ageing_report ();
            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.customer-ageing-invoice', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a3', 'L' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Customer Ageing Report -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        public function vendor_ageing_invoice ( Request $request ) {
            $data[ 'account_heads' ] = ( new AccountService() ) -> vendor_ageing_report ();
            $this -> pdf -> loadHtml ( view ( 'invoices.accounts.vendor-ageing-invoice', $data ) -> render () );
            $this -> pdf -> setPaper ( 'a3', 'L' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Vendor Ageing Report -' . date ( 'Y-m-d' ) . '.pdf', array ( 'Attachment' => false ) );
        }

        public function sales_analysis_invoice () {

            $sales = ( new ReportingService() ) -> sale_analysis_report ();

            $this -> pdf -> loadHtml ( view ( 'invoices.products.sales-analysis-invoice', compact ( 'sales' ) ) -> render () );
            $this -> pdf -> setPaper ( 'a4' );

            $this -> pdf -> render ();
            $this -> pdf -> stream ( 'Analysis Report (Sale).pdf', array ( 'Attachment' => false ) );
        }

    }
