<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::create ( 'financial_year', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' ) -> nullable ();
                $table -> date ( 'start_date' );
                $table -> date ( 'end_date' );
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down () {
            Schema ::dropIfExists ( 'financial_year' );
        }
    };
