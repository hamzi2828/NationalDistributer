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
            Schema ::create ( 'logs', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' ) -> nullable ();
                $table -> morphs ( 'logable' );
                $table -> longText ( 'action' );
                $table -> longText ( 'log' );
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'logs' );
        }
    };
