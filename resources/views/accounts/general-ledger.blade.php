<x-dashboard :title="$title">
    @push('styles')
        <link rel="stylesheet" href="{{ asset ('/assets/chosen_v1.8.7/chosen.min.css') }}"></script>
    @endpush
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
                                    <form method="get" action="{{ route ('accounts.general-ledger') }}">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label class="mb-50">Account Head</label>
                                                <select name="account-head-id"
                                                        class="form-control chosen-select"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    {!! $account_heads !!}
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="start-date" value="{{ request ('start-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="end-date" value="{{ request ('end-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                @if(count ($ledgers) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('accounts.ledger', ['account-head-id' => request ('account-head-id'), 'start-date' => request ('start-date'), 'end-date' => request ('end-date')]) }}"
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
                                            <th>Invoice/Sale ID</th>
                                            <th>Date</th>
                                            <th>Voucher No</th>
                                            <th>Account Head</th>
                                            <th>Description</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Running Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($ledgers) > 0)
                                            <tr>
                                                <td colspan="8"></td>
                                                <td>
                                                    <strong>{{ number_format ($running_balance, 2) }}</strong>
                                                </td>
                                            </tr>
                                            
                                            @php
                                                $runningBalance = $running_balance;
                                                $netCredit = 0;
                                                $netDebit = 0;
                                            @endphp
                                            @foreach($ledgers as $ledger)
                                                @php
                                                    if ( in_array ($ledger -> account_head -> account_type -> id, config ('constants.account_type_in')) )
                                                        $runningBalance = $runningBalance + $ledger -> debit - $ledger -> credit;
                                                    else
                                                        $runningBalance = $runningBalance - $ledger -> debit + $ledger -> credit;

                                                    $netCredit += $ledger -> credit;
                                                    $netDebit += $ledger -> debit;
                                                
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>
                                                        @if($ledger -> payment_mode === 'opening-balance')
                                                            <strong>Opening Balance</strong> <br />
                                                            ID# {{ $ledger -> id }} <br />
                                                        @else
                                                            {{ $ledger -> invoice_no }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $ledger -> transaction_date }}</td>
                                                    <td>
                                                        <a href="{{ route ('accounts.search-transactions', ['voucher-no' => $ledger -> voucher_no]) }}"
                                                           target="_blank" class="text-decoration-underline">
                                                            {{ $ledger -> voucher_no }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $ledger -> account_head -> name }}</td>
                                                    <td>{{ $ledger -> description }}</td>
                                                    <td>{{ number_format ($ledger -> debit, 2) }}</td>
                                                    <td>{{ number_format ($ledger -> credit, 2) }}</td>
                                                    <td>{{ number_format ($runningBalance, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            
                                            <tr>
                                                <td colspan="6" align="right"></td>
                                                <td>
                                                    <strong>{{ number_format ($netDebit, 2) }}</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ number_format ($netCredit, 2) }}</strong>
                                                </td>
                                                <td></td>
                                            </tr>
                                            
                                            <tr>
                                                <td colspan="8" align="right">
                                                    <strong>Closing Balance</strong>
                                                </td>
                                                <td>
                                                    <strong>{{ number_format ($runningBalance, 2) }}</strong>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="9" align="center">No record found.</td>
                                            </tr>
                                        @endif
                                        </tbody>
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
    @push('scripts')
        <script type="text/javascript" src="{{ asset ('/assets/chosen_v1.8.7/chosen.jquery.min.js') }}"></script>
        <script type="text/javascript">
            $(".chosen-select").chosen();
        
        
        
        </script>
    @endpush
</x-dashboard>
