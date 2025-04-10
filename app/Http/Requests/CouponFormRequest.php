<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class CouponFormRequest extends FormRequest {
        
        public function authorize (): bool {
            return true;
        }
        
        public function rules (): array {
            $id = $this -> coupon ? $this -> coupon -> id : null;
            return [
                'title'      => [ 'required', 'string' ],
                'code'       => [ 'required', 'string', 'unique:coupons,code,' . $id ],
                'discount'   => [ 'required', 'between:0,100' ],
                'start-date' => [ 'required', 'date' ],
                'end-date'   => [ 'required', 'date' ],
            ];
        }
    }
