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
            Schema ::create ( 'stocks', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'vendor_id' ) -> nullable ();
                $table -> string ( 'invoice_no' ) -> unique ();
                $table -> string ( 'type' ) -> default ( 'product' );
                $table -> date ( 'stock_date' );
                $table -> float ( 'discount', 20 );
                $table -> float ( 'total', 20 );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnDelete ();
                $table -> foreign ( 'vendor_id' ) -> on ( 'vendors' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'product_stock' );
        }
    };
