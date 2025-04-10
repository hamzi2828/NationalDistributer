<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Category extends Model { 
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        // protected $fillable = [ 'status']; 
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function image (): bool | string {
            return !empty( trim ( $this -> image ) ) ? asset ( $this -> image ) : asset ( '/assets/img/default-thumbnail.jpg' );
        }
        
        public function products () {
            return $this -> hasMany ( Product::class );
        }
    }
