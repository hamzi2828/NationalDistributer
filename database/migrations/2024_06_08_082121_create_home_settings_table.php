<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::create ( 'home_settings', function ( Blueprint $table ) {
                $table -> id ();
                $table -> string ( 'banner_1' ) -> nullable ();
                $table -> string ( 'banner_2' ) -> nullable ();
                $table -> string ( 'banner_3' ) -> nullable ();
                $table -> string ( 'banner_4' ) -> nullable ();
                $table -> timestamps ();
            } );
        }
        
        public function down () {
            Schema ::dropIfExists ( 'home_settings' );
        }
    };
