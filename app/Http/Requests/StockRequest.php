<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class StockRequest extends FormRequest {
        
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
            $stock = $this -> stock ? $this -> stock -> id : null;
            
            return [
                'vendor-id'   => [
                    'sometimes',
                    'numeric',
                    'exists:vendors,id'
                ],
                'customer-id' => [
                    'sometimes',
                    'numeric',
                    'exists:customers,id'
                ],
                'invoice-no'  => [
                    'required',
                    'string',
                    'unique:stocks,invoice_no,' . $stock
                ],
                'stock-date'  => [
                    'required',
                    'date',
                ]
            ];
        }
    }
