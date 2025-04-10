<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CourierFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> courier ? $this -> courier -> id : null;
            return [
                'title'          => [ 'required', 'string', 'unique:couriers,title,' . $id ],
                'email'          => [ 'nullable', 'email' ],
                'contact-person' => [ 'nullable', 'string' ],
                'phone'          => [ 'nullable', 'string' ],
            ];
        }
    }
