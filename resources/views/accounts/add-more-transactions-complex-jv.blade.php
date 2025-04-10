<div class="row">
    <div class="col-md-3 mb-1 offset-md-2">
        <div class="align-items-center d-flex gap-50">
            <div style="width: 20px; height: 20px; border: 1px solid #000; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #000;">{{ ($row + 1) }}</div>
            <label class="col-form-label font-small-4"
                   for="attribute">
                Account Head
            </label>
        </div>
        <select name="account-heads[]" class="form-control select2"
                required="required" data-placeholder="Select">
            <option></option>
            {!! $account_heads !!}
        </select>
    </div>
    
    <div class="col-md-2 mb-1">
        <label class="col-form-label font-small-4">Transaction Type</label>
        <ul class="list-unstyled d-flex pt-50 gap-2">
            <li>
                <input type="radio" name="transaction-type-{{ $row }}" value="debit"
                       required="required" id="transaction-type-{{ $row }}-debit"
                       class="float-start mt-25 me-25 other-transactions-debit"> Debit
            </li>
            <li>
                <input type="radio" name="transaction-type-{{ $row }}" id="transaction-type-{{ $row }}-credit"
                       class="float-start mt-25 me-25 other-transactions-credit" value="credit"> Credit
            </li>
        </ul>
    </div>
    
    <div class="col-md-2 mb-1">
        <label class="col-form-label font-small-4">Amount</label>
        <input type="number" class="form-control other-amounts"
               required="required" autofocus="autofocus" step="0.01"
               name="amount[]" placeholder="Amount" />
    </div>
</div>
