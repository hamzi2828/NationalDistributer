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
                                    <form method="get" action="{{ route ('customer-receivable-report') }}">
                                        <div class="row">
                                            <div class="form-group col-md-2 mb-1">
                                                <label class="mb-25">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="start-date" value="{{ request ('start-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <label class="mb-25">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="end-date" value="{{ request ('end-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">User</label>
                                                <select name="user-id" class="form-control select2"
                                                        data-placeholder="Select" data-allow-clear="true">
                                                    <option></option>
                                                    @if(count ($users) > 0)
                                                        @foreach($users as $user)
                                                            <option value="{{ $user -> id }}" @selected($user -> id == request ('user-id', 0))>
                                                                {{ $user -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
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
                                            <a href="{{ route ('customer-receivable', request () -> all ()) }}"
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
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $net_debit = 0;
                                            $net_credit = 0;
                                            $netRB = 0;
                                            $netOB = 0;
                                        @endphp
                                        @if(count ($account_heads) > 0)
                                            @foreach($account_heads as $account_head)
                                                @php
                                                    $net_debit += $account_head -> totalDebit;
                                                    $net_credit += $account_head -> totalCredit;
                                                    $opening_balance = (new \App\Http\Services\GeneralLedgerService()) -> get_opening_balance_previous_than_searched_start_date(request ('start-date'), $account_head -> id);
                                                    $running_balance = (new \App\Http\Services\GeneralLedgerService()) -> calculate_running_balance($opening_balance, $account_head -> totalCredit, $account_head -> totalDebit, $account_head);
                                                    $netRB += $running_balance;
                                                    $netOB += $opening_balance;
                                                @endphp
                                                
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $account_head -> name }}</td>
                                                    <td>{{ number_format ($opening_balance, 2) }}</td>
                                                    <td>{{ number_format ($account_head -> totalDebit, 2) }}</td>
                                                    <td>{{ number_format ($account_head -> totalCredit, 2) }}</td>
                                                    <td>{{ number_format ($running_balance, 2) }}</td>
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