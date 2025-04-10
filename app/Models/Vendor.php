<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class Vendor extends Model {
        use HasFactory;
        use SoftDeletes;

        protected $guarded = [];

        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }

        public function account_role () {
            return $this -> belongsTo ( AccountRole::class );
        }

        public function account_head () {
            return $this -> belongsTo ( Account::class, 'account_head_id' );
        }
        
        public function picture () {
            return !empty( trim ( $this -> picture ) ) ? asset ( $this -> picture ) : asset ( '/assets/img/default-thumbnail.jpg' );
        }
    }
