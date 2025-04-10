<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'products', function ( Blueprint $table ) {
                $table -> foreignId ( 'parent_id' ) -> nullable () -> after ( 'user_id' );
                $table -> integer ( 'has_variations' ) -> nullable () -> default ( '0' ) -> after ( 'description' );
                
                $table -> foreign ( 'parent_id' ) -> on ( 'products' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down () {
            Schema ::table ( 'products', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'parent_id', 'has_variations' ] );
            } );
        }
    };
