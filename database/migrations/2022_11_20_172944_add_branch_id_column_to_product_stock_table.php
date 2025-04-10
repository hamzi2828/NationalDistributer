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
                $table -> foreignId ( 'branch_id' ) -> after ( 'stock_id' );
                $table -> foreign ( 'branch_id' ) -> on ( 'branches' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'product_stock', function ( Blueprint $table ) {
                $table -> dropColumn ( 'branch_id' );
            } );
        }
    };
