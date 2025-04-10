<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class SaleProducts extends Model {
        use HasFactory;
        use SoftDeletes;

        protected $guarded = [];

        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }

        public function sale () {
            return $this -> belongsTo ( Sale::class );
        }

        public function closed_sale () {
            return $this -> belongsTo ( Sale::class ) -> where ( [ 'sale_closed' => '1' ] );
        }

        public function product () {
            return $this -> belongsTo ( Product::class );
        }

        public function product_stock () {
            return $this -> belongsTo ( ProductStock::class );
        }

        public function product_stocks () {
            return $this -> belongsTo ( ProductStock::class, 'stock_id' );
        }
    }
