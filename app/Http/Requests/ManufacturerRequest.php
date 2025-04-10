<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class ManufacturerRequest extends FormRequest {
        
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
            
            $manufacturer_id = $this -> manufacturer ? $this -> manufacturer -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                    'unique:manufacturers,title,' . $manufacturer_id
                ]
            ];
        }
        
        public function messages () {
            return [
                'title.unique' => 'Manufacturer already exists.'
            ];
        }
    }
