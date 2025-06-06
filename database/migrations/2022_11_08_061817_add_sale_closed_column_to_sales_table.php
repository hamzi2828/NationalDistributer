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
                $table -> integer ( 'sale_closed' ) -> after ( 'customer_type' ) -> default ( '0' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                //
            } );
        }
    };
