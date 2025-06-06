<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class RoleRequest extends FormRequest {
        
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
            
            $role_id = $this -> role ? $this -> role -> id : null;
            
            return [
                'title' => [
                    'required',
                    'string',
                    'unique:roles,title,' . $role_id
                ]
            ];
        }
    }
