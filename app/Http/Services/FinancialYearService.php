<?php
    
    namespace App\Http\Services;
    
    use App\Models\FinancialYear;
    use Illuminate\Support\Carbon;
    
    class FinancialYearService {
        
        public function create ( $request ) {
            $carbon_start = Carbon ::createFromFormat ( 'd-m-Y', $request -> input ( 'start-date' ) );
            $carbon_end   = Carbon ::createFromFormat ( 'd-m-Y', $request -> input ( 'end-date' ) );
            $start_date   = $carbon_start -> format ( 'Y-m-d' );
            $end_date     = $carbon_end -> format ( 'Y-m-d' );
            
            return FinancialYear ::create ( [
                                                'user_id'    => auth () -> user () -> id,
                                                'start_date' => $start_date,
                                                'end_date'   => $end_date
                                            ] );
        }
        
        public function delete () {
            $financial = FinancialYear ::first ();
            return $financial ? $financial -> delete () : false;
        }
        
    }