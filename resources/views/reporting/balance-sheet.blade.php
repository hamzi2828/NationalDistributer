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
                                    <form method="get" action="{{ route ('balance-sheet') }}">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-1 offset-md-2">
                                                <label class="mb-25" for="start-date">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="start-date"
                                                       name="start-date" value="{{ request ('start-date') }}">
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
                                
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <a href="{{ route ('balance-sheet-report', request () -> all ()) }}"
                                           target="_blank"
                                           class="btn btn-dark me-2 mb-1 btn-sm">
                                            <i data-feather="printer"></i> Print
                                        </a>
                                    </div>
                                </div>
                                
                                <div class="table-responsive">
                                    <table
                                            class="table w-100 table-hover table-responsive table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Account Head</th>
                                            <th>Closing Balance</th>
                                        </tr>
                                        </thead>
                                        <tbody style="vertical-align: baseline;">
                                        <tr>
                                            <td colspan="2">
                                                <strong>
                                                    {{ \App\Models\Account::find(config ('constants.current_assets')) -> name }}
                                                </strong>
                                            </td>
                                        </tr>
                                        {!! $current_assets['html'] !!}
                                        <tr>
                                            <td></td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format ($current_assets['net'], 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2">
                                                <strong>
                                                    {{ \App\Models\Account::find(config ('constants.non_current_assets')) -> name }}
                                                </strong>
                                            </td>
                                        </tr>
                                        {!! $non_current_assets['html'] !!}
                                        <tr>
                                            <td></td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format ($non_current_assets['net'], 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="right">
                                                <strong>
                                                    Total Assets
                                                </strong>
                                            </td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2">
                                                <strong>
                                                    {{ \App\Models\Account::find(config ('constants.liabilities')) -> name }}
                                                </strong>
                                            </td>
                                        </tr>
                                        {!! $liabilities['html'] !!}
                                        <tr>
                                            <td align="right">
                                                <strong>
                                                    Total Liabilities
                                                </strong>
                                            </td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format ($liabilities['net'], 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2">
                                                <strong style="font-size: 16px; color:#FF0000">
                                                    Shareholder's Equity
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="2">
                                                <strong>
                                                    {{ \App\Models\Account::find(config ('constants.capital')) -> name }}
                                                </strong>
                                            </td>
                                        </tr>
                                        {!! $capital['html'] !!}
                                        <tr>
                                            <td></td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format ($capital['net'], 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <strong>Net Profit (P&L)</strong>
                                            </td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format ($profit, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="right">
                                                <strong>
                                                    Total Equity
                                                </strong>
                                            </td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format (abs ($capital['net']) + $profit, 2) }}
                                                </strong>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <strong style="font-size: 16px; color: #000000">
                                                    Total Assets = Total Liabilities + Total Capital
                                                </strong>
                                            </td>
                                            <td>
                                                <strong style="font-size: 16px; color: #FF0000">
                                                    {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
                                                    =
                                                    {{ number_format (($liabilities['net'] + abs ($capital['net']) + $profit), 2) }}
                                                </strong>
                                            </td>
                                        </tr>
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
</x-dashboard>
