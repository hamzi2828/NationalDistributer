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
            Schema ::table ( 'issuance', function ( Blueprint $table ) {
                $table -> integer ( 'received' ) -> after ( 'to_branch' ) -> default ( '0' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'issuance', function ( Blueprint $table ) {
                $table -> dropColumn ( 'received' );
            } );
        }
    };
