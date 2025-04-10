<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class IssuedProducts extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function product () {
            return $this -> belongsTo ( Product::class );
        }
        
        public function product_stock () {
            return $this -> belongsTo ( ProductStock::class, 'stock_id' );
        }
    }
