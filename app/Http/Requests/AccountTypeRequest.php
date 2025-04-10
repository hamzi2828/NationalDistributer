<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AccountTypeRequest extends FormRequest {
        
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
            $account_type = $this -> account_type ? $this -> account_type -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'unique:account_types,title,' . $account_type
                ]
            ];
        }
    }
