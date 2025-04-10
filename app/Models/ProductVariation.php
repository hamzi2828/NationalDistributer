<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    
    class ProductVariation extends Model {
        use HasFactory;
        
        protected $guarded = [];
        
        public function terms (): BelongsToMany {
            return $this -> belongsToMany ( Term::class, 'product_variation_terms' );
        }
    }
