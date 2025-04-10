<?php
    
    namespace App\Http\Requests;
    
    use Illuminate\Foundation\Http\FormRequest;
    
    class AddQuickTransactionFormRequest extends FormRequest {
        
        public function authorize () {
            return true;
        }
        
        public function rules () {
            return [
                'account-head-id' => [ 'required', 'exists:account_heads,id' ],
                'bank-id'         => [ 'sometimes', 'exists:account_heads,id' ],
                'receive-date'    => [ 'required', 'date' ],
                'voucher-no'      => [ 'required' ],
                'receive-amount'  => [ 'required', 'numeric', 'min:0' ],
            ];
        }
    }
