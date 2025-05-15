<?php

    namespace App\Http\Services;

    use App\Models\Customer;
    use App\Models\Product;
    use App\Models\ProductStock;
    use App\Models\Sale;
    use App\Models\SaleProducts;
    use App\Models\Stock;
    use Carbon\Carbon;
    use Illuminate\Support\Facades\DB;

    class SaleService {

        /**
         * --------------
         * @return mixed
         * get all countries
         * --------------
         */

        public function all (): mixed {
            $sales = Sale ::with ( [ 'products.product', 'user' ] );

            if ( count ( array_intersect ( config ( 'constants.system_access' ), auth () -> user () -> user_roles () ) ) < 1 )
                $sales -> where ( [ 'user_id' => auth () -> user () -> id ] );

                dd(request()->all());
            if ( request () -> filled ( 'start-date' ) && request () -> filled ( 'end-date' ) ) {
                $start_date = date ( 'Y-m-d', strtotime ( request ( 'start-date' ) ) );
                $end_date   = date ( 'Y-m-d', strtotime ( request ( 'end-date' ) ) );
                $sales -> whereBetween ( DB ::raw ( 'DATE(closed_at)' ), [ $start_date, $end_date ] );
            }

            if ( request () -> filled ( 'sale-id' ) ) {
                $sale_id = request ( 'sale-id' );
                $sales -> where ( [ 'id' => $sale_id ] );
            }

            if ( request () -> filled ( 'order-no' ) ) {
                $order_no = request ( 'order-no' );
                $sales -> where ( [ 'sale_id' => $order_no ] );
            }

            if ( request () -> filled ( 'customer-id' ) ) {
                $customer_id = request ( 'customer-id' );
                $sales -> where ( [ 'customer_id' => $customer_id ] );
            }

            if ( request () -> filled ( 'user-id' ) ) {
                $customer_id = request ( 'user-id' );
                $sales -> where ( [ 'user_id' => $customer_id ] );
            }

            if (request()->query('closed') == 'true') {
                $sales->where('sale_closed', 1);
            }else{
                $sales->where('sale_closed', 0);
            }

            return $sales -> latest () -> paginate ( 25 );
        }

        /**
         * --------------
         * @param $product_id
         * @param $sale_qty
         * @return float[]|int[]
         * get product & its stock
         * run loop to subtract quantity from available
         * & update the sale quantity
         * run the avg sale quantity of selected stocks
         * & net price
         * --------------
         */

        public function get_price_by_sale_quantity ( $product_id, $sale_qty ): array {
            $product = Product ::findorFail ( $product_id );
            $tax = $product -> tax ? [ 'rate' => $product -> tax -> rate,
                                       'title' => $product -> tax -> title ] : null;

            $product -> load ( [
                                   'stocks',
                                   'customer_price'
                               ] );
            $info     = array ();
            $price    = 0;
            $netPrice = 0;
            if ( count ( $product -> stocks ) > 0 ) {
                foreach ( $product -> stocks as $stock ) {
                    if ( $sale_qty > 0 ) {
                        $quantity     = $stock -> quantity;
                        $soldQuantity = $stock -> sold_quantity ();

                        if ( !empty( $product -> customer_price ) )
                            $sale_unit = $product -> customer_price -> price;
                        else
                            $sale_unit = $stock -> sale_unit;

                        //                        $available_qty = $quantity - $soldQuantity;
                        $available_qty = $stock -> available ();

                        if ( $available_qty > 0 ) {
                            $sale[ 'stock_id' ]  = $stock -> id;
                            $sale[ 'sale_unit' ] = $sale_unit;

                            if ( $available_qty >= $sale_qty ) {
                                $sale[ 'available_qty' ] = $available_qty;
                                $sale[ 'sale_qty' ]      = $sale_qty;
                                $sale[ 'remaining_qty' ] = $available_qty - $sale_qty;
                                $sale_qty                = 0;
                            }
                            else {
                                $sale[ 'available_qty' ] = $available_qty;
                                $sale[ 'sale_qty' ]      = $sale_qty - $available_qty;
                                $sale[ 'remaining_qty' ] = $sale_qty - $available_qty;
                                $sale[ 'sale_qty' ]      = $sale_qty - $sale[ 'remaining_qty' ];
                                $sale_qty                -= $available_qty;
                            }
                            array_push ( $info, $sale );
                        }
                    }
                }
            }

            $netSaleQty = 0;

            if ( count ( $info ) > 0 ) {
                foreach ( $info as $item ) {
                    $sale_unit  = $item[ 'sale_unit' ];
                    $sale_qty   = $item[ 'sale_qty' ];
                    $price      = $price + $sale_unit;
                    $netPrice   += ( $sale_qty * $sale_unit );
                    $netSaleQty += $item[ 'sale_qty' ];
                }
            }
//                'price'     => $price / count ( $info ),
            return [
                'price'     => ( $netPrice / $netSaleQty ),
                'net_price' => $netPrice,
                'tax'       => $tax
            ];
        }

        /**
         * --------------
         * @param $request
         * @return float|int
         * get sales total price
         * --------------
         */


         public function get_sale_total_v2($request): float|int
         {
             $products = $request->input('products');
             $netPrice = 0;

             if (count($products) > 0) {
                 foreach ($products as $key => $product_id) {
                     $sale_qty = (int) $request->input("quantity.$key", 0);
                     $flat_discount = floatval($request->input("discount.$key", 0));
                     $unit_price = floatval($request->input("price.$key", 0)); // Use submitted price

                     if ($sale_qty <= 0) continue;

                     $product_net_price = $unit_price * $sale_qty;

                     // Apply flat discount once per product line
                     $discounted_price = max(0, $product_net_price - $flat_discount);

                     // If you still want to apply tax, you can use a fixed rate or dynamic logic here
                     $taxRate = 0; // Set to actual tax rate if needed

                     $price_with_tax = $discounted_price + ($discounted_price * ($taxRate / 100));

                     $netPrice += round($price_with_tax, 2);
                 }
             }

             return round($netPrice, 2);
         }



        public function get_sale_total ( $request ): float | int {

            $products = $request -> input ( 'products' );
            $info     = array ();
            $netPrice = 0;
            $discounts = 0; // Track total discounts

            if ( count ( $products ) > 0 ) {
                foreach ( $products as $key => $product_id ) {
                    $product = Product ::findorFail ( $product_id );
                    $taxRate = $product -> tax ? $product -> tax -> rate : 0;

                    $product -> load ( [ 'stocks', 'customer_price' ] );

                    $sale_qty = $request -> input ( 'quantity.' . $key );
                    $product_discount = floatval($request -> input ( 'discount.' . $key, 0)); // Get product discount

                    if ( count ( $product -> stocks ) > 0 ) {
                        foreach ( $product -> stocks as $stock ) {
                            if ( $sale_qty > 0 ) {

                                $quantity     = $stock -> quantity;
                                $soldQuantity = $stock -> sold_quantity ();

                                if ( !empty( $product -> customer_price ) )
                                    $sale_unit = $product -> customer_price -> price;
                                else
                                    $sale_unit = $stock -> sale_unit;

                                $available_qty = $stock -> available ();

                                if ( $available_qty > 0 ) {
                                    $sale[ 'stock_id' ]  = $stock -> id;
                                    $sale[ 'sale_unit' ] = $sale_unit;

                                    if ( $available_qty >= $sale_qty ) {
                                        $sale[ 'available_qty' ] = $available_qty;
                                        $sale[ 'sale_qty' ]      = $sale_qty;
                                        $sale[ 'remaining_qty' ] = $available_qty - $sale_qty;
                                        $sale[ 'taxRate' ]       = $taxRate;
                                        $sale[ 'discount' ]      = $product_discount;
                                        $sale_qty                = 0;
                                    }
                                    else {
                                        $sale[ 'available_qty' ] = $available_qty;
                                        $sale[ 'sale_qty' ]      = $sale_qty - $available_qty;
                                        $sale[ 'remaining_qty' ] = $sale_qty - $available_qty;
                                        $sale[ 'sale_qty' ]      = $sale_qty - $sale[ 'remaining_qty' ];
                                        $sale[ 'taxRate' ]       = $taxRate;
                                        $sale[ 'discount' ]      = $product_discount;
                                        $sale_qty                -= $available_qty;
                                    }
                                    array_push ( $info, $sale );
                                }
                            }
                        }
                    }
                }
            }

            if (count($info) > 0) {
                foreach ($info as $item) {
                    $sale_unit = $item['sale_unit'];
                    $sale_qty  = $item['sale_qty'];
                    $taxRate   = $item['taxRate'];
                    $discount  = $item['discount'];

                    // Calculate price before tax
                    $itemPrice = $sale_qty * $sale_unit;

                    // Apply flat discount (ensure it doesn't exceed the item price)
                    $flatDiscount = min($discount, $itemPrice);
                    $discountedPrice = $itemPrice - $flatDiscount;

                    // Add tax to the discounted price
                    $priceWithTax = $discountedPrice + ($discountedPrice * ($taxRate / 100));

                    // Add to total net price
                    $netPrice += $priceWithTax;

                    // Track total discounts applied
                    $discounts += $flatDiscount;
                }
            }

            return $netPrice;
        }
        public function get_sale_tax_total($request): float | int
        {
            $products = $request->input('products');
            $info = array();
            $totalTax = 0; // Variable to store the total tax

            if (count($products) > 0) {
                foreach ($products as $key => $product_id) {
                    $product = Product::findOrFail($product_id);
                    $taxRate = $product->tax->rate ?? 0;

                    $product->load(['stocks', 'customer_price']);

                    $sale_qty = $request->input('quantity.' . $key);
                    $product_discount = $request->input('discount.' . $key, 0); // Get individual product discount

                    if (count($product->stocks) > 0) {
                        foreach ($product->stocks as $stock) {
                            if ($sale_qty > 0) {

                                $quantity = $stock->quantity;
                                $soldQuantity = $stock->sold_quantity();

                                if (!empty($product->customer_price))
                                    $sale_unit = $product->customer_price->price;
                                else
                                    $sale_unit = $stock->sale_unit;

                                $available_qty = $stock->available();

                                if ($available_qty > 0) {
                                    $sale['stock_id'] = $stock->id;
                                    $sale['sale_unit'] = $sale_unit;

                                    if ($available_qty >= $sale_qty) {
                                        $sale['available_qty'] = $available_qty;
                                        $sale['sale_qty'] = $sale_qty;
                                        $sale['remaining_qty'] = $available_qty - $sale_qty;
                                        $sale['taxRate'] = $product->tax->rate ?? 0;
                                        $sale['discount'] = $product_discount; // Store discount
                                        $sale_qty = 0;
                                    } else {
                                        $sale['available_qty'] = $available_qty;
                                        $sale['sale_qty'] = $sale_qty - $available_qty;
                                        $sale['remaining_qty'] = $sale_qty - $available_qty;
                                        $sale['sale_qty'] = $sale_qty - $sale['remaining_qty'];
                                        $sale['taxRate'] = $product->tax->rate ?? 0;
                                        $sale['discount'] = $product_discount; // Store discount
                                        $sale_qty -= $available_qty;
                                    }
                                    array_push($info, $sale);
                                }
                            }
                        }
                    }
                }
            }

            if (count($info) > 0) {
                foreach ($info as $item) {
                    $sale_unit = $item['sale_unit'];
                    $sale_qty  = $item['sale_qty'];
                    $taxRate   = $item['taxRate'];
                    $discount  = floatval($item['discount']);

                    // Calculate total price before discount
                    $totalPrice = $sale_qty * $sale_unit;

                    // Apply flat discount (ensure it doesn't exceed the total price)
                    $flatDiscount = min($discount, $totalPrice);
                    $discountedPrice = $totalPrice - $flatDiscount;

                    // Calculate tax on the discounted price
                    $totalTax += $discountedPrice * ($taxRate / 100);
                }
            }

            return $totalTax; // Return only the total tax amount
        }


        public function get_sale_tax_total_v2($request): float|int
        {
            $products = $request->input('products');
            $totalTax = 0;
            // dd($request->all());
            if (count($products) > 0) {
                foreach ($products as $key => $product_id) {
                    $sale_qty = (int) $request->input("quantity.$key", 0);
                    $flat_discount = floatval($request->input("discount.$key", 0));
                    $unit_price = floatval($request->input("price.$key", 0)); // Get submitted price
                    // Try to get tax from request, otherwise fallback to DB
                    $taxRate = $request->has("tax.$key")
                        ? floatval($request->input("tax.$key", 0))
                        : (\App\Models\Product::find($product_id)?->tax?->rate ?? 0); // fallback to DB

                    if ($sale_qty <= 0) continue;

                    $product_net_price = $unit_price * $sale_qty;

                    // Apply flat discount once per product line
                    $discounted_price = max(0, $product_net_price - $flat_discount);

                    // Calculate tax only (based on discounted amount)
                    $product_tax = $discounted_price * ($taxRate / 100);

                    // Print tax info for this product

                    $totalTax += round($product_tax, 2);
                }
            }

            return round($totalTax, 2);
}



        /**
         * --------------
         * @param $request
         * @return mixed
         * create sale
         * store data in sales table
         * --------------
         */

        public function sale ( $request ): mixed {
            $total = $this -> get_sale_total_v2 ( $request );
            $Tax_Total = $this -> get_sale_tax_total_v2 ( $request );
            $net   = 0;
          //  dd($Tax_Total, $total);

            if ( $request -> has ( 'percentage-discount' ) && $request -> filled ( 'percentage-discount' ) && $request -> input ( 'percentage-discount' ) > 0 ) {
                $discount = $request -> input ( 'percentage-discount' );

                if ( $discount < 0 )
                    $discount = 0;

                if ( $discount > 100 )
                    $discount = 100;

                $net = $total - ( $total * $discount ) / 100;
            }

            else if ( $request -> has ( 'flat-discount' ) && $request -> filled ( 'flat-discount' ) && $request -> input ( 'flat-discount' ) > 0 ) {
                $discount = $request -> input ( 'flat-discount' );
                $net      = $total - $discount;
            }
            else
                $net = $total;

            $boxes = 1;
            if ( $request -> filled ( 'boxes' ) && $request -> input ( 'boxes' ) > 0 )
                $boxes = $request -> input ( 'boxes' );

            $settings = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );

            if ( $request -> input ( 'shipping', 0 ) === '1' )
                $net += optional ( $settings -> settings ) -> shipping_charges;

            $info = array (
                'user_id'             => auth () -> user () -> id,
                'customer_id'         => $request -> input ( 'customer_id' ),
                'sale_id'             => $this -> generateSaleId (),
                'courier_id'          => $request -> input ( 'shipping', 0 ) === '1' ? optional ( $settings -> settings ) -> courier : null,
                'shipping'            => $request -> input ( 'shipping', 0 ) === '1' ? optional ( $settings -> settings ) -> shipping_charges : null,
                'total'               => $total,
                'tax_total'           => $Tax_Total,
                'flat_discount'       => $request -> input ( 'flat-discount' ),
                'percentage_discount' => $request -> input ( 'percentage-discount' ),
                'net'                 => $net + ($Tax_Total > 0 ? $Tax_Total : 0),
                'amount_added'        => $request -> input ( 'paid-amount' ),
                'customer_type'       => $request -> input ( 'customer-type' ),
                'boxes'               => $boxes,
                'remarks'             => $request -> input ( 'remarks' ),
            );

            return Sale ::create ( $info );

        }

        // private function generateSaleId (): string {
        //     $date      = now () -> format ( 'Ymd' );
        //     $lastSale  = Sale ::latest () -> first ();
        //     $increment = $lastSale ? intval ( substr ( $lastSale -> id, 9 ) ) + 1 : 1;
        //     return $date . sprintf ( '%04d', $increment );
        // }
        private function generateSaleId(): string {
            $date = now()->format('Ymd');

            // Fetch the last sale record
            $lastSale = Sale::whereRaw("DATE(created_at) = CURDATE()") // Ensures it's from today
                            ->orderBy('created_at', 'desc')
                            ->first();

            // Determine the next increment value
            $increment = $lastSale ? intval(substr($lastSale->sale_id, 9)) + 1 : 1;

            // Return the formatted sale ID
            return $date . sprintf('%04d', $increment);
        }


        /**
         * --------------
         * @param $request
         * @param $sale
         * @return void
         * edit sale
         * edit data in sales table
         * --------------
         */

        public function edit_sale ( $request, $sale ): void {
            $total = $this -> get_sale_total_v2 ( $request );
            $net   = 0;

            if ( $request -> has ( 'percentage-discount' ) && $request -> input ( 'percentage-discount' ) > 0 ) {
                $discount = $request -> input ( 'percentage-discount' );

                if ( $discount < 0 )
                    $discount = 0;

                if ( $discount > 100 )
                    $discount = 100;

                $net = $total - ( $total * $discount ) / 100;
            }

            else if ( $request -> has ( 'flat-discount' ) && $request -> filled ( 'flat-discount' ) && $request -> input ( 'flat-discount' ) > 0 ) {
                $discount = $request -> input ( 'flat-discount' );
                $net      = $total - $discount;
            }

            else
                $net = $total;

            $boxes = 1;
            if ( $request -> filled ( 'boxes' ) && $request -> input ( 'boxes' ) > 0 )
                $boxes = $request -> input ( 'boxes' );

            $settings = ( new SiteSettingService() ) -> get_settings_by_slug ( 'site-settings' );

            if ( $request -> input ( 'shipping', 0 ) === '1' )
                $net += optional ( $settings -> settings ) -> shipping_charges;

            $sale -> customer_id         = $request -> input ( 'customer_id' );
            $sale -> total               = $total;
            $sale -> flat_discount       = $request -> input ( 'flat-discount' );
            $sale -> percentage_discount = $request -> input ( 'percentage-discount' );
            $sale -> courier_id          = $request -> input ( 'shipping', 0 ) === '1' ? optional ( $settings -> settings ) -> courier : null;
            $sale -> shipping            = $request -> input ( 'shipping', 0 ) === '1' ? optional ( $settings -> settings ) -> shipping_charges : null;
            $sale -> net                 = $net;
            $sale -> amount_added        = $request -> input ( 'paid-amount' );
            $sale -> boxes               = $boxes;
            $sale -> remarks             = $request -> input ( 'remarks' );
            $sale -> update ();
        }

        /**
         * --------------
         * @param $sale
         * edit sale
         * edit data in sales table
         * --------------
         */

        public function close_sale ( $sale ): void {
            $sale -> sale_closed = '1';
            $sale -> closed_at   = Carbon ::now ();
            $sale -> update ();
        }

        /**
         * --------------
         * @param $request
         * @param $sale_id
         * @return void
         * sale products
         * --------------
         */

         public function sale_products($request, $sale): void
         {
             $sale_id = $sale->id;
             $products = $request->input('products');

             if (count($products) > 0) {
                 foreach ($products as $key => $product_id) {
                     $product = Product::findOrFail($product_id);
                     $taxRate = $product->tax ? $product->tax->rate : null;
                     $product->load(['stocks', 'customer_price']);

                     $sale_qty = (int) $request->input("quantity.$key");
                     $product_discount = (float) $request->input("discount.$key", 0);

                     // ✅ Get average price using total sale_qty (not stock split)
                     $avgPriceData = $this->get_price_by_sale_quantity($product_id, $sale_qty);
                     $avgSalePrice = $avgPriceData['price'];

                     $isFirst = true;

                     foreach ($product->stocks as $stock) {
                         if ($sale_qty <= 0) break;

                         $available_qty = $stock->available();
                         if ($available_qty <= 0) continue;

                         $sale_unit = $product->customer_price->price ?? $stock->sale_unit;
                         $usable_qty = min($available_qty, $sale_qty);

                         $sale = [
                             'stock_id'       => $stock->id,
                             'available_qty'  => $available_qty,
                             'sale_qty'       => $usable_qty,
                             'remaining_qty'  => $available_qty - $usable_qty,
                             'sale_unit'      => $sale_unit,
                         ];

                         // ✅ Apply discount only on the first stock split
                         $flatDiscount = $isFirst ? min($product_discount, $usable_qty * $sale_unit) : 0;
                         $discountPerItem = $isFirst ? $product_discount : 0;

                         // Price calculations
                         $totalPrice = $usable_qty * $sale_unit;
                         $discountedPrice = $totalPrice - $flatDiscount;
                         $tax_value = $discountedPrice * ($taxRate / 100);
                         $finalPrice = $discountedPrice + $tax_value;

                         $info = [
                             'sale_id'           => $sale_id,
                             'product_id'        => $product_id,
                             'stock_id'          => $stock->id,
                             'quantity'          => $usable_qty,
                             'price'             => $sale_unit,
                             'avgSalePrice'      => $avgSalePrice, // ✅ applied here
                             'discount'          => $flatDiscount,
                             'discount_per_item' => $discountPerItem,
                             'net_price'         => $finalPrice,
                             'tax_value'         => $tax_value,
                         ];

                         SaleProducts::create($info);

                         $sale_qty -= $usable_qty;
                         $isFirst = false;
                     }
                 }
             }
         }


        public function calculate_per_product_discount ( $sale ) {
            $total = $sale -> total;
            $net   = $sale -> net;

            $discount = $total - $net;
            $products = count ( request ( 'products' ) );
            return ( $discount / $products );
        }


        public function sale_products_v2($request, $sale): void
        {
            $sale_id = $sale->id;
            $products = $request->input('products');

            if (count($products) > 0) {
                foreach ($products as $key => $product_id) {
                    $product = Product::findOrFail($product_id);
                    $taxRate = $product->tax ? $product->tax->rate : 0; // Default to 0 if not present
                    $product->load(['stocks']);

                    $sale_qty = (int) $request->input("quantity.$key");
                    $product_discount = (float) $request->input("discount.$key", 0);
                    $sale_unit = (float) $request->input("price.$key"); // ✅ Use submitted price
                    $avgSalePrice = $sale_unit; // ✅ You can assume it's the same as sale_unit

                    $isFirst = true;

                    foreach ($product->stocks as $stock) {
                        if ($sale_qty <= 0) break;

                        $available_qty = $stock->available();
                        if ($available_qty <= 0) continue;

                        $usable_qty = min($available_qty, $sale_qty);

                        // ✅ Apply discount only on first split
                        $flatDiscount = $isFirst ? min($product_discount, $usable_qty * $sale_unit) : 0;
                        $discountPerItem = $isFirst ? $product_discount : 0;

                        // Price calculations
                        $totalPrice = $usable_qty * $sale_unit;
                        $discountedPrice = $totalPrice - $flatDiscount;
                        $tax_value = $discountedPrice * ($taxRate / 100);
                        $finalPrice = $discountedPrice + $tax_value;

                        $info = [
                            'sale_id'           => $sale_id,
                            'product_id'        => $product_id,
                            'stock_id'          => $stock->id,
                            'quantity'          => $usable_qty,
                            'price'             => $sale_unit,
                            'avgSalePrice'      => $avgSalePrice,
                            'discount'          => $flatDiscount,
                            'discount_per_item' => $discountPerItem,
                            'net_price'         => $finalPrice,
                            'tax_value'         => $tax_value,
                        ];

                        SaleProducts::create($info);

                        $sale_qty -= $usable_qty;
                        $isFirst = false;
                    }
                }
            }
        }


        /**
         * --------------
         * @param $sale_id
         * @return void
         * delete sale products
         * --------------
         */

        public function delete_sold_products ( $sale_id ): void {
            DB ::table ( 'sale_products' ) -> where ( [ 'sale_id' => $sale_id ] ) -> delete ();
        }

        /**
         * --------------
         * @param $sale
         * @return void
         * delete sale
         * --------------
         */

        public function delete_sale ( $sale ): void {
            $sale -> load ( 'sold_products' );
            $sale -> delete ();
            if ( count ( $sale -> sold_products ) > 0 ) {
                foreach ( $sale -> sold_products as $product ) {
                    $product -> delete ();
                }
            }
        }

        /**
         * --------------
         * @param $sale
         * @return array
         * create array of products
         * --------------
         */

        public function create_array_of_sold_products ( $sale ): array {
            $products = array ();
            if ( count ( $sale -> products ) > 0 ) {
                foreach ( $sale -> products as $product ) {
                    if ( !in_array ( $product -> product_id, $products ) )
                        array_push ( $products, $product -> product_id );
                }
            }
            return $products;
        }

        /**
         * --------------
         * @param $sale
         * @return float|int
         * get sales total price
         * --------------
         */

        public function get_cost_of_sale_tp_wise ( $sale ): float | int {

            $sale -> load ( 'sold_products' );
            $netPrice = 0;
            if ( count ( $sale -> sold_products ) > 0 ) {
                foreach ( $sale -> sold_products as $product ) {
                    $stock    = ProductStock ::findorFail ( $product -> stock_id );
                    $quantity = $product -> quantity;

                    $netPrice = $netPrice + ( $stock -> tp_unit * $quantity );
                }
            }
            return $netPrice;
        }

        /**
         * --------------
         * @param $sale
         * @return bool
         * validate sale before close
         * check if there is/are any out of stock products
         * --------------
         */

        public function validate_sale ( $sale ): bool {

            $bool = true;
            $sale -> load ( 'sold_products.product_stocks' );
            if ( count ( $sale -> sold_products ) > 0 ) {
                foreach ( $sale -> sold_products as $product ) {
                    if ( $product -> product_stocks -> available () < $product -> quantity ) {
                        $bool = false;
                        break;
                    }
                }
            }
            return $bool;
        }

        /**
         * --------------
         * @param $sale_id
         * @return mixed
         * get sales summary
         * group by attributes
         * --------------
         */

        public function summary ( $sale_id ) {
            $products = SaleProducts ::select ( [
                                                    'sale_id',
                                                    'product_id'
                                                ] ) -> selectRaw ( 'SUM(quantity) as quantity' ) -> selectRaw ( 'SUM(net_price) as net_price' ) -> where ( [ 'sale_id' => $sale_id ] ) -> groupBy ( [
                                                                                                                                                                                                        'product_id',
                                                                                                                                                                                                        'sale_id'
                                                                                                                                                                                                    ] ) -> with ( [ 'product.term.term.attribute' ] ) -> get ();

            $summary = array ();

            if ( count ( $products ) > 0 ) {
                foreach ( $products as $product ) {
                    if ( $product -> product -> product_type == 'variable' ) {
                        $array[ 'attribute_id' ] = $product -> product -> term -> term -> attribute -> id;
                        $array[ 'quantity' ]     = $product -> quantity;
                        $array[ 'net_price' ]    = $product -> net_price;
                        array_push ( $summary, $array );
                    }
                }
            }
            $result = array ();
            foreach ( $summary as $value ) {
                if ( isset( $result[ $value[ "attribute_id" ] ] ) ) {
                    $result[ $value[ "attribute_id" ] ][ "quantity" ]  += $value[ "quantity" ];
                    $result[ $value[ "attribute_id" ] ][ "net_price" ] += $value[ "net_price" ];
                }
                else {
                    $result[ $value[ "attribute_id" ] ] = $value;
                }
            }
            return ( array_values ( $result ) );

        }

        /**
         * --------------
         * @param $sale
         * @return mixed
         * clone sale and mark it as refunded
         * --------------
         */

        public function refund_sale ( $sale ) {
            $sale -> total       = ( $sale -> total * -1 );
            $sale -> net         = ( $sale -> net * -1 );
            $sale -> refunded    = '1';
            $sale -> refund_date = Carbon ::now ();
            $sale -> update ();
        }

        public function get_sale_by_attribute_wise ( $sale_id ) {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            return DB ::select ( "SELECT ims_attributes.id as attribute_id, ims_attributes.title, ims_sale_products.product_id, SUM(ims_sale_products.quantity) as quantity, SUM(ims_sale_products.price) as price, SUM(ims_sale_products.net_price) as net_price, COUNT(ims_sale_products.product_id) as noOfRows FROM ims_attributes JOIN ims_terms ON ims_attributes.id=ims_terms.attribute_id JOIN ims_product_terms ON ims_terms.id=ims_product_terms.term_id JOIN ims_sale_products ON ims_product_terms.product_id=ims_sale_products.product_id WHERE ims_sale_products.sale_id=$sale_id GROUP BY ims_attributes.id, ims_sale_products.sale_id, ims_sale_products.product_id" );
        }

        public function get_simple_sold_products ( $sale_id ) {
            return SaleProducts ::select ( 'product_id', DB ::raw ( 'SUM(quantity) as quantity' ), DB ::raw ( 'SUM(price) as price' ), DB ::raw ( 'SUM(net_price) as net_price' ), DB ::raw ( 'SUM(tax_value) as tax_value' ), DB ::raw ( 'COUNT(product_id) as noOfRows' ), DB ::raw ( 'SUM(discount_per_item) as discount_per_item' ), DB ::raw ( 'MIN(avgSalePrice) as avgSalePrice' ) )
                -> whereNotIn ( 'product_id', function ( $query ) {
                    $query -> select ( 'product_id' ) -> from ( 'product_terms' );
                } )
                -> where ( [ 'sale_id' => $sale_id ] )
                -> groupBy ( 'product_id' )
                -> get ();
        }

        public function get_cost_of_return_tp_wise ( $sale ): float | int {

            $sale -> load ( 'products' );
            $netPrice = 0;
            if ( count ( $sale -> products ) > 0 ) {
                foreach ( $sale -> products as $product ) {
                    $stock    = ProductStock ::findorFail ( $product -> stock_id );
                    $quantity = $product -> quantity;

                    $netPrice = $netPrice + ( $stock -> tp_unit * $quantity );
                }
            }
            return $netPrice;
        }

        public function get_credit_sales ( $account_head_id, $account ) {
            if ( $account -> account_head_id != config ( 'constants.customers' ) )
                return [];

            $customer = Customer ::where ( [ 'account_head_id' => $account_head_id ] ) -> first ();
            return Sale ::where ( [ 'customer_type' => 'credit', 'sale_closed' => '1', 'customer_id' => $customer -> id ] )
                -> whereNotIn ( 'id', function ( $query ) use ( $account_head_id ) {
                    $query
                        -> select ( 'sale_id' )
                        -> from ( 'general_ledger_transaction_details' );
                } )
                -> get ();
        }

        public function add_tracking ( $request, $sale ): void {
            $sale -> tracking_no = $request -> input ( 'tracking-no' );
            $sale -> update ();
        }

    }
