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
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post"
                                      action="{{ route ('accounts.process-add-transactions-quick') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="account-head">Customer</label>
                                            <div class="col-md-3">
                                                <select name="account-head-id" class="form-control select2"
                                                        required="required" id="account-head"
                                                        onchange="get_account_head_running_balance(this.value, '{{ route ('accounts.get-account-head-running-balance') }}')"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    {!! $account_heads !!}
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="due-amount">Due Amount</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" readonly="readonly"
                                                       id="due-amount" value="{{ request ('due-amount') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="receive-date">Receive Date</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control flatpickr-basic"
                                                       id="receive-date"
                                                       data-date-format="d-m-Y"
                                                       name="receive-date"
                                                       value="{{ request ('receive-date', date ('d-m-Y')) }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="voucher-no">Payment Mode</label>
                                            <div class="col-md-3">
                                                <select name="voucher-no" class="form-control chosen-select"
                                                        id="voucher-no"
                                                        onchange="getBanks(this.value, '{{ route ('accounts.get-banks') }}')"
                                                        required="required" data-placeholder="Select">
                                                    <option></option>
                                                    <option value="crv" @selected(old ('voucher-no') === 'crv')>
                                                        Cash
                                                    </option>
                                                    <option value="brv" @selected(old ('voucher-no') === 'brv')>
                                                        Bank
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1 d-none" id="banks">
                                            <label class="col-md-2 pt-50"
                                                   for="bank-id">Bank</label>
                                            <div class="col-md-3">
                                                <select name="bank-id" class="form-control chosen-select"
                                                        id="bank-id" data-placeholder="Select">
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="receive-amount">Receive Amount</label>
                                            <div class="col-md-3">
                                                <input type="number" min="0" class="form-control" name="receive-amount"
                                                       required="required" step="any"
                                                       id="receive-amount" value="{{ request ('receive-amount') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="reference-id">Reference ID</label>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control" name="reference-id"
                                                       id="reference-id" value="{{ request ('reference-id') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-1">
                                            <label class="col-md-2 pt-50"
                                                   for="description">Description</label>
                                            <div class="col-md-3">
                                                <textarea name="description" class="form-control" id="description"
                                                          rows="3">{{ old ('description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
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
