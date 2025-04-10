<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CountryRequest extends FormRequest {
        
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
            
            $country_id = $this -> country ? $this -> country -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:countries,title,' . $country_id
                ]
            ];
        }
        
        public function messages () {
            return [
                'title.unique' => 'Country name already exists.'
            ];
        }
    }
