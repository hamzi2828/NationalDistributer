<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <form method="get" action="{{ route ('customer-ageing-report') }}">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="start-date">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="start-date"
                                                       name="start-date" value="{{ request ('start-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="end-date">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="end-date"
                                                       name="end-date" value="{{ request ('end-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3">
                                                <label class="mb-25" for="branch-id">Branch</label>
                                                <select name="branch-id" id="branch-id"
                                                        class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch -> id }}" @selected(request ('branch-id') == $branch -> id)>
                                                                {{ $branch -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                @if(count ($account_heads) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('customer-ageing-invoice', request () -> all ()) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Account Head</th>
                                            <th>Opening Balance</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Balance</th>
                                            <th>Last Payment</th>
                                            <th>2nd Last Payment</th>
                                            <th>3rd Last Payment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $net_debit  = 0;
                                            $net_credit = 0;
                                            $netRB      = 0;
                                            $netOB      = 0;
                                        @endphp
                                        @if(count ($account_heads) > 0)
                                            @foreach($account_heads as $account_head)
                                                @php
                                                    $net_debit          += $account_head -> totalDebit;
                                                    $net_credit         += $account_head -> totalCredit;
                                                    $opening_balance    = (new \App\Http\Services\GeneralLedgerService()) -> get_opening_balance_previous_than_searched_start_date(request ('start-date'), $account_head -> id);
                                                    $running_balance    = (new \App\Http\Services\GeneralLedgerService()) -> calculate_running_balance($opening_balance, $account_head -> totalCredit, $account_head -> totalDebit, $account_head);
                                                    $lastPayments       = (new \App\Http\Services\GeneralLedgerService()) -> get_account_head_last_payments($account_head -> id, 3);
                                                    $netRB              += $running_balance;
                                                    $netOB              += $opening_balance;
                                                @endphp
                                                
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $account_head -> name }}</td>
                                                    <td>{{ number_format ($opening_balance, 2) }}</td>
                                                    <td>{{ number_format ($account_head -> totalDebit, 2) }}</td>
                                                    <td>{{ number_format ($account_head -> totalCredit, 2) }}</td>
                                                    <td>{{ number_format ($running_balance, 2) }}</td>
                                                    @if(count ($lastPayments) > 0)
                                                        @foreach($lastPayments as $lastPayment)
                                                            <td>
                                                                {{ number_format ($lastPayment -> credit, 2) }}
                                                                @if(!empty(trim ($lastPayment -> transaction_date)))
                                                                    <br />
                                                                    <small>
                                                                        {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($lastPayment -> transaction_date) }}
                                                                    </small>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                            <td>
                                                <strong>{{ number_format ($netOB, 2) }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ number_format ($net_debit, 2) }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ number_format ($net_credit, 2) }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ number_format (($netOB + $net_debit - $net_credit), 2) }}</strong>
                                            </td>
                                            <td colspan="3"></td>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
</x-dashboard>