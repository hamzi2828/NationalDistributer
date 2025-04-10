<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> foreignId ( 'courier_id' ) -> nullable () -> after ( 'customer_id' );
                $table -> foreign ( 'courier_id' ) -> on ( 'couriers' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'courier_id' ] );
            } );
        }
    };
