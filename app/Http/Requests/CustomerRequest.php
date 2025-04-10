<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CustomerRequest extends FormRequest {
        
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
            $customer_id = $this -> customer ? $this -> customer -> id : null;
            
            return [
                'name'  => [
                    'required',
                    'string',
                    'min:3'
                ],
                'email' => [
                    'nullable',
                    'email',
                    'unique:customers,email,' . $customer_id
                ],
            ];
        }
    }
