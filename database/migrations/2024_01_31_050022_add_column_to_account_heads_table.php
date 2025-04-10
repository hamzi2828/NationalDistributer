<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'account_heads', function ( Blueprint $table ) {
                $table -> integer ( 'active' ) -> default ( '1' ) -> after ( 'description' );
            } );
        }
        
        public function down () {
            Schema ::table ( 'account_heads', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'active' ] );
            } );
        }
    };
