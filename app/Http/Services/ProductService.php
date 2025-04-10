<?php

    namespace App\Http\Services;

    use App\Models\Attribute;
    use App\Models\CustomerProductPrice;
    use App\Models\Product;
    use App\Models\ProductImage;
    use App\Models\ProductStock;
    use App\Models\ProductTerm;
    use App\Models\SaleProducts;
    use App\Models\Stock;
    use App\Models\Term;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    use Intervention\Image\ImageManager;

    class ProductService {

        /**
         * --------------
         * @return mixed
         * get all products
         * --------------
         */

        // public function all ( $pagination = false ) {
        //     $rows     = request ( 'rows', 25 );
        //     $products = Product ::with ( [ 'manufacturer', 'category', 'term' ] );

        //     if ( request () -> filled ( 'title' ) )
        //         $products -> where ( 'title', 'LIKE', '%' . request ( 'title' ) . '%' );

        //     if ( request () -> filled ( 'sku' ) )
        //         $products -> where ( [ 'sku' => request ( 'sku' ) ] );

        //     if ( request () -> filled ( 'manufacturer-id' ) )
        //         $products -> where ( [ 'manufacturer_id' => request ( 'manufacturer-id' ) ] );

        //     if ( request () -> filled ( 'category-id' ) )
        //         $products -> where ( [ 'category_id' => request ( 'category-id' ) ] );

        //     $products -> latest ();
        //     return $pagination ? $products -> get () : $products -> paginate ( $rows );
        // }
        public function all($pagination = false) {
            $rows = request('rows', 25); // Default rows per page

            // Start building the query
            $products = Product::with(['manufacturer', 'category', 'term']);

            // Apply filters if query parameters are filled
            if (request()->filled('title')) {
                $products->where('title', 'LIKE', '%' . request('title') . '%');
            }

            if (request()->filled('sku')) {
                $products->where('sku', request('sku'));
            }

            if (request()->filled('manufacturer-id')) {
                $products->where('manufacturer_id', request('manufacturer-id'));
            }

            if (request()->filled('barcode')) {
                $products->where('barcode', request('barcode')); // Corrected to use 'barcode'
            }

            if (request()->filled('category-id')) {
                $products->where('category_id', request('category-id'));
            }
            if (request()->filled('tax-id')) {
                $products->where('tax_id', request('tax-id'));
            }


            // Order by latest added
            $products->latest();

            // Paginate if requested, otherwise get all results
            $products -> latest ();
            return $pagination ? $products -> get () : $products -> paginate ( $rows );
        }
        /**
         * --------------
         * @return mixed
         * get active products
         * --------------
         */

        public function active_products () {
            return Product ::with ( [
                                        'manufacturer',
                                        'category',
                                        'term',
                                    ] ) -> active () -> latest () -> get ();
        }

        /**
         * --------------
         * @return mixed
         * get all products
         * --------------
         */

        public function products_by_branch () {
            return Product ::ProductsByBranch () -> with ( [
                                                               'manufacturer',
                                                               'category',
                                                               'term'
                                                           ] ) -> active () -> latest () -> get ();
        }

        /**
         * --------------
         * @return mixed
         * get all products
         * --------------
         */

        public function products_with_stock () {
            return Product ::whereHas ( 'stocks' ) -> orderBy ( 'title', 'ASC' ) -> get ();
        }

        public function active_products_with_stock () {
            return Product ::whereHas ( 'stocks' ) -> where ( [ 'status' => '1' ] ) -> orderBy ( 'title', 'ASC' ) -> get ();
        }

        /**
         * --------------
         * @param $request
         * @return mixed
         * save products
         * --------------
         */

        public function save ( $request ) {
            return Product ::create ( [
                                          'user_id'          => auth () -> user () -> id,
                                          'manufacturer_id'  => $request -> input ( 'manufacturer-id' ),
                                          'category_id'      => $request -> input ( 'category-id' ),
                                          'title'            => $request -> input ( 'title' ),
                                          'slug'             => $this -> generate_slug ( $request -> input ( 'title' ) ),
                                          'sku'              => $request -> input ( 'sku' ),
                                          'barcode'          => $request -> input ( 'barcode' ),
                                          'threshold'        => $request -> input ( 'threshold' ),
                                          'tp_box'           => $request -> input ( 'tp-box' ),
                                          'pack_size'        => $request -> input ( 'pack-size' ),
                                          'tp_unit'          => $request -> input ( 'tp-unit' ),
                                          'sale_box'         => $request -> input ( 'sale-box' ),
                                          'sale_unit'        => $request -> input ( 'sale-unit' ),
                                          'product_type'     => $request -> input ( 'product-type' ),
                                          'image'            => $this -> upload_image ( $request ),
                                          'slider_product'   => $request -> input ( 'slider-product', 0 ),
                                          'slider_image'     => $this -> upload_slider_image ( $request ),
                                          'deal_of_they_day' => $request -> input ( 'deal-of-the-day', 0 ),
                                          'featured'         => $request -> input ( 'featured', 0 ),
                                          'best_seller'      => $request -> input ( 'best-seller', 0 ),
                                          'popular'          => $request -> input ( 'popular', 0 ),
                                          'discount'         => $request -> input ( 'discount', 0 ),
                                          'excerpt'          => $request -> input ( 'excerpt', null ),
                                          'description'      => $request -> input ( 'description', null ),
                                          'tax_id'           => $request -> input ( 'tax_id' ),

                                      ] );
        }

        /**
         * --------------
         * @param $request
         * @return mixed
         * save product term
         * --------------
         */

        public function save_term ( $request, $product_id ) {
            return ProductTerm ::create ( [
                                              'user_id'      => auth () -> user () -> id,
                                              'product_id'   => $product_id,
                                              'attribute_id' => $request -> input ( 'attribute-id' ),
                                              'term_id'      => $request -> input ( 'term-id' ),
                                          ] );
        }

        /**
         * --------------
         * @param $request
         * @return mixed
         * edit product term
         * --------------
         */

        public function edit_variable ( $request, $product_id ) {
            $term = ProductTerm ::where ( [
                                              'product_id' => $product_id,
                                          ] ) -> first ();

            if ( !empty( $term ) ) {
                $term -> term_id = $request -> input ( 'term-id' );
                $term -> update ();
            }

        }

        /**
         * --------------
         * @param $title
         * @return \Illuminate\Support\Stringable|mixed|string|__anonymous@6527
         * generate product slug
         * --------------
         */

        private function generate_slug ( $title ) {
            $slug = str ( $title ) -> slug ( '-' );
            $rows = Product ::where ( [ 'slug' => $slug ] ) -> count ();
            if ( $rows > 0 )
                return $slug . '-' . ( $rows + 1 );
            else
                return $slug;
        }

        /**
         * --------------
         * @param $request
         * @return mixed|void
         * upload image
         * --------------
         */

        private function upload_image ( $request ) {
            $savePath = './uploads/products';

            File ::ensureDirectoryExists ( $savePath, 0755, true );

            if ( $request -> hasFile ( 'image' ) ) {
                $filenameWithExt = $request -> file ( 'image' ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( 'image' ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                return $request -> file ( 'image' ) -> storeAs ( $savePath, $fileNameToStore );
            }
        }

        private function upload_slider_image ( $request ) {
            $savePath = './uploads/products/sliders';
            // dd($request->all());

            File ::ensureDirectoryExists ( $savePath, 0755, true );

            if ( $request -> hasFile ( 'slider-image' ) ) {
                $filenameWithExt = $request -> file ( 'slider-image' ) -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $request -> file ( 'slider-image' ) -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                // $path            = $request -> file ( 'slider-image ' ) -> storeAs ( $savePath, $fileNameToStore );
                 // Correct the key to 'slider-image' without extra space
                // $path = $request->file('slider-image')->storeAs($savePath, $fileNameToStore, 'public');
                return $request -> file ( 'slider-image' ) -> storeAs ( $savePath, $fileNameToStore );
                // dd($path);
                // $image           = ImageManager ::imagick () -> read ( $path );
                // $image -> scale ( height: 600 );
                // $image -> save ( $path );
                // return $path;
            }
        }

        /**
         * --------------
         * @param $request
         * @param $product
         * @return void
         * update products
         * --------------
         */

        public function edit ( $request, $product ) {


            $product -> manufacturer_id  = $request -> input ( 'manufacturer-id' );
            $product -> category_id      = $request -> input ( 'category-id' );
            $product -> title            = $request -> input ( 'title' );
            $product -> slug             = $this -> generate_slug ( $request -> input ( 'title' ) );
            $product -> sku              = $request -> input ( 'sku' );
            $product -> barcode          = $request -> input ( 'barcode' );
            $product -> threshold        = $request -> input ( 'threshold' );
            $product -> tp_box           = $request -> input ( 'tp-box' );
            $product -> pack_size        = $request -> input ( 'pack-size' );
            $product -> tp_unit          = $request -> input ( 'tp-unit' );
            $product -> sale_box         = $request -> input ( 'sale-box' );
            $product -> sale_unit        = $request -> input ( 'sale-unit' );
            $product -> slider_product   = $request -> input ( 'slider-product', 0 );
            $product -> deal_of_they_day = $request -> input ( 'deal-of-the-day', 0 );
            $product -> featured         = $request -> input ( 'featured', 0 );
            $product -> best_seller      = $request -> input ( 'best-seller', 0 );
            $product -> popular          = $request -> input ( 'popular', 0 );
            $product -> discount         = $request -> input ( 'discount', 0 );
            $product -> excerpt          = $request -> input ( 'excerpt', null );
            $product -> description      = $request -> input ( 'description', null );
            $product -> tax_id           = $request -> input ( 'tax_id' );

            if ( $request -> hasFile ( 'image' ) )
                $product -> image = $this -> upload_image ( $request );

            if ( $request -> hasFile ( 'slider-image' ) )
                $product -> slider_image = $this -> upload_slider_image ( $request );

            $product -> update ();
        }

        public function quick_update ( $request, $product ) {
            $product -> manufacturer_id = $request -> input ( 'manufacturer-id' );
            $product -> category_id     = $request -> input ( 'category-id' );
            $product -> title           = $request -> input ( 'title' );
            $product -> sku             = $request -> input ( 'sku' );
            $product -> barcode         = $request -> input ( 'barcode' );
            $product -> threshold       = $request -> input ( 'threshold' );
            $product -> tp_box          = $request -> input ( 'tp-box' );
            $product -> pack_size       = $request -> input ( 'pack-size' );
            $product -> tp_unit         = $request -> input ( 'tp-unit' );
            $product -> sale_box        = $request -> input ( 'sale-box' );
            $product -> sale_unit       = $request -> input ( 'sale-unit' );

            if ( $request -> hasFile ( 'image' ) )
                $product -> image = $this -> upload_image ( $request );

            $product -> update ();
        }

        /**
         * --------------
         * @param $product
         * @return void
         * update product status
         * --------------
         */

        public function status ( $product ) {
            $status            = $product -> status == '1' ? '0' : '1';
            $product -> status = $status;
            $product -> update ();
        }

        /**
         * --------------
         * @param $product
         * @return mixed
         * get product stock
         * --------------
         */

        public function get_stock ( $product ) {
            return $product -> load ( [ 'stocks.stock.vendor' ], [
                'stocks' => function ( $query ) {
                    $query -> orderBy ( 'expiry_date', 'ASC' );
                }
            ] );
        }

        /**
         * --------------
         * @param $request
         * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
         * get products branch wise
         * --------------
         */

        public function get_products_branch_wise ( $request ) {
            return ProductStock ::with ( [ 'product' ] ) -> select ( [
                                                                         'product_id',
                                                                         'branch_id'
                                                                     ] ) -> where ( [ 'branch_id' => $request -> input ( 'branch_id' ) ] ) -> groupBy ( [
                                                                                                                                                            'product_id',
                                                                                                                                                            'branch_id'
                                                                                                                                                        ] ) -> get ();
        }

        public function product_prices ( $customer_id ) {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();
            return DB ::select ( "SELECT ims_attributes.id as attribute_id, ims_attributes.title, GROUP_CONCAT(ims_customer_product_price.product_id) as products, GROUP_CONCAT(ims_customer_product_price.price) as prices FROM ims_attributes JOIN ims_terms ON ims_attributes.id=ims_terms.attribute_id JOIN ims_product_terms ON ims_terms.id=ims_product_terms.term_id JOIN ims_customer_product_price ON ims_product_terms.product_id=ims_customer_product_price.product_id WHERE ims_customer_product_price.customer_id=$customer_id GROUP BY ims_attributes.id" );
        }

        public function get_products_by_attributes ( $attribute_id ) {
            return Product ::whereIn ( 'id', function ( $query ) use ( $attribute_id ) {
                $query -> select ( 'product_id' ) -> from ( 'product_terms' ) -> whereIn ( 'term_id', function ( $query ) use ( $attribute_id ) {
                    $query -> select ( 'id' ) -> from ( 'terms' ) -> where ( [ 'attribute_id' => $attribute_id ] );
                } );
            } ) -> get ();
        }

        public function get_simple_products ( $customer_id ) {
            return Product ::whereNotIn ( 'id', function ( $query ) {
                $query -> select ( 'product_id' ) -> from ( 'product_terms' );
            } ) -> whereNotIn ( 'id', function ( $query ) use ( $customer_id ) {
                $query -> select ( 'product_id' ) -> from ( 'customer_product_price' ) -> where ( [ 'customer_id' => $customer_id ] );
            } ) -> get ();
        }

        public function get_simple_added_products_prices ( $customer_id ) {
            return CustomerProductPrice ::whereNotIn ( 'product_id', function ( $query ) {
                $query -> select ( 'product_id' ) -> from ( 'product_terms' );
            } ) -> where ( [ 'customer_id' => $customer_id ] ) -> with ( 'product' ) -> get ();
        }

        public function link_product_to_customer_prices ( $product_id ) {
            config () -> set ( 'database.connections.mysql.strict', false );
            DB ::reconnect ();

            if ( request () -> filled ( 'attribute-id' ) ) {
                $attribute_id = request ( 'attribute-id' );
                $products     = DB ::table ( 'attributes' )
                    -> join ( 'terms', 'attributes.id', '=', 'terms.attribute_id' )
                    -> join ( 'product_terms', 'terms.id', '=', 'product_terms.term_id' )
                    -> where ( [ 'attributes.id' => $attribute_id ] )
                    -> pluck ( 'product_terms.product_id' )
                    -> toArray ();

                if ( count ( $products ) > 0 ) {
                    $prices = DB ::table ( 'customer_product_price' )
                        -> select ( [ 'customer_id', 'product_id', 'price' ] )
                        -> whereIn ( 'product_id', $products )
                        -> groupBy ( 'customer_id' )
                        -> get ();


                    if ( count ( $prices ) > 0 ) {
                        foreach ( $prices as $price ) {
                            CustomerProductPrice ::create ( [
                                                                'user_id'     => auth () -> user () -> id,
                                                                'customer_id' => $price -> customer_id,
                                                                'product_id'  => $product_id,
                                                                'price'       => $price -> price
                                                            ] );
                        }
                    }

                }

            }
        }

        public function update_bulk_update_prices ( $request ) {
            if ( count ( $request -> input ( 'tp-unit' ) ) > 0 ) {
                $tp       = $request -> input ( 'tp-unit' );
                $sale     = $request -> input ( 'sale-unit' );
                $tp_box   = $request -> input ( 'tp-box' );
                $sale_box = $request -> input ( 'sale-box' );

                foreach ( $tp as $key => $price ) {
                    Product ::where ( [ 'id' => $key ] ) -> update ( [
                                                                         'tp_unit'   => $price,
                                                                         'sale_unit' => $sale[ $key ],
                                                                         'tp_box'    => $tp_box[ $key ],
                                                                         'sale_box'  => $sale_box[ $key ],
                                                                     ] );
                }

            }
        }

        public function filter_products (): Collection | array {
            $search   = false;
            $products = Product ::with ( [ 'manufacturer', 'category', 'term' ] );

            if ( request () -> has ( 'category-id' ) && request ( 'category-id' ) > 0 ) {
                $products -> where ( [ 'category_id' => request ( 'category-id' ) ] );
                $search = true;
            }

            if ( request () -> has ( 'selected-products' ) && request () -> filled ( 'selected-products' ) ) {
                $selected = explode ( ',', request ( 'selected-products' ) );
                $products -> whereIn ( 'id', $selected );
                $search = true;
            }

            $products = $products -> latest () -> get ();

            if ( request ( 'product-availability' ) == 'available' ) {
                return $search ? $products -> filter ( function ( $product ) {
                    return $product -> available_quantity () > 0;
                } ) : [];
            }

            return $search ? $products : [];
        }

        public function validate_sku ( $request ) {
            $sku = $request -> input ( 'sku' );
            return Product ::where ( [ 'sku' => $sku ] ) -> count ();
        }

        public function validate_barcode ( $request ) {
            $barcode = $request -> input ( 'barcode' );
            return Product ::where ( [ 'barcode' => $barcode ] ) -> count ();
        }

        public function save_product_images ( $request, $product_id ): void {
            $documents = $request -> file ( 'product-images', [] );

            if ( count ( $documents ) > 0 ) {
                foreach ( $request -> file ( 'product-images' ) as $image ) {
                    ProductImage ::create ( [
                                                'user_id'    => auth () -> user () -> id,
                                                'product_id' => $product_id,
                                                'image'      => $this -> upload_file ( $image, $product_id . '/images' ),
                                            ]
                    );
                }
            }
        }

        public function upload_file ( $file, $folder ): string {
            $storePath = './uploads/products/' . $folder . '/';
            File ::ensureDirectoryExists ( $storePath, 0755, true );

            if ( $file ) {
                $filenameWithExt = $file -> getClientOriginalName ();
                $filename        = pathinfo ( $filenameWithExt, PATHINFO_FILENAME );
                $extension       = $file -> getClientOriginalExtension ();
                $fileNameToStore = $filename . '-' . time () . '.' . $extension;
                $path            = $file -> storeAs ( $storePath, $fileNameToStore );
                $image           = ImageManager ::imagick () -> read ( $path );
                $image -> scale ( height: 1000 );
                $image -> save ( $path );
                return asset ( $path );
            }
        }

        public function store_variations ( $request, $product, $attributes ): void {
            if ( count ( $attributes ) > 0 ) {
                foreach ( $attributes as $attribute_id ) {
                    $terms = collect ( $request -> input ( 'terms.' . $attribute_id ) );
                    if ( count ( $terms ) > 0 ) {
                        foreach ( $terms as $term_id ) {
                            $term  = Term ::find ( $term_id );
                            $title = $product -> title . ' - ' . $term -> title;

                            $variationProduct                 = $product -> replicate ();
                            $variationProduct -> parent_id    = $product -> id;
                            $variationProduct -> product_type = 'variable';
                            $variationProduct -> title        = $title;
                            $variationProduct -> slug         = $this -> generate_slug ( $title );
                            $variationProduct -> save ();

                            ProductTerm ::create ( [
                                                       'user_id'      => auth () -> user () -> id,
                                                       'product_id'   => $variationProduct -> id,
                                                       'attribute_id' => $attribute_id,
                                                       'term_id'      => $term_id,
                                                   ] );
                        }
                    }
                }
                $product -> has_variations = '1';
                $product -> update ();
            }
        }
    }
