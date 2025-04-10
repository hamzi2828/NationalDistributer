<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class SaleRequest extends FormRequest {
        
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
            return [
                'customer_id'         => [
                    'required',
                    'numeric',
                    'exists:customers,id'
                ],
                'percentage-discount' => [
                    'sometimes',
                    'numeric',
                    'min:0',
                    'max:100'
                ],
                'flat-discount'       => [
                    'sometimes',
                    'numeric'
                ],
                'paid-amount'         => [
                    'required',
                    'numeric',
                    'min:0',
                ]
            ];
        }
    }
