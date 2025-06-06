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
            Schema ::create ( 'site_settings', function ( Blueprint $table ) {
                $table -> id ();
                $table -> string ( 'slug' ) -> unique () -> index ();
                $table -> longText ( 'settings' );
                $table -> string ( 'license_key' );
                $table -> timestamps ();
            } );
        }

        /**
         * Reverse the migrations.
         * @return void
         */
        public function down () {
            Schema ::dropIfExists ( 'site_settings' );
        }
    };
