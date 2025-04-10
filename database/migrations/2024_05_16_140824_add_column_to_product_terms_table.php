<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up (): void {
            Schema ::table ( 'product_terms', function ( Blueprint $table ) {
                $table -> foreignId ( 'attribute_id' ) -> nullable () -> after ( 'product_id' );
                $table -> foreign ( 'attribute_id' ) -> on ( 'attributes' ) -> references ( 'id' ) -> cascadeOnUpdate () -> cascadeOnDelete ();
            } );
        }
        
        public function down (): void {
            Schema ::table ( 'product_terms', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'attribute_id' ] );
            } );
        }
    };
