<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\MorphOne;
    use Illuminate\Database\Eloquent\SoftDeletes;
    
    class Courier extends Model {
        use HasFactory, SoftDeletes;
        
        protected $guarded = [];
        
        
        public function general_ledger (): MorphOne {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }
        
        public function account_head (): BelongsTo {
            return $this -> belongsTo ( Account::class, 'account_head_id' );
        }
    }
