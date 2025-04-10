<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class AccountRoleModels extends Model {
        use HasFactory;
        use SoftDeletes;
        
        protected $guarded = [];
        protected $table = 'account_role_models';
        
        public function account_head () {
            return $this -> belongsTo ( Account::class, 'account_head_id' );
        }
    }
