<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dateTime ( 'closed_at' ) -> nullable () -> after ( 'remarks' );
            } );
        }
        
        public function down () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'closed_at' ] );
            } );
        }
    };
