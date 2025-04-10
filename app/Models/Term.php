<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Term extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function attribute () {
            return $this -> belongsTo ( Attribute::class );
        }
        
        public function product_terms () {
            return $this -> hasMany ( ProductTerm::class );
        }
        
    }
