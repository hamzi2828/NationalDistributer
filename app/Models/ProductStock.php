<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\SoftDeletes;

    class ProductStock extends Model {
        use HasFactory;
        use SoftDeletes;

        protected $guarded = [];
        protected $table   = 'product_stock';

        public function product () {
            return $this -> belongsTo ( Product::class );
        } 

        public function stock () {
            return $this -> belongsTo ( Stock::class );
        }

        public function available_quantity ( $query ) {
            return ( $query -> quantity - $this -> sold_quantity () );
        }

        public function available () {
            $quantity = $this -> quantity;
            $sold = $this -> sold_quantity ();
            $issued = $this -> issued_quantity ();
            $returned = $this -> returned_quantity ();
            $adjustment_decrease = $this -> adjustment_decrease ();
            $damage_loss = $this -> damage_loss ();
            return ( $quantity - $sold - $issued - $returned - $adjustment_decrease - $damage_loss );
        }

        public function damage_loss () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );

                return $this -> hasMany ( StockReturnProduct::class, 'stock_id' ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [ 'type' => 'damage-loss-stock' ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                    } );
                } ) -> sum ( 'quantity' );
            }

            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( StockReturnProduct::class, 'stock_id' ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [
                                                                                     'type'       => 'damage-loss-stock',
                                                                                     'deleted_at' => null
                                                                                 ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }

        public function sold_quantity () {
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( SaleProducts::class, 'stock_id' ) -> whereIn ( 'sale_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'sale_closed' => '1',
                                                                             'refunded'    => '0',
                                                                             'deleted_at'  => null
                                                                         ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }

        public function refund_quantity () {
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( SaleProducts::class, 'stock_id' ) -> whereIn ( 'sale_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'sales' ) -> where ( [
                                                                             'refunded'   => '1',
                                                                             'deleted_at' => null
                                                                         ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }

        public function issued_quantity () {
            return $this -> hasMany ( IssuedProducts::class, 'stock_id' ) -> whereIn ( 'issuance_id', function ( $query ) {
                $query -> select ( 'id' ) -> from ( 'issuance' ) -> where ( [
                                                                                'from_branch' => auth () -> user () -> branch_id,
                                                                                'deleted_at'  => null
                                                                            ] );
            } ) -> sum ( 'quantity' );
        }

        public function returned_quantity () {
            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( StockReturnProduct::class, 'stock_id' ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [ 'type' => 'vendor-return' ] ) -> where ( [
                                                                                                                                'deleted_at' => null
                                                                                                                            ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }

        public function adjustment_decrease () {
            if ( request () -> has ( 'branch-id' ) && request () -> filled ( 'branch-id' ) ) {
                $branch_id = request ( 'branch-id' );

                return $this -> hasMany ( StockReturnProduct::class, 'stock_id' ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [ 'type' => 'adjustment-decrease' ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                        $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                    } );
                } ) -> sum ( 'quantity' );
            }

            $branch_id = auth () -> user () -> branch_id;
            return $this -> hasMany ( StockReturnProduct::class, 'stock_id' ) -> whereIn ( 'stock_return_id', function ( $query ) use ( $branch_id ) {
                $query -> select ( 'id' ) -> from ( 'stock_returns' ) -> where ( [
                                                                                     'type'       => 'adjustment-decrease',
                                                                                     'deleted_at' => null
                                                                                 ] ) -> whereIn ( 'user_id', function ( $query ) use ( $branch_id ) {
                    $query -> select ( 'id' ) -> from ( 'users' ) -> where ( [ 'branch_id' => $branch_id ] );
                } );
            } ) -> sum ( 'quantity' );
        }
        public function branch()
        {
            return $this->belongsTo(Branch::class);
        }
    }
