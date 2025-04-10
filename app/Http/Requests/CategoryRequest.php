<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CategoryRequest extends FormRequest {
        
        public function authorize () {
            return true;
        }
        
        public function rules () {
            
            $category_id = $this -> category ? $this -> category -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'min:3',
                ]
            ];
        }
        
        public function messages () {
            return [
                'title.unique' => 'Category already exists.'
            ];
        }
    }
