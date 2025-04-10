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
            Schema ::create ( 'users', function ( Blueprint $table ) {
                $table -> id ();
                $table -> string ( 'name' );
                $table -> string ( 'email' ) -> unique ();
                $table -> string ( 'password' );
                $table -> string ( 'mobile' ) -> nullable ();
                $table -> string ( 'gender' );
                $table -> string ( 'identity_no' ) -> nullable ();
                $table -> date ( 'dob' ) -> nullable ();
                $table -> text ( 'address' ) -> nullable ();
                $table -> text ( 'avatar' ) -> nullable ();
                $table -> integer ( 'status' ) -> default ( '1' );
                $table -> timestamp ( 'email_verified_at' ) -> nullable ();
                $table -> rememberToken ();
                $table -> softDeletes ();
                $table -> timestamps ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'users' );
        }
    };
