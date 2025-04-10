<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'products', function ( Blueprint $table ) {
                $table -> after ( 'image', function ( $table ) {
                    $table -> integer ( 'slider_product' ) -> default ( '0' ) -> nullable ();
                    $table -> string ( 'slider_image' ) -> nullable ();
                    $table -> integer ( 'deal_of_they_day' ) -> default ( '0' ) -> nullable ();
                    $table -> integer ( 'featured' ) -> default ( '0' ) -> nullable ();
                    $table -> integer ( 'best_seller' ) -> default ( '0' ) -> nullable ();
                    $table -> integer ( 'popular' ) -> default ( '0' ) -> nullable ();
                } );
            } );
        }
        
        public function down () {
            Schema ::table ( 'products', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'slider_product', 'slider_image', 'deal_of_they_day', 'featured', 'best_seller', 'popular' ] );
            } );
        }
    };
