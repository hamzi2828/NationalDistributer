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
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> integer ( 'refunded' ) -> default ( 0 ) -> after ( 'sale_closed' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dropColumn ( 'refunded' );
            } );
        }
    };
