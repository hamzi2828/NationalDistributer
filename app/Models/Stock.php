<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Stock extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function scopeByBranch ( $query ) {
            $query -> where ( [ 'branch_id' => auth () -> user () -> branch_id ] );
        }
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function products () {
            return $this -> hasMany ( ProductStock::class );
        }
        
        public function vendor () {
            return $this -> belongsTo ( Vendor::class );
        }
        
        public function branch () {
            return $this -> belongsTo ( Branch::class );
        }
        
        public function customer () {
            return $this -> belongsTo ( Customer::class );
        }
        
        public function general_ledger () {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function ledgers () {
            return $this -> morphMany ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function sold_quantity () {
            return $this -> hasMany ( SaleProducts::class ) -> whereIn ( 'sale_id', function ( $query ) {
                $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'sale_closed' => '1',
                                                                             'refunded'    => '0',
                                                                             'user_id'     => auth () -> user () -> id
                                                                         ] );
            } ) -> sum ( 'quantity' );
        }
    }
