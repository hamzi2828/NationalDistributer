<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    
    class Permission extends Model {
        use HasFactory;
        
        protected $guarded = [];
        
        public function setPermissionAttribute ( $permission ) {
            if ( isset( $permission ) && count ( $permission ) > 0 )
                $this -> attributes[ 'permission' ] = implode ( ',', $permission );
            else
                $this -> attributes[ 'permission' ] = '';
        }
        
        public function getPermissionAttribute ( $permission ) {
            return explode ( ',', $permission );
        }
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
    }
