<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\DB;
    
    class Account extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        protected $table   = 'account_heads';
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function account_head () {
            return $this -> belongsTo ( Account::class );
        }
        
        public function account_type () {
            return $this -> belongsTo ( AccountType::class );
        }
        
        public function general_ledger () {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function trial_balance () {
            $relation = $this -> hasMany ( GeneralLedger::class, 'account_head_id' );
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = Carbon ::createFromFormat ( 'Y-m-d', request ( 'start-date' ) );
                $start_date = $start_date -> format ( 'Y-m-d' );
                $end_date   = Carbon ::createFromFormat ( 'Y-m-d', request ( 'end-date' ) );
                $end_date   = $end_date -> format ( 'Y-m-d' );
                
                $relation -> whereBetween ( DB ::raw ( 'DATE(transaction_date)' ), [
                    $start_date,
                    $end_date
                ] );
                
            }
            
            if ( request () -> filled ( 'month' ) ) {
                $month = request ( 'month' );
                $year  = date ( 'Y' );
                $relation -> where ( DB ::raw ( 'MONTH(transaction_date)' ), '=', $month );
                $relation -> where ( DB ::raw ( 'YEAR(transaction_date)' ), '=', $year );
            }
            
            if ( request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );
                $relation -> where ( 'branch_id', '=', $branch_id );
            }
            
            return $relation;
        }
        
        public function running_balance () {
            $relation = $this -> hasMany ( GeneralLedger::class, 'account_head_id' );
            
            if ( request () -> filled ( 'start-date' ) ) {
                $start_date = Carbon ::createFromFormat ( 'Y-m-d', request ( 'start-date' ) );
                $relation -> where ( 'transaction_date', '<', $start_date );
            }
            
            if ( request () -> filled ( 'month' ) ) {
                $month = request ( 'month' );
                $year  = date ( 'Y' );
                $relation -> where ( DB ::raw ( 'MONTH(transaction_date)' ), '=', $month );
                $relation -> where ( DB ::raw ( 'YEAR(transaction_date)' ), '=', $year );
            }
            
            return $relation;
        }
    }
