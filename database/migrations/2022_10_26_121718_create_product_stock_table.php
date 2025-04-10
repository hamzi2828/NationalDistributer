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
            Schema ::create ( 'product_stock', function ( Blueprint $table ) {
                $table -> id ();
                $table -> foreignId ( 'product_id' );
                $table -> foreignId ( 'stock_id' );
                $table -> string ( 'batch_no' );
                $table -> date ( 'expiry_date' );
                $table -> integer ( 'box_qty' ) -> default ( '0' );
                $table -> integer ( 'pack_size' ) -> default ( '0' );
                $table -> integer ( 'quantity' ) -> default ( '0' );
                $table -> float ( 'tp_box', 20 ) -> default ( '0' );
                $table -> float ( 'stock_price', 20 ) -> default ( '0' );
                $table -> float ( 'discount', 20 ) -> default ( '0' );
                $table -> float ( 'sale_tax', 20 ) -> default ( '0' );
                $table -> float ( 'net_price', 20 ) -> default ( '0' );
                $table -> float ( 'cost_box', 20 ) -> default ( '0' );
                $table -> float ( 'tp_unit', 20 ) -> default ( '0' );
                $table -> float ( 'sale_box', 20 ) -> default ( '0' );
                $table -> float ( 'sale_unit', 20 ) -> default ( '0' );
                $table -> softDeletes ();
                $table -> timestamps ();
    
                $table -> foreign ( 'product_id' ) -> on ( 'products' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnDelete ();
                $table -> foreign ( 'stock_id' ) -> on ( 'stocks' ) -> references ( 'id' ) -> cascadeOnDelete () -> cascadeOnDelete ();
            } );
        }
        
        /**
         * Reverse the migrations.
         * @return void
         */
        
        public function down () {
            Schema ::dropIfExists ( 'product_stock' );
        }
    };
