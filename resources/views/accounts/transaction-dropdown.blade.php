@if($account -> account_head_id == config ('constants.customers'))
    <div class="row">
        <div class="col-md-7 offset-md-2  mb-1">
            <label class="col-form-label font-small-4" for="sales">Sale Invoices</label>
            <select name="sales[]" class="form-control select2" id="sales" multiple="multiple"
                    data-placeholder="Select">
                <option></option>
                @if(count ($sales) > 0)
                    @foreach($sales as $sale)
                        <option value="{{ $sale -> id }}">{{ $sale -> id }}</option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
@endif

@if($account -> account_head_id == config ('constants.vendors'))
    <div class="row">
        <div class="col-md-7 offset-md-2  mb-1">
            <label class="col-form-label font-small-4" for="stocks">Stock Invoices</label>
            <select name="stocks[]" class="form-control select2" id="stocks" multiple="multiple"
                    data-placeholder="Select">
                <option></option>
                @if(count ($stocks) > 0)
                    @foreach($stocks as $stock)
                        <option value="{{ $stock -> id }}">
                            {{ $stock -> id . ' ('.$stock -> invoice_no.')' }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
    </div>
@endif