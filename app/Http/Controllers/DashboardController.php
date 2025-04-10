<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\AnalyticsService;
    use App\Http\Services\ReportingService;
    use Illuminate\Http\Request;
    
    class DashboardController extends Controller {
        
        public function index () {
            $data[ 'title' ]                  = 'Dashboard';
            $data[ 'top_selling' ]            = ( new AnalyticsService() ) -> top_selling_products ();
            $data[ 'top_selling_attributes' ] = ( new ReportingService() ) -> filter_sales_attributes_wise ( 10 );
            return view ( 'dashboard.index', $data );
        }
        
        public function home () {
            $data[ 'title' ] = 'Home';
            return view ( 'dashboard.home', $data );
        }
        
    }
