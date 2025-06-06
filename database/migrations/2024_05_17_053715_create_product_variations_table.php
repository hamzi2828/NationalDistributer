<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::create ( 'product_variations', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'product_id' );
                $table -> string ( 'sku' ) -> nullable ();
                $table -> float ( 'price' ) -> nullable ();
                $table -> integer ( 'stock' ) -> nullable ();
                $table -> timestamps ();
                
                $table -> foreign ( 'product_id' ) -> on ( 'products' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down () {
            Schema ::dropIfExists ( 'product_variations' );
        }
    };
