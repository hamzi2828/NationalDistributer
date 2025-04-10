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
                                    <form method="get" action="{{ route ('accounts.search-transactions') }}">
                                        <div class="row border-bottom mb-2">
                                            <div class="form-group offset-md-2 col-md-3 mb-1">
                                                <label class="mb-25" for="voucher-no">Voucher</label>
                                                <input type="text" class="form-control" id="voucher-no"
                                                       autofocus="autofocus"
                                                       name="voucher-no" value="{{ request ('voucher-no') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="transaction-id">Transaction ID</label>
                                                <input type="text" class="form-control" id="transaction-id"
                                                       autofocus="autofocus"
                                                       name="transaction-id" value="{{ request ('transaction-id') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    @php $ledgersArray = []; @endphp
                                    @if(count($ledgers) > 0)
                                        @php
                                            $voucher = explode ('-', request ('voucher-no'));
                                            $voucher = $voucher[0];
                                        @endphp
                                        <form class="form" method="post"
                                              action="{{ route ('accounts.update-transactions') }}">
                                            @csrf
                                            
                                            <div class="row">
                                                <div class="form-group col-md-3 mb-1 offset-md-2">
                                                    <label class="mb-25">
                                                        Transaction Date
                                                    </label>
                                                    <input type="text" class="form-control flatpickr-basic"
                                                           required="required" data-date-format="d-m-Y"
                                                           name="transaction-date" placeholder="Transaction Date"
                                                           value="{{ date('d-m-Y', strtotime ($ledgers[0] -> transaction_date)) }}" />
                                                </div>
                                                
                                                <div class="form-group col-md-3 mb-1">
                                                    <label class="mb-25" for="payment-mode">
                                                        Payment Mode
                                                    </label>
                                                    <select name="payment-mode" class="form-control select2"
                                                            id="payment-mode"
                                                            required="required" data-placeholder="Select">
                                                        <option></option>
                                                        <option value="cash" @selected(old ('payment-mode', $ledgers[0] -> payment_mode) === 'cash')>
                                                            Cash
                                                        </option>
                                                        <option value="cheque" @selected(old ('payment-mode', $ledgers[0] -> payment_mode) === 'cheque')>
                                                            Cheque
                                                        </option>
                                                        <option value="online" @selected(old ('payment-mode', $ledgers[0] -> payment_mode) === 'online')>
                                                            Online
                                                        </option>
                                                    </select>
                                                    <input type="text" name="transaction-no" id="transaction-no"
                                                           class="form-control {{ empty(trim ($ledgers[0] -> transaction_no)) ? 'd-none' : '' }} mt-50"
                                                           placeholder="Cheque/Transaction No"
                                                           value="{{ old ('transaction-no', $ledgers[0] -> transaction_no) }}">
                                                </div>
                                            
                                            </div>
                                            
                                            @foreach($ledgers as $ledger)
                                                @php array_push ($ledgersArray, $ledger -> id) @endphp
                                                <input type="hidden" name="ledger-id[]" value="{{ $ledger -> id }}">
                                                
                                                @if(count ($ledgers) > 2 && $loop -> iteration == 1)
                                                    <div class="row">
                                                        <div class="col-md-7 offset-md-2">
                                                            <h3 class="fw-bolder border-bottom">First Transaction</h3>
                                                        </div>
                                                    </div>
                                                @elseif(count ($ledgers) > 2 && $loop -> iteration == 2)
                                                    <div class="row">
                                                        <div class="col-md-7 offset-md-2">
                                                            <h3 class="fw-bolder border-bottom">Other Transactions</h3>
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                <div class="row">
                                                    <div class="col-md-3 mb-1 offset-md-2">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <label class="col-form-label font-small-4"
                                                                   for="attribute">Account Head</label>
                                                        </div>
                                                        <input type="text" class="form-control" readonly="readonly"
                                                               value="{{ $ledger -> account_head -> name }}">
                                                        @if(count ($ledger -> transaction_details) > 0)
                                                            <a href="{{ route ('accounts.transaction-detail', ['general_ledger' => $ledger -> id]) }}"
                                                               class="btn btn-primary btn-sm mt-25" target="_blank">
                                                                Edit Attached Invoices
                                                            </a>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="col-md-2 mb-1">
                                                        <label class="col-form-label font-small-4">
                                                            Transaction Type
                                                        </label>
                                                        <ul class="list-unstyled d-flex pt-50 gap-2">
                                                            <li>
                                                                <input type="radio"
                                                                       name="transaction-type-{{ $ledger -> id }}"
                                                                       value="debit" required="required"
                                                                       @checked($ledger -> debit > 0)
                                                                       @if($loop -> iteration == 1 && in_array (strtolower ($voucher), ['crv', 'brv']))
                                                                       @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['jv']))
                                                                           onclick="toggleJVTransactions(this.value, '{{ strtolower ($voucher) }}')"
                                                                       @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['cpv', 'bpv']))
                                                                           disabled="disabled"
                                                                       @elseif(in_array (strtolower ($voucher), ['crv', 'brv']))
                                                                           disabled="disabled"
                                                                       @endif
                                                                       class="float-start mt-25 me-25 @if($loop -> iteration > 1) other-transactions-debit @endif">
                                                                Debit
                                                            </li>
                                                            <li>
                                                                <input type="radio"
                                                                       name="transaction-type-{{ $ledger -> id }}"
                                                                       class="float-start mt-25 me-25 @if($loop -> iteration > 1) other-transactions-credit @endif"
                                                                       @checked($ledger -> credit > 0)
                                                                       @if($loop -> iteration == 1 && in_array (strtolower ($voucher), ['crv', 'brv']))
                                                                           disabled="disabled"
                                                                       @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['jv']))
                                                                           onclick="toggleJVTransactions(this.value, '{{ strtolower ($voucher) }}')"
                                                                       @elseif($loop -> iteration == 1 && in_array (strtolower ($voucher), ['cpv', 'bpv']))
                                                                       @elseif(in_array (strtolower ($voucher), ['cpv', 'bpv']))
                                                                           disabled="disabled"
                                                                       @endif
                                                                       value="credit"> Credit
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    
                                                    <div class="col-md-2 mb-1">
                                                        <label class="col-form-label font-small-4">Amount</label>
                                                        <input type="number" step="any"
                                                               class="form-control amount @if(count ($ledgers) > 2 && $loop -> iteration == 1) first-transaction initial-amount @elseif(count ($ledgers) > 2 && $loop -> iteration > 1) other-amounts @endif"
                                                               required="required" autofocus="autofocus"
                                                               name="amount[]" placeholder="Amount"
                                                               {{--                                                               @if(in_array ($voucher, ['crv', 'brv', 'cpv', 'bpv']))--}}
                                                               @if(count ($ledgers) == 2)
                                                                   onchange="setTransactionPrice(this.value)"
                                                               @endif
                                                               value="{{ ($ledger -> credit + $ledger -> debit) }}" />
                                                    </div>
                                                </div>
                                            @endforeach
                                            
                                            <div class="row">
                                                <div class="col-md-7 offset-md-2">
                                                    <label class="col-form-label font-small-4">Description</label>
                                                    <textarea name="description" class="form-control"
                                                              rows="5">{{ old ('description', $ledgers[0] -> description) }}</textarea>
                                                </div>
                                            </div>
                                            
                                            <hr />
                                            
                                            <button type="submit" class="btn btn-primary me-50 offset-md-2"
                                                    @if(count ($ledgers) > 2) id="multiple-transactions-btn" @endif>
                                                Submit
                                            </button>
                                            <a href="{{ route ('transaction', ['voucher-no' => request ('voucher-no')]) }}"
                                               target="_blank" class="btn btn-dark me-50"> Print </a>
                                            
                                            @can('delete_transactions', \App\Models\Account::class)
                                                <a href="{{ route ('accounts.delete-transactions', ['ledgers' => $ledgersArray]) }}"
                                                   onclick="return confirm('Are you sure?')"
                                                   class="btn btn-danger me-50"> Delete </a>
                                            @endcan
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