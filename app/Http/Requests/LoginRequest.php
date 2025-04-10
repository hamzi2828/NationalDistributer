<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class LoginRequest extends FormRequest {
        
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
            return [
                'login-email'    => [
                    'required',
                    'email',
                    'exists:users,email'
                ],
                'login-password' => [
                    'required',
                    'string',
                    'min:3',
                ]
            ];
        }
        
        public function messages () {
            return [
                'login-email.exists' => 'Email does not exists.',
                'login-password.min' => 'Password should be atleast 3 characters long.',
            ];
        }
    }
