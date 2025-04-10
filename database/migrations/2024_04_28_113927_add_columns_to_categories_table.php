<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'categories', function ( Blueprint $table ) {
                $table -> foreignId ( 'parent_id' ) -> nullable () -> after ( 'user_id' );
                $table -> string ( 'icon' ) -> nullable () -> after ( 'parent_id' );
                $table -> string ( 'image' ) -> nullable () -> after ( 'slug' );
                $table -> foreign ( 'parent_id' ) -> on ( 'categories' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down () {
            Schema ::table ( 'categories', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'parent_id', 'image', 'icon' ] );
            } );
        }
    };
