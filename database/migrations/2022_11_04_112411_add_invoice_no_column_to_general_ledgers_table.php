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
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $column = Schema ::hasColumn ( 'general_ledgers', 'invoice_no' );
                
                if ( !$column )
                    $table -> string ( 'invoice_no' ) -> nullable () -> after ( 'account_head_id' );
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        public function down () {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                //
            } );
        }
    };
