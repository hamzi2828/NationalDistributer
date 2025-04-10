<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;
    use Illuminate\Support\Facades\DB;

    class Sale extends Model {
        use HasFactory;
        use SoftDeletes;

        protected $guarded = [];

        public function logs () {
            return $this -> morphMany ( Log::class, 'logable' );
        }



        public function customer () {
            return $this -> belongsTo ( Customer::class );
        }

        public function sold_products () {
            return $this -> hasMany ( SaleProducts::class );
        }

        public function products () {
            return $this -> hasMany ( SaleProducts::class ) -> select ( [
                                                                            'sale_id',
                                                                            'product_id',
                                                                            DB ::raw ( "SUM(quantity) as quantity" ),
                                                                            DB ::raw ( "SUM(price) as price" ),
                                                                            DB ::raw ( "SUM(net_price) as net_price" ),
                                                                            DB ::raw ( "COUNT(product_id) as no_of_rows" ),
                                                                            DB ::raw ( "GROUP_CONCAT(stock_id) as stocks" ),
                                                                        ] ) -> groupBy ( 'sale_id', 'product_id' );
        }

        public function sold_quantity () {
            return $this -> hasMany ( SaleProducts::class ) -> sum ( 'quantity' );
        }

        public function general_ledger () {
            return $this -> morphOne ( GeneralLedger::class, 'ledgerable' );
        }

        public function user () {
            return $this -> belongsTo ( User::class );
        }
    }
