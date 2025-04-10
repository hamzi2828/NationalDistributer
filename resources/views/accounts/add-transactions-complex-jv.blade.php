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
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
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
                                            
                                            <div class="col-md-2 mb-1 d-none">
                                                <label class="col-form-label font-small-4" for="payment-mode">
                                                    Payment Mode
                                                </label>
                                                <select name="payment-mode" class="form-control select2"
                                                        id="payment-mode"
                                                        required="required" data-placeholder="Select">
                                                    <option value="cash" selected="selected">Cash</option>
                                                </select>
                                                <input type="text" name="transaction-no" id="transaction-no"
                                                       class="form-control d-none mt-50"
                                                       placeholder="Cheque/Transaction No">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-3 mb-1 offset-md-2">
                                                <div class="align-items-center d-flex gap-50">
                                                    <div style="width: 20px; height: 20px; border: 1px solid #000; border-radius: 50%; display: flex; justify-content: center; align-items: center; color: #000;">1</div>
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
                                                        <input type="radio" name="transaction-type-0" value="debit"
                                                               required="required" id="transaction-type-0-debit"
                                                               class="float-start mt-25 me-25 other-transactions-debit"> Debit
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="transaction-type-0" id="transaction-type-0-credit"
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
                                        
                                        <div id="add-more-transactions"></div>
                                        
                                        <div class="row">
                                            <div class="col-md-7 offset-md-2">
                                                <label class="col-form-label font-small-4">Description</label>
                                                <textarea name="description" class="form-control"
                                                          rows="5">{{ old ('description') }}</textarea>
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-50 offset-md-2">
                                            Submit
                                        </button>
                                        <a href="javascript:void(0)"
                                           onclick="addMoreComplexTransactions('{{ route ('accounts.add-more-transactions-complex-jv') }}')"
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
