<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class BranchRequest extends FormRequest {
        
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
            
            $branch_id = $this -> branch ? $this -> branch -> id : null;
            
            return [
                'branch-manager-id' => [
                    'required',
                    'exists:users,id',
                ],
                'country-id'        => [
                    'required',
                    'exists:countries,id'
                ],
                'code'              => [
                    'required',
                    'string',
                ],
                'name'              => [
                    'required',
                    'string',
                    'unique:branches,name,' . $branch_id
                ],
                'landline'          => [
                    'required',
                    'string',
                ],
                'mobile'            => [
                    'required',
                    'string',
                ],
                'address'           => [
                    'required',
                    'string',
                ],
            ];
        }
    }
