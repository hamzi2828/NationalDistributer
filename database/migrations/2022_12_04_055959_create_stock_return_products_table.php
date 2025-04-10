<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        /**
         * Run the migrations.
         * @return void
         */
        
        public function up () {
            Schema ::create ( 'stock_return_products', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'stock_return_id' );
                $table -> foreignId ( 'stock_id' );
                $table -> foreignId ( 'product_id' );
                $table -> integer ( 'quantity' );
                $table -> float ( 'tp_unit' );
                $table -> float ( 'price' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'stock_return_id' ) -> on ( 'stock_returns' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'stock_id' ) -> on ( 'product_stock' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'product_id' ) -> on ( 'products' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'stock_return_products' );
        }
    };
