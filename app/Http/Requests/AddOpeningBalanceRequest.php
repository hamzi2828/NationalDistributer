<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AddOpeningBalanceRequest extends FormRequest {
        
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
                'account-head-id'  => [
                    'required',
                    'exists:account_heads,id'
                ],
                'transaction-type' => [
                    'required'
                ],
                'amount'           => [
                    'required',
                    'numeric',
                    'min:0'
                ],
                'transaction-date' => [
                    'required',
                    'date'
                ],
            ];
        }
    }
