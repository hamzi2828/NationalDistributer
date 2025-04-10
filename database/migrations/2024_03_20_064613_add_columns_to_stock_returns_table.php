<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'stock_returns', function ( Blueprint $table ) {
                $table -> float ( 'discount' ) -> nullable () -> after ( 'net_price' );
                $table -> float ( 'price' ) -> nullable () -> after ( 'discount' );
            } );
        }
        
        public function down () {
            Schema ::table ( 'stock_returns', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'discount', 'price' ] );
            } );
        }
    };
