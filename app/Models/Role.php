<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Role extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function permission () {
            return $this -> hasOne ( Permission::class );
        }
    
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
    }
