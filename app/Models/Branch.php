<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Branch extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        
        public function fullName ()
        : string {
            return $this -> code . '-' . $this -> name;
        }
        
        public function manager () {
            return $this -> belongsTo ( User::class, 'branch_manager_id' );
        }
        
        public function country () {
            return $this -> belongsTo ( Country::class );
        }
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
    }
