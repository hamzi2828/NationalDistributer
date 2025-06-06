<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::create ( 'coupons', function ( Blueprint $table ) {
                $table -> id ();
                $table -> string ( 'title' );
                $table -> string ( 'code' ) -> unique ();
                $table -> float ( 'discount' );
                $table -> date ( 'start_date' ) -> nullable ();
                $table -> date ( 'end_date' ) -> nullable ();
                $table -> text ( 'description' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
            } );
        }
        
        public function down () {
            Schema ::dropIfExists ( 'coupons' );
        }
    };
