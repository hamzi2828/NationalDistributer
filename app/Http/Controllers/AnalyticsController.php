<?php

    namespace App\Http\Controllers;

    use App\Http\Services\AnalyticsService;
    use Illuminate\Http\Request;
    use App\Models\Sale;

    class AnalyticsController extends Controller {

        public function open_orders_count () {
            $data = ( new AnalyticsService() ) -> orders_count ();
            return number_format ( $data, 2 );
        }

        public function get_closed_orders_count () {
            $data = ( new AnalyticsService() ) -> orders_count ( false );
            return number_format ( $data, 2 );
        }

        public function get_payable_count () {
            return ( new AnalyticsService() ) -> payable ();
        }

        public function get_receivable_count () {
            return ( new AnalyticsService() ) -> receivable ();
        }

        public function get_sales_count () {
            $data = ( new AnalyticsService() ) -> sales ();
            return number_format ( $data, 2 );
        }

        public function get_daily_sales_count () {
            return ( new AnalyticsService() ) -> daily_sales_count ();
        }

        public function get_daily_profit_count () {
            return ( new AnalyticsService() ) -> daily_profit ();
        }

        public function get_inventory_value_tp_wise () {
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles() ) ) > 0 )
                return ( new AnalyticsService() ) -> inventory_value_tp_wise ();
            else
                return number_format ( 0, 2 );
        }

        public function inventory_value_sale_wise () {
            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles() ) ) > 0 )
                return ( new AnalyticsService() ) -> inventory_value_sale_wise ();
            else
                return number_format ( 0, 2 );
        }

        public function get_revenue_report_chart () {
            $data[ 'months' ] = ( new AnalyticsService() ) -> months ();
            $data[ 'month_wise_sales' ] = ( new AnalyticsService() ) -> month_wise_sales ();
            $data[ 'expenses' ] = ( new AnalyticsService() ) -> expenses ();
            $data[ 'cash_in_hand' ] = ( new AnalyticsService() ) -> cash_in_hand ();
            return view ( 'dashboard.sales-expense-chart-js', $data );
        }

        public function get_daily_sales_chart () {
            $data[ 'daily_sales' ] = ( new AnalyticsService() ) -> daily_sales ();
            return view ( 'dashboard.daily-sales-chart-js', $data );
        }

        public function get_monthly_sales_chart () {
            $data[ 'months' ] = ( new AnalyticsService() ) -> months ();
            $data[ 'month_wise_sales' ] = ( new AnalyticsService() ) -> month_wise_sales ();
            return view ( 'dashboard.sales-chart-js', $data );
        }

        public function get_open_sales () {
            $sales = Sale::where([
                'sale_closed' => '0',
                'refunded' => '0',
                'status' => '1'
            ])->orderBy('id', 'desc')->get(['id', 'sale_id as order_no']);

            return response()->json([
                'count' => $sales->count(),
                'sales' => $sales
            ]);
        }

    }
