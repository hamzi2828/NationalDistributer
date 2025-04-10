<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Attribute extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function terms () {
            return $this -> hasMany ( Term::class );
        }
    }
