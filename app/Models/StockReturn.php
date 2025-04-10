<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\DB;
    
    class StockReturn extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function general_ledger () {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function ledgers () {
            return $this -> morphMany ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function vendor () {
            return $this -> belongsTo ( Vendor::class );
        }
        
        public function products () {
            return $this -> hasMany ( StockReturnProduct::class ) -> select ( [
                                                                                  'stock_return_id',
                                                                                  'product_id',
                                                                                  DB ::raw ( "SUM(quantity) as quantity" ),
                                                                                  DB ::raw ( "SUM(price) as net_price" ),
                                                                                  DB ::raw ( "SUM(tp_unit) as price" ),
                                                                                  DB ::raw ( "COUNT(product_id) as no_of_rows" ),
                                                                              ] ) -> groupBy ( 'stock_return_id', 'product_id' );
        }
    }
