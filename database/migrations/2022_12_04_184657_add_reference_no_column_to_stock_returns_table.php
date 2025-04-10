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
            Schema ::table ( 'stock_returns', function ( Blueprint $table ) {
                $table -> string ( 'reference_no' ) -> after ( 'vendor_id' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'stock_returns', function ( Blueprint $table ) {
                $table -> dropColumn ( 'reference_no' );
            } );
        }
    };
