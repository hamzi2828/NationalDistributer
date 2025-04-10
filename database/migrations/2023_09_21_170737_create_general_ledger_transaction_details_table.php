<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        public function up () {
            Schema ::create ( 'general_ledger_transaction_details', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'general_ledger_id' );
                $table -> foreignId ( 'customer_id' ) -> nullable ();
                $table -> foreignId ( 'sale_id' ) -> nullable ();
                $table -> foreignId ( 'vendor_id' ) -> nullable ();
                $table -> foreignId ( 'stock_id' ) -> nullable ();
                $table -> string ( 'voucher' ) -> nullable ();
                $table -> timestamps ();
                
                $table -> foreign ( 'general_ledger_id' ) -> on ( 'general_ledgers' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'customer_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'sale_id' ) -> on ( 'sales' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'vendor_id' ) -> on ( 'account_heads' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'stock_id' ) -> on ( 'stocks' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down () {
            Schema ::dropIfExists ( 'general_ledger_transaction_details' );
        }
    };
