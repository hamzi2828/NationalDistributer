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
            Schema ::table ( 'stocks', function ( Blueprint $table ) {
                $table -> foreignId ( 'branch_id' ) -> after ( 'vendor_id' );
                $table -> foreign ( 'branch_id' ) -> on ( 'branches' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'stocks', function ( Blueprint $table ) {
                //
            } );
        }
    };
