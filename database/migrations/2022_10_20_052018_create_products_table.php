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
            Schema ::create ( 'products', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'user_id' );
                $table -> foreignId ( 'manufacturer_id' );
                $table -> foreignId ( 'category_id' );
                $table -> string ( 'title' );
                $table -> string ( 'slug' );
                $table -> string ( 'sku' );
                $table -> integer ( 'threshold' ) -> default ( 0 );
                $table -> float ( 'tp_box' ) -> default ( 0 );
                $table -> float ( 'pack_size' ) -> default ( 0 );
                $table -> float ( 'tp_unit' ) -> default ( 0 );
                $table -> float ( 'sale_box' ) -> default ( 0 );
                $table -> float ( 'sale_unit' ) -> default ( 0 );
                $table -> string ( 'product_type' ) -> default ( 'simple' );
                $table -> string ( 'image' ) -> nullable ();
                $table -> softDeletes ();
                $table -> timestamps ();
                
                $table -> foreign ( 'user_id' ) -> on ( 'users' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'manufacturer_id' ) -> on ( 'manufacturers' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
                $table -> foreign ( 'category_id' ) -> on ( 'categories' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'products' );
        }
    };
