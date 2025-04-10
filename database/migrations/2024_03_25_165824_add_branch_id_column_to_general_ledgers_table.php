<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $table -> foreignId ( 'branch_id' ) -> nullable () -> after ( 'user_id' );
                $table -> foreign ( 'branch_id' ) -> on ( 'branches' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down () {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'branch_id' ] );
            } );
        }
    };
