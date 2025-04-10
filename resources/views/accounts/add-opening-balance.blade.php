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
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post"
                                      action="{{ route ('accounts.process-add-opening-balance') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="attribute">Account Head</label>
                                                <select name="account-head-id" class="form-control chosen-select"
                                                        required="required"
                                                        onchange="get_account_head_type(this.value, 'transaction-type')"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    {!! $account_heads !!}
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Transaction Type</label>
                                                <ul class="list-unstyled d-flex pt-50 gap-2">
                                                    <li>
                                                        <input type="radio" name="transaction-type" value="debit"
                                                               required="required" id="transaction-type-debit"
                                                               class="float-start mt-25 me-25" @checked(old ('transaction-type') === 'debit')>
                                                        Debit
                                                    </li>
                                                    <li>
                                                        <input type="radio" name="transaction-type"
                                                               class="float-start mt-25 me-25"
                                                               id="transaction-type-credit"
                                                               value="credit" @checked(old ('transaction-type') === 'credit')>
                                                        Credit
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4">Amount</label>
                                                <input type="number" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="amount" placeholder="Amount"
                                                       value="{{ old ('amount') }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Transaction Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="transaction-date" placeholder="Transaction Date"
                                                       value="{{ old ('transaction-date', date('Y-m-d')) }}" />
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="col-form-label font-small-4"
                                                       for="description">Description</label>
                                                <textarea name="description" class="form-control" id="description"
                                                          rows="5">{{ old ('description') }}</textarea>
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