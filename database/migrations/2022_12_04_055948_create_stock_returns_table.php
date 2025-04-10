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
            Schema ::create ( 'stock_returns', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'vendor_id' ) -> nullable ();
                $table -> float ( 'net_price' );
                $table -> string ( 'type' ) -> default ( 'vendor-return' );
                $table -> softDeletes ();
                $table -> timestamps ();

                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'vendor_id' ) -> on ( 'vendors' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }

        /**
         * Reverse the migrations.
         * @return void
         */

        public function down () {
            Schema ::dropIfExists ( 'stock_returns' );
        }
    };
