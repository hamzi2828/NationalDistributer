<?php
    
    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;
    
    return new class extends Migration {
        
        public function up () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> foreignId ( 'coupon_id' ) -> nullable () -> after ( 'courier_id' );
                $table -> foreign ( 'coupon_id' ) -> references ( 'id' ) -> on ( 'coupons' ) -> cascadeOnDelete () -> cascadeOnUpdate ();
            } );
        }
        
        public function down () {
            Schema ::table ( 'sales', function ( Blueprint $table ) {
                $table -> dropColumn ( [ 'coupon_id' ] );
            } );
        }
    };
