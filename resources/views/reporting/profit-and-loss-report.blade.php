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
                                    <form method="get" action="{{ route ('profit-and-loss-report') }}">
                                        <div class="row">
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
                                        <a href="{{ route ('profit-and-loss-invoice', $_SERVER['QUERY_STRING']) }}"
                                           target="_blank"
                                           class="btn btn-dark me-2 mb-1 btn-sm">
                                            <i data-feather="printer"></i> Print
                                        </a>
                                    </div>
                                </div>
                                
                                @php
                                    $a = 0;
                                    $b = 0;
                                    $c = 0;
                                    $d = 0;
                                    $e = 0;
                                    $f = 0;
                                    $g = 0;
                                    $h = 0;
                                    $i = 0;
                                    $j = 0;
                                    $k = 0;

//                                    if (!empty($sale_discounts)) :
//                                        $d = ($sale_discounts -> total - $sale_discounts -> net);
//                                    endif;
                                
                                @endphp
                                
                                <div class="table-responsive">
                                    <table
                                            class="table w-100 table-hover table-responsive table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Account Head</th>
                                            <th>Net Cash</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        {!! $sales['items'] !!}
                                        @php
                                            $a += $sales['net'];
                                        @endphp
                                        
                                        <tr>
                                            <td>
                                                Sales Refund
                                            </td>
                                            <td>
                                                {{ number_format ($sales_refund['net'], 2) }}
                                                @php
                                                    $b += $sales_refund['net'];
                                                @endphp
                                            </td>
                                        </tr>
                                        {!! $sale_discounts['items'] !!}
                                        @php
                                            $c += $sale_discounts['net'];
                                            $e = ($a - $b - $c);
                                        @endphp
                                        
                                        <tr>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                <strong>Net Sale</strong>
                                            </td>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                {{ number_format ($e, 2) }}
                                            </td>
                                        </tr>
                                        
                                        {!! $direct_costs['items'] !!}
                                        @php
                                            $f += $direct_costs['net'];
                                            $g += $e - $f;
                                        @endphp
                                        <tr>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                <strong>Gross Profit/Loss</strong>
                                            </td>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                {{ number_format ($g, 2) }}
                                            </td>
                                        </tr>
                                        
                                        {!! $general_admin_expenses['items'] !!}
                                        @php
                                            $h += $general_admin_expenses['net'];
                                            $i = $g - $h;
                                        @endphp
                                        <tr>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                <strong>G.Total</strong>
                                            </td>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                {{ number_format ($h, 2) }}
                                            </td>
                                        </tr>
                                        
                                        {!! $income['items'] !!}
                                        
                                        <tr>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                <strong>Net Profit/Loss (Without Tax)</strong>
                                            </td>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                @php $i += $income['net'] @endphp
                                                {{ number_format ($i, 2) }}
                                            </td>
                                        </tr>
                                        
                                        {!! $taxes['items'] !!}
                                        @php
                                            $j += $taxes['net'];
                                            $k = $i > 0 ? $i - $j : $i + $j;
                                        @endphp
                                        
                                        <tr>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                <strong>Net Profit/Loss (With Tax)</strong>
                                            </td>
                                            <td class="text-danger font-medium-3 fw-bolder">
                                                {{ number_format ($k, 2) }}
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
