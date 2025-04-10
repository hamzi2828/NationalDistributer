<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AccountRequest extends FormRequest {
        
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
            
            $account = $this -> account ? $this -> account -> id : null;
            
            return [
                'account-head-id' => [
                    'nullable',
                    'numeric',
                    'exists:account_heads,id'
                ],
                'account-type-id' => [
                    'nullable',
                    'numeric',
                    'exists:account_types,id'
                ],
                'name'            => [
                    'required',
                    'string',
                    'unique:account_heads,name,' . $account
                ],
                'phone'           => [
                    'nullable',
                    'string',
                    'max:20'
                ],
                ''
            ];
        }
    }
