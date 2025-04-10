<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class TermRequest extends FormRequest {
        
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
                'attribute-id' => [
                    'required',
                    'numeric',
                    'min:1',
                    'exists:attributes,id'
                ]
            ];
        }
        
        public function messages () {
            return [
                'title.unique' => 'Country name already exists.'
            ];
        }
    }
