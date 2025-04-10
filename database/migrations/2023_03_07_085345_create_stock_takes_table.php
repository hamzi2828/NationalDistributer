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
            Schema ::create ( 'stock_takes', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'product_id' );
                $table -> string ( 'uuid' );
                $table -> integer ( 'available_qty' );
                $table -> integer ( 'live_qty' );
                $table -> timestamps ();
            } );
        }

        /**
         * Reverse the migrations.
         * @return void
         */

        public function down () {
            Schema ::dropIfExists ( 'stock_takes' );
        }
    };
