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
            Schema ::create ( 'issued_products', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'issuance_id' );
                $table -> foreignId ( 'product_id' );
                $table -> foreignId ( 'stock_id' );
                $table -> integer ( 'quantity' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'issuance_id' ) -> on ( 'issuance' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'product_id' ) -> on ( 'products' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'stock_id' ) -> on ( 'product_stock' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'issued_products' );
        }
    };
