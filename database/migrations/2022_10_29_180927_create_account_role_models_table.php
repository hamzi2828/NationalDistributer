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
            Schema ::create ( 'account_role_models', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'account_role_id' );
                $table -> foreignId ( 'account_head_id' );
                $table -> string ( 'type' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'account_role_id' ) -> on ( 'account_roles' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'account_head_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'account_role_models' );
        }
    };
