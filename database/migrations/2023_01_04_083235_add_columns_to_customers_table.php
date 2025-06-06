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
            Schema ::table ( 'customers', function ( Blueprint $table ) {
                $table -> string ( 'license' ) -> nullable () -> after ( 'mobile' );
                $table -> string ( 'phone' ) -> nullable () -> after ( 'license' );
                $table -> string ( 'representative' ) -> nullable () -> after ( 'phone' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::table ( 'customers', function ( Blueprint $table ) {
                $table -> dropColumn ( [
                                           'license',
                                           'phone',
                                           'representative'
                                       ] );
            } );
        }
    };
