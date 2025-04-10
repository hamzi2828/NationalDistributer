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
            Schema ::create ( 'sales', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'customer_id' );
                $table -> float ( 'total', 20 ) -> default ( '0' );
                $table -> float ( 'flat_discount' ) -> default ( '0' );
                $table -> float ( 'percentage_discount' ) -> default ( '0' );
                $table -> float ( 'net', 20 ) -> default ( '0' );
                $table -> float ( 'amount_added', 20 ) -> default ( '0' );
                $table -> string ( 'customer_type', 20 ) -> default ( 'cash' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'customer_id' ) -> on ( 'customers' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'sales' );
        }
    };
