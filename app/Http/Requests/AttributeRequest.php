<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AttributeRequest extends FormRequest {
        
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
            
            $attribute_id = $this -> attribute ? $this -> attribute -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:attributes,title,' . $attribute_id
                ]
            ];
        }
        
        public function messages () {
            return [
                'title.unique' => 'Attribute name already exists.'
            ];
        }
    }
