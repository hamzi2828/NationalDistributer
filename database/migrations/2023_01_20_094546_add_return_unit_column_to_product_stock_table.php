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
            Schema ::table ( 'product_stock', function ( Blueprint $table ) {
                $table -> float ( 'return_unit' ) -> default ( '0' ) -> after ( 'sale_unit' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'product_stock', function ( Blueprint $table ) {
                $table -> dropColumn ( 'return_unit' );
            } );
        }
    };
