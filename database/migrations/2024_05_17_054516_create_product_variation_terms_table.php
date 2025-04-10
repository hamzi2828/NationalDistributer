<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::create ( 'product_variation_terms', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'product_variation_id' );
                $table -> foreignId ( 'term_id' );
                $table -> timestamps ();
                
                $table -> foreign ( 'product_variation_id' ) -> on ( 'product_variations' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
                $table -> foreign ( 'term_id' ) -> on ( 'terms' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down () {
            Schema ::dropIfExists ( 'product_variation_terms' );
        }
    };
