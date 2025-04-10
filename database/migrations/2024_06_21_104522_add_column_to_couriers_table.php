<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'couriers', function ( Blueprint $table ) {
                $table -> string ( 'tracking_link' ) -> nullable () -> after ( 'phone' );
            } );
        }
        
        public function down () {
            Schema ::table ( 'couriers', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'tracking_link' ] );
            } );
        }
    };
