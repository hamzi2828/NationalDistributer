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
            Schema ::create ( 'branches', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'branch_manager_id' );
                $table -> foreignId ( 'country_id' );
                $table -> string ( 'code' );
                $table -> string ( 'name' );
                $table -> string ( 'landline' );
                $table -> string ( 'mobile' );
                $table -> text ( 'address' );
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'branch_manager_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'country_id' ) -> on ( 'countries' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'branches' );
        }
    };
