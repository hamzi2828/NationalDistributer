<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class ProductRequest extends FormRequest {
        
        /**
         * Determine if the user is authorized to make this request.
         * @return bool
         */
        
        public function authorize () {
            return true;
        }
        
        /**
         * Get the validation rules that apply to the request.
         * @return array<string, mixed>
         */
        
        public function rules () {
            $product_id = $this -> product ? $this -> product -> id : null;
            
            return [
                'title'           => [
                    'required',
                    'string',
                    'min:2'
                ],
                'category-id'     => [
                    'required',
                    'exists:categories,id'
                ],
                'manufacturer-id' => [
                    'required',
                    'exists:manufacturers,id'
                ],
                'term-id'         => [
                    'sometimes',
                    'required',
                    'exists:terms,id'
                ],
                'sku'             => [
                    'required',
                    'string',
                    'unique:products,sku,' . $product_id
                ],
                'barcode'         => [
                    'required',
                    'string',
                    'unique:products,barcode,' . $product_id
                ],
                'threshold'       => [
                    'required',
                    'string',
                ],
                'tp-box'          => [
                    'required',
                    'numeric',
                ],
                'pack-size'       => [
                    'required',
                    'numeric',
                ],
                'tp-unit'         => [
                    'required',
                    'numeric',
                ],
                'sale-box'        => [
                    'required',
                    'numeric',
                ],
                'sale-unit'       => [
                    'required',
                    'numeric',
                ],
            ];
        }
    }
