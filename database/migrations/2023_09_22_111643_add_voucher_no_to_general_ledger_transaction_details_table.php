<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'general_ledger_transaction_details', function ( Blueprint $table ) {
                $table -> string ( 'voucher_no' ) -> after ( 'voucher' ) -> nullable ();
            } );
        }
        
        public function down () {
            Schema ::table ( 'general_ledger_transaction_details', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'voucher_no' ] );
            } );
        }
    };
