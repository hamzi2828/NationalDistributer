<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class CustomerProductPrice extends Model {
        use HasFactory;
        
        protected $guarded = [];
        protected $table = 'customer_product_price';
        
        public function product () {
            return $this -> belongsTo ( Product::class );
        }
    }
