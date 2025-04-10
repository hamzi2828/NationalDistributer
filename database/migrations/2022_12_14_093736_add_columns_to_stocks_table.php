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
            Schema ::table ( 'stocks', function ( Blueprint $table ) {
                $table -> foreignId ( 'customer_id' ) -> nullable () -> after ( 'vendor_id' );
                $table -> string ( 'stock_type' ) -> default ( 'vendor' ) -> after ( 'total' );
                
                $table -> foreign ( 'customer_id' ) -> references ( 'id' ) -> on ( 'customers' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'stocks', function ( Blueprint $table ) {
                $table -> dropColumn ( 'customer_id', 'type' );
            } );
        }
    };
