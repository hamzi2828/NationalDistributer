<?php
    
    namespace App\Http\Services;
    
    use App\Models\Attribute;
    use App\Models\CustomerProductPrice;
    use App\Models\Product;
    use App\Models\ProductImage;
    use App\Models\ProductStock;
    use App\Models\ProductTerm;
    use App\Models\ProductVariation;
    use App\Models\ProductVariationTerm;
    use App\Models\SaleProducts;
    use App\Models\Stock;
    use App\Models\Term;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\File;
    
    class ProductVariationService {
        
        function createProductVariations ( $product, $attributesTerms ): void {
            // Generate all combinations of attribute terms
            $combinations = [ [] ];
            foreach ( $attributesTerms as $attributeId => $terms ) {
                $tmp = [];
                foreach ( $combinations as $combination ) {
                    foreach ( $terms as $term ) {
                        $tmp[] = array_merge ( $combination, [ $term ] );
                    }
                }
                $combinations = $tmp;
            }
            
            if ( count ( $combinations ) > 0 ) {
                foreach ( $combinations as $combination ) {
                    $variation = ProductVariation ::create ( [
                                                                 'product_id' => $product -> id,
                                                                 'sku'        => $this -> generateSku ( $product, $combination ),
                                                                 'price'      => $product -> price, // or any specific price logic
                                                                 'stock'      => 100 // default stock or any specific stock logic
                                                             ] );
                    
                    foreach ( $combination as $termId ) {
                        ProductVariationTerm ::create ( [
                                                            'product_variation_id' => $variation -> id,
                                                            'term_id'              => $termId
                                                        ] );
                    }
                }
            }
        }
        
        public function generateSku ( $product, $combination ) {
            // Generate SKU based on product and combination of terms
            // Example: ProductID-ColorID-SizeID-StyleID-BrandID
            $sku = $product -> id;
            foreach ( $combination as $termId ) {
                $sku .= '-' . $termId;
            }
            return $sku;
        }
        
    }
