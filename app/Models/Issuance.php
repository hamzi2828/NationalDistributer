<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\DB;
    
    class Issuance extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        protected $table = 'issuance';
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function issuance_from_branch () {
            return $this -> belongsTo ( Branch::class, 'from_branch' );
        }
        
        public function issuance_to_branch () {
            return $this -> belongsTo ( Branch::class, 'to_branch' );
        }
        
        public function products () {
            
            return $this -> hasMany ( IssuedProducts::class ) -> select ( [
                                                                              'issuance_id',
                                                                              'product_id',
                                                                              DB ::raw ( "SUM(quantity) as quantity" ),
                                                                          ] ) -> groupBy ( 'issuance_id', 'product_id' );
            
//            return $this -> hasMany ( IssuedProducts::class );
        }
        
        public function issued_products () {
            return $this -> hasMany ( IssuedProducts::class );
        }
    }
