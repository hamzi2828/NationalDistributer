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
                                    <form method="get" action="{{ route ('high-low-sale-report-pos-vs-online') }}">
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
                                            <a href="{{ route ('high-low-sale-report-pos-vs-online-invoice', request () -> all ()) }}"
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
                                                <th>#</th>
                                                <th>Picture</th>
                                                <th>Sku</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Sold Quantity (Online)</th>
                                                <th>Sale Value</th>
                                                <th>Sold Quantity (Pos)</th>
                                                <th>Sale Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($products) > 0)
                                                @php
                                                    $branchId = request('branch-id', auth()->user()->branch_id); // Use branch from auth if none is selected
                                                    $totalSoldQuantity = 0;
                                                    $totalSaleValue = 0;
                                                    $totalSoldQuantityPos = 0;
                                                    $totalSaleValuePos = 0;
                                                    
                                                    $sortedProducts = $products->map(function($product) use ($branchId) {
                                                        $startDate = request('start-date');
                                                        $endDate = request('end-date');
                                                        $saleType = 1;



                                                        $soldQuantity = $product->sold_quantity_between_dates_by_product_branch_wise($startDate, $endDate, '', $branchId, $saleType);
                                                        $saleValue = $product->revenue_between_dates_by_product_sale_type($startDate, $endDate,'', $saleType);
                                                        
                                                        $soldQuantityPos = $product->sold_quantity_between_dates_by_product_branch_wise($startDate, $endDate, '', $branchId, 0);
                                                        $saleValuePos = $product->revenue_between_dates_by_product_sale_type($startDate, $endDate, '', 0);


                                                       
                                                            if ($soldQuantity > 0 || $soldQuantityPos > 0) {  
                                                            $product->soldQuantity = $soldQuantity;
                                                            $product->saleValue = $saleValue;
                                                            $product->soldQuantityPos = $soldQuantityPos;
                                                            $product->saleValuePos = $saleValuePos;
                                                            return $product;
                                                        }
                                                        
                                                        
                                                        return null; // Return null for products with soldQuantity of 0
                                                    })->filter()->sortByDesc('soldQuantity'); // Filter out null values and sort
                                                    $i = 1;
                                                @endphp
                                                
                                
                                                @foreach($sortedProducts as $index => $product)
                                                    @php
                                                        $totalSoldQuantity += $product->soldQuantity;
                                                        $totalSaleValue += $product->saleValue;
                                                        $totalSoldQuantityPos += $product->soldQuantityPos;
                                                        $totalSaleValuePos += $product->saleValuePos;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td><img src="{{ asset($product->image) }}" alt="image" width="50"></td>
                                                        <td>{{ $product->sku }}</td>
                                                        <td>{{ $product->productTitle() }}</td>
                                                        <td>{{ $product->category ? $product->category->title : 'N/A' }}</td>
                                                        <td>{{ number_format($product->soldQuantity) }}</td>
                                                        <td>{{ number_format($product->saleValue, 2) }}</td>
                                                        <td>{{ number_format($product->soldQuantityPos) }}</td>
                                                        <td>{{ number_format($product->saleValuePos, 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="7" class="text-center">No products found.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        @if(count($sortedProducts) > 0)
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                                    <td><strong>{{ number_format($totalSoldQuantity) }}</strong></td>
                                                    <td><strong>{{ number_format($totalSaleValue, 2) }}</strong></td>
                                                    <td><strong>{{ number_format($totalSoldQuantityPos) }}</strong></td>
                                                    <td><strong>{{ number_format($totalSaleValuePos, 2) }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        @endif
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
