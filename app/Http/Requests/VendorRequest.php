<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class VendorRequest extends FormRequest {
        
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
            
            $vendor = $this -> vendor ? $this -> vendor -> id : null;
            
            return [
                'name' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:vendors,name,' . $vendor
                ]
            ];
        }
    }
