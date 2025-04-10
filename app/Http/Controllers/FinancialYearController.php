<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Services\FinancialYearService;
    use App\Models\FinancialYear;
    use Illuminate\Contracts\View\View;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    
    class FinancialYearController extends Controller {
        
        public function index () {
            //
        }
        
        public function create (): View {
            $title          = 'Financial Year';
            $financial_year = FinancialYear ::first ();
            return view ( 'account-settings.financial-year.create', compact ( 'title', 'financial_year' ) );
        }
        
        public function store ( Request $request ): RedirectResponse {
            try {
                DB ::beginTransaction ();
                ( new FinancialYearService() ) -> delete ();
                ( new FinancialYearService() ) -> create ( $request );
                DB ::commit ();
                return redirect ( route ( 'financial-year.create' ) ) -> with ( 'message', 'Financial Year has been saved.' );
            }
            catch ( QueryException | \Exception $exception ) {
                DB ::rollBack ();
                Log ::error ( $exception );
                return redirect () -> back () -> with ( 'error', $exception -> getMessage () ) -> withInput ();
            }
        }
        
        public function edit ( $id ) {
            //
        }
        
        public function update ( Request $request, $id ) {
            //
        }
        
        public function destroy ( $id ) {
            //
        }
    }
