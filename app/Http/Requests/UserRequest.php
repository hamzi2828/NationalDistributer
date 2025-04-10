<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class UserRequest extends FormRequest {
        
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
            
            $user_id = $this -> user ? $this -> user -> id : null;
            
            return [
                'country-id'  => [
                    'required',
                    'exists:countries,id'
                ],
                'branch-id'   => [
                    'required',
                    'exists:branches,id'
                ],
                'name'        => [
                    'required',
                    'string',
                    'min:3'
                ],
                'email'       => [
                    'required',
                    'email',
                    'unique:users,email,' . $user_id,
                    'string',
                    'min:3'
                ],
                'mobile'      => [
                    'nullable',
                    'string',
                    'min:10',
                    'max:15',
                ],
                'identity-no' => [
                    'nullable',
                    'string',
                ],
                'gender'      => [
                    'required',
                    'string',
                ],
                'dob'         => [
                    'required',
                    'date',
                ],
                'avatar'      => [
                    'nullable',
                    'image',
                ],
                'address'     => [
                    'nullable',
                    'string',
                ],
            ];
        }
    }
