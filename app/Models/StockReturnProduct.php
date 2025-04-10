<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class StockReturnProduct extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        protected $table = 'stock_return_products';
        
        public function product () {
            return $this -> belongsTo ( Product::class );
        }
    }
