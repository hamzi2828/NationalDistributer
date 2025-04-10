<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> string ( 'tracking_no' ) -> nullable () -> after ( 'boxes' );
            } );
        }
        
        public function down () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'tracking_no' ] );
            } );
        }
    };
