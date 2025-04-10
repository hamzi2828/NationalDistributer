<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table  Daily Closing Report (Summary)-->
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <form method="get" action="{{ route ('daily-closing-summary-report') }}">
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



                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-50">User</label>
                                                <select name="user-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($users) > 0)
                                                        @foreach($users as $user)
                                                            <option value="{{ $user -> id }}" @selected($user -> id == request ('user-id'))>
                                                                {{ $user -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>


                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-50">Branch</label>
                                                <select name="branch-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch -> id }}" @selected($branch -> id == request ('branch-id'))>
                                                                {{ $branch -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            {{-- <div class="form-group col-md-3 mb-1">
                                                <label class="mb-50">Sale Type</label>
                                                <select name="is_online" class="form-control select2" data-placeholder="Select">
                                                    <option value=""></option> <!-- Blank option for no selection -->
                                                    <option value="1" @selected(request('is_online') == '1')>Online</option>
                                                    <option value="0" @selected(request('is_online') === '0' || is_null(request('is_online')))>Offline</option>
                                                </select>
                                            </div> --}}
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                 @if(count ($products) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('daily-closing-summary-invoice', request () -> all ()) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif  
                                
                                
                                
                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Total Sale</th>
                                                <th>Total Return</th>
                                                <th>Total Refund (Customer)</th>
                                                <th>Net Sale</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($products) > 0)
                                                @php
                                                    $branchId = request('branch-id', auth()->user()->branch_id); // Use branch from auth if none is selected
                                                    $totalRevenue = 0;
                                                    $totalReturnAmount = 0;
                                                    $totalRefundedAmount = 0;
                                                    $netSale = 0;
                                
                                                    $sortedProducts = $products->map(function($product) use ($branchId, &$totalRevenue, &$totalReturnAmount, &$totalRefundedAmount, &$netSale) {
                                                        $startDate = request('start-date');
                                                        $endDate = request('end-date');
                                                        $userId = request('user-id');
                                                        $saleType = 1;
                                
                                                        $TotalRevenue = $product->revenue_between_dates_by_product_by_branchand_by_user($startDate, $endDate,'',$branchId,$userId);
                                                        $ReturnAmount = $product->returned_amount_between_dates($startDate, $endDate, $userId);             
                                                        $RefundedAmount = $product->refund_amount_between_dates($startDate, $endDate);
                                
                                                        // Accumulate totals
                                                        $totalRevenue += $TotalRevenue;
                                                        $totalReturnAmount += $ReturnAmount;
                                                        $totalRefundedAmount += $RefundedAmount;
                                                        $netSale += $TotalRevenue - ($ReturnAmount + $RefundedAmount);
                                
                                                        if ($TotalRevenue > 0 || $ReturnAmount > 0 || $RefundedAmount > 0) {  
                                                            return $product;
                                                        }
                                
                                                        return null; 
                                                    })->filter()->sortByDesc('TotalRevenue'); 
                                                @endphp
                                
                                              
                                                    <tr>
                                                        <td>{{ number_format($totalRevenue, 2) }}</td>
                                                        <td>{{ number_format($totalReturnAmount, 2) }}</td>
                                                        <td>{{ number_format($totalRefundedAmount, 2) }}</td>
                                                        <td>{{ number_format($netSale, 2) }}</td>
                                                    </tr>  
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">No products found.</td>
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
</x-dashboard>
