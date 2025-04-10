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
                $table -> string ( 'payment_mode' ) -> default ( 'cash' ) -> nullable () -> after ( 'transaction_date' );
                $table -> string ( 'voucher_no' ) -> nullable () -> after ( 'payment_mode' );
                $table -> text ( 'description' ) -> nullable ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        public function down () {
            Schema ::table ( 'general_ledgers', function ( Blueprint $table ) {
                $table -> dropColumn ( 'payment_mode' );
                $table -> dropColumn ( 'voucher_no' );
                $table -> dropColumn ( 'description' );
            } );
        }
    };
