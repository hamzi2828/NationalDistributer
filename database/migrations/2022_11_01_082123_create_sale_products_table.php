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
            Schema ::create ( 'sale_products', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'sale_id' );
                $table -> foreignId ( 'product_id' );
                $table -> foreignId ( 'stock_id' );
                $table -> integer ( 'quantity' );
                $table -> float ( 'price', 20 );
                $table -> float ( 'net_price', 20 );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'sale_id' ) -> on ( 'sales' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'product_id' ) -> on ( 'products' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'stock_id' ) -> on ( 'product_stock' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'sale_products' );
        }
    };
