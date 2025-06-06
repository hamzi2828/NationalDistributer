<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class StockTake extends Model {
        use HasFactory;

        protected $guarded = [];

        public function getRouteKeyName () {
            return 'uuid';
        }

        public function product () {
            return $this -> belongsTo ( Product::class );
        }
    }
