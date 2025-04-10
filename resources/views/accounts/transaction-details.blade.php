<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title offset-md-2">{{ $title }}</h4>
                                </div>
                                <div class="card-body pt-0">
                                    @if($general_ledger && count($general_ledger -> transaction_details) > 0)
                                        <form class="form" method="post"
                                              action="{{ route ('accounts.transaction-detail', ['general_ledger' => $general_ledger -> id]) }}">
                                            @csrf
                                            
                                            <div class="row">
                                                <div class="form-group col-md-3 mb-1 offset-md-2">
                                                    <label class="mb-25" for="transaction-date">
                                                        Transaction Date
                                                    </label>
                                                    <input type="text" class="form-control flatpickr-basic"
                                                           required="required" data-date-format="d-m-Y"
                                                           id="transaction-date" disabled="disabled"
                                                           name="transaction-date" placeholder="Transaction Date"
                                                           value="{{ date('d-m-Y', strtotime ($general_ledger -> transaction_date)) }}" />
                                                </div>
                                                
                                                <div class="form-group col-md-3 mb-1">
                                                    <label class="mb-25" for="payment-mode">
                                                        Payment Mode
                                                    </label>
                                                    <select name="payment-mode" class="form-control select2"
                                                            id="payment-mode" disabled="disabled"
                                                            required="required" data-placeholder="Select">
                                                        <option></option>
                                                        <option value="cash" @selected(old ('payment-mode', $general_ledger -> payment_mode) === 'cash')>
                                                            Cash
                                                        </option>
                                                        <option value="cheque" @selected(old ('payment-mode', $general_ledger -> payment_mode) === 'cheque')>
                                                            Cheque
                                                        </option>
                                                        <option value="online" @selected(old ('payment-mode', $general_ledger -> payment_mode) === 'online')>
                                                            Online
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-3 mb-1 offset-md-2">
                                                    <label class="col-form-label font-small-4"
                                                           for="account-head">Account Head</label>
                                                    <input type="text" class="form-control" readonly="readonly"
                                                           id="account-head"
                                                           value="{{ $general_ledger -> account_head -> name }}">
                                                </div>
                                                
                                                <div class="col-md-2 mb-1">
                                                    <label class="col-form-label font-small-4">
                                                        Transaction Type
                                                    </label>
                                                    <ul class="list-unstyled d-flex pt-50 gap-2">
                                                        <li>
                                                            <input type="radio"
                                                                   name="transaction-type-debit" id="debit"
                                                                   value="debit" required="required"
                                                                   @checked($general_ledger -> debit > 0)
                                                                   {{ $general_ledger -> credit > 0 ? 'disabled="disabled"' : '' }}
                                                                   class="float-start mt-25 me-25">
                                                            <label for="debit">Debit</label>
                                                        </li>
                                                        <li>
                                                            <input type="radio"
                                                                   name="transaction-type-credit" id="credit"
                                                                   class="float-start mt-25 me-25"
                                                                   @checked($general_ledger -> credit > 0)
                                                                   {{ $general_ledger -> debit > 0 ? 'disabled="disabled"' : '' }}
                                                                   value="credit">
                                                            <label for="credit">Credit</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                                
                                                <div class="col-md-2 mb-1">
                                                    <label class="col-form-label font-small-4" for="amount">
                                                        Amount
                                                    </label>
                                                    <input type="number" id="amount"
                                                           class="form-control"
                                                           required="required" autofocus="autofocus"
                                                           placeholder="Amount" readonly="readonly"
                                                           value="{{ ($general_ledger -> credit + $general_ledger -> debit) }}" />
                                                </div>
                                            </div>
                                            
                                            @if(in_array ('crv', $vouchers) || in_array ('brv', $vouchers))
                                                <div class="row">
                                                    <div class="col-md-7 offset-md-2  mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="sales">Sales</label>
                                                        <select name="sales[]" class="form-control select2" id="sales"
                                                                multiple="multiple"
                                                                data-placeholder="Select">
                                                            <option></option>
                                                            @if(count ($sales) > 0)
                                                                @foreach($sales as $sale)
                                                                    <option value="{{ $sale -> id }}">{{ $sale -> id }}</option>
                                                                @endforeach
                                                            @endif
                                                            @if(count ($general_ledger -> transaction_details) > 0)
                                                                @foreach($general_ledger -> transaction_details as $transaction_detail)
                                                                    <option value="{{ $transaction_detail -> sale_id }}"
                                                                            selected="selected">
                                                                        {{ $transaction_detail -> sale_id }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @elseif(in_array ('cpv', $vouchers) || in_array ('bpv', $vouchers))
                                                <div class="row">
                                                    <div class="col-md-7 offset-md-2  mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="stocks">Stocks</label>
                                                        <select name="stocks[]" class="form-control select2" id="stocks"
                                                                multiple="multiple"
                                                                data-placeholder="Select">
                                                            <option></option>
                                                            @if(count ($stocks) > 0)
                                                                @foreach($stocks as $stock)
                                                                    <option value="{{ $stock -> id }}">
                                                                        {{ $stock -> id . ' ('.$stock -> invoice_no.')' }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                            @if(count ($general_ledger -> transaction_details) > 0)
                                                                @foreach($general_ledger -> transaction_details as $transaction_detail)
                                                                    <option value="{{ $transaction_detail -> stock_id }}"
                                                                            selected="selected">
                                                                        {{ $transaction_detail -> stock_id }} -
                                                                        {{ \App\Models\Stock::find($transaction_detail -> stock_id) -> invoice_no }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            <hr />
                                            <button type="submit" class="btn btn-primary me-50 offset-md-2">
                                                Submit
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript" src="{{ asset ('/assets/chosen_v1.8.7/chosen.jquery.min.js') }}"></script>
        <script type="text/javascript">
            $ ( ".chosen-select" ).chosen ();
        </script>
    @endpush
</x-dashboard>