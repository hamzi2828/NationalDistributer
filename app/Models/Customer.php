<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Notifications\Notifiable;
    
    class Customer extends Model {
        use HasFactory;
        use SoftDeletes;
        use Notifiable;
        
        protected $guarded = [];
        
        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }
        
        public function customerDetails () {
            $detail = $this -> name;
            if ( !empty( trim ( $this -> phone ) ) )
                $detail .= ' (' . $this -> phone . ')';
            return $detail;
        }
        
        public function prices () {
            return $this -> hasMany ( CustomerProductPrice::class ) -> whereIn ( 'product_id', function ( $query ) {
                $query -> select ( 'product_id' ) -> from ( 'product_stock' ) -> where ( [ 'branch_id' => auth () -> user () -> branch_id ] );
            } );
        }
        
        public function account_head () {
            return $this -> belongsTo ( Account::class, 'account_head_id' );
        }
        
        public function picture () {
            return !empty( trim ( $this -> picture ) ) ? asset ( $this -> picture ) : asset ( '/assets/img/default-thumbnail.jpg' );
        }
    }
