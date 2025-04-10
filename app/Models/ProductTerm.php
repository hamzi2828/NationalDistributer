<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class ProductTerm extends Model {
        use HasFactory;
        use SoftDeletes;

        protected $guarded = [];
        protected $table   = 'product_terms';

        public function term () {
            return $this -> belongsTo ( Term::class );
        }

        public function product () {
            return $this -> belongsTo ( Product::class );
        }

        public function sale_products () {
            return $this -> hasMany ( SaleProducts::class, 'product_id', 'product_id' );
        }

        public function stock_products () {
            return $this -> hasMany ( ProductStock::class, 'product_id', 'product_id' );
        }

        public function stock_takes () {
            return $this -> hasMany ( StockTake::class, 'product_id', 'product_id' );
        }
    }
