<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class GeneralLedger extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function account_head () {
            return $this -> belongsTo ( Account::class, 'account_head_id' );
        }
        
        public function scopeFilter ( $query ) {
            if ( request () -> filled ( 'account-head-id' ) ) {
                $query -> where ( 'account_head_id', request () -> input ( 'account-head-id' ) );
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request () -> input ( 'end-date' ) ) );
                
                $query -> whereBetween ( 'transaction_date', [
                    $start_date,
                    $end_date
                ] );
            }
        }
        
        public function scopeRunningBalance ( $query ) {
            if ( request () -> filled ( 'account-head-id' ) ) {
                $query -> where ( 'account_head_id', request () -> input ( 'account-head-id' ) );
            }
            
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request () -> input ( 'start-date' ) ) );
                
                $query -> where ( 'transaction_date', '<', $start_date );
            }
        }
        
        public function transaction_details () {
            return $this -> hasMany ( GeneralLedgerTransactionDetails::class, 'general_ledger_id' );
        }
    }
