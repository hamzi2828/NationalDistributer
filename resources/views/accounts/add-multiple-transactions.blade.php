<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen_v1.8.7/chosen.min.css') }}"></script>
    @endpush
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            
                            @if(session () -> has ('message'))
                                <div class="alert alert-success" role="alert">
                                    <h4 class="alert-heading">Success!</h4>
                                    <div class="alert-body">
                                        {!! session ('message') !!}
                                    </div>
                                </div>
                            @endif
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title offset-md-2">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post"
                                      action="{{ route ('accounts.process-add-multiple-transactions') }}">
                                    @csrf
                                    
                                    <input type="hidden" id="rows" value="0">
                                    
                                    <div class="card-body pt-0">
                                        
                                        <div class="row border-bottom mb-2">
                                            <div class="offset-md-2 col-md-3 mb-1">
                                                <label class="col-form-label font-small-4" for="voucher">
                                                    Voucher
                                                </label>
                                                <select name="voucher-no" class="form-control select2" id="voucher"
                                                        onchange="toggleMultipleTransactions(this.value, '{{ route ('accounts.account-heads-dropdown') }}')"
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
                                                    <option value="cpv" @selected(old ('voucher-no') === 'cpv')>
                                                        CPV
                                                    </option>
                                                    <option value="crv" @selected(old ('voucher-no') === 'crv')>
                                                        CRV
                                                    </option>
                                                    <option value="bpv" @selected(old ('voucher-no') === 'bpv')>
                                                        BPV
                                                    </option>
                                                    <option value="brv" @selected(old ('voucher-no') === 'brv')>
                                                        BRV
                                                    </option>
                                                    <option value="jv" @selected(old ('voucher-no') === 'jv')>
                                                        JV
                                                    </option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4">Transaction Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       data-date-format="d-m-Y"
                                                       value="{{ old ('transaction-date', date ('d-m-Y')) }}"
                                                       name="transaction-date" placeholder="Transaction Date" />
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4" for="payment-mode">
                                                    Payment Mode
                                                </label>
                                                <select name="payment-mode" class="form-control select2"
                                                        id="payment-mode"
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
                                                    <option value="cash" @selected(old ('payment-mode') === 'cash')>
                                                        Cash
                                                    </option>
                                                    <option value="cheque" @selected(old ('payment-mode') === 'cheque')>
                                                        Cheque
                                                    </option>
                                                    <option value="online" @selected(old ('payment-mode') === 'online')>
                                                        Online
                                                    </option>
                                                </select>
                                                <input type="text" name="transaction-no" id="transaction-no"
                                                       class="form-control d-none mt-50"
                                                       placeholder="Cheque/Transaction No">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-7 offset-md-2">
                                                <h3 class="fw-bolder border-bottom">First Transaction</h3>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3 mb-1 offset-md-2">
                                                <label class="col-form-label font-small-4"
                                                       for="first-account-head">Account Head</label>
                                                <select name="account-heads[]" class="form-control select2"
                                                        required="required" data-placeholder="Select"
                                                        id="first-account-head"
                                                        onchange="get_account_head_type(this.value, 'transaction-type-0')">
                                                    <option></option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4">Transaction Type</label>
                                                <ul class="list-unstyled d-flex pt-50 gap-2">
                                                    <li>
                                                        <input type="radio" name="transaction-type-0"
                                                               id="transaction-type-debit" value="debit"
                                                               required="required" onclick="toggleJVTransactions(this.value)"
                                                               class="float-start mt-25 me-25"> Debit
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="transaction-type-0"
                                                               id="transaction-type-credit" onclick="toggleJVTransactions(this.value)"
                                                               class="float-start mt-25 me-25" value="credit"> Credit
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4">Amount</label>
                                                <input type="number" class="form-control initial-amount"
                                                       required="required" autofocus="autofocus" step="any"
                                                       name="amount[]" placeholder="Amount" />
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-7 offset-md-2">
                                                <h3 class="fw-bolder border-bottom">Other Transactions</h3>
                                            </div>
                                        </div>
                                        
                                        <div id="add-more-transactions"></div>
                                        
                                        <div class="row">
                                            <div class="col-md-7 offset-md-2">
                                                <label class="col-form-label font-small-4">Description</label>
                                                <textarea name="description" class="form-control"
                                                          rows="5">{{ old ('description') }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="offset-md-6 col-md-3 mt-2 mb-25">
                                                <label class="col-form-label font-small-4">First Transaction</label>
                                                <input type="number" class="form-control first-transaction"
                                                       readonly="readonly">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="offset-md-6 col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Other Transactions</label>
                                                <input type="number" class="form-control other-transactions"
                                                       readonly="readonly">
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-50 offset-md-2" disabled="disabled"
                                                id="multiple-transactions-btn">
                                            Submit
                                        </button>
                                        <a href="javascript:void(0)"
                                           onclick="addMoreTransactions('{{ route ('accounts.account-heads-dropdown') }}')"
                                           class="btn btn-dark me-1">Add More</a>
                                    </div>
                                </form>
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
