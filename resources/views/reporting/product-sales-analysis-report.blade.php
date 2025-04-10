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
                                <form method="get" action="{{ route('product-sales-analysis-report') }}">
                                    <div class="row">
                                        <div class="form-group col-md-3 mb-1">
                                            <label class="mb-25">Year</label>
                                            <select name="year" class="form-control select2" data-placeholder="Select Year">
                                                @for($year = 2020; $year <= date('Y'); $year++)
                                                    <option value="{{ $year }}" @selected(request('year', date('Y')) == $year)>
                                                        {{ $year }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="form-group col-md-3 mb-1">
                                            <label class="mb-25">Product</label>
                                            <select name="product-id" class="form-control select2" data-placeholder="Select">
                                                <option></option>
                                                @if(count($products) > 0)
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}" @selected(request('product-id') == $product->id)>
                                                            {{ $product->productTitle() }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                   
                                        <div class="form-group col-md-3">
                                            <label class="mb-25" for="branch-id">Branch</label>
                                            <select name="branch-id" id="branch-id" class="form-control select2" data-placeholder="Select">
                                                <option></option>
                                                @if(count($branches) > 0)
                                                    @foreach($branches as $branch)
                                                        <option value="{{ $branch->id }}" 
                                                            @selected(request('branch-id', auth()->user()->branch_id) == $branch->id)>
                                                            {{ $branch->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        

                                        <div class="form-group col-md-3 mb-1">
                                            <button type="submit" class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="table-responsive">
                                <table class="table w-100 table-hover table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Product</th>
                                            @for($month = 1; $month <= 12; $month++)
                                                <th colspan="2" class="text-center">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</th>
                                            @endfor
                                        </tr>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th></th>
                                            @for($month = 1; $month <= 12; $month++)
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Revenue</th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(request('product-id'))
                                            @php
                                                // Find the selected product
                                                $selectedProduct = $products->firstWhere('id', request('product-id'));
                                            @endphp
                                    
                                            @if($selectedProduct)
                                                <tr>
                                                    <td class="text-center">1</td>
                                                    <td>{{ $selectedProduct->title }}</td>
                                                    @for($month = 1; $month <= 12; $month++)
                                                        @php
                                                            $startDate = request('year', date('Y')) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                                                            $endDate = date("Y-m-t", strtotime($startDate));
                                                            $soldQuantity = $selectedProduct->sold_quantity_between_dates_by_product($startDate, $endDate, request('product-id'));
                                                            $revenue = $selectedProduct->revenue_between_dates_by_product($startDate, $endDate, request('product-id'));
                                                        @endphp
                                                        <td class="text-center">{{ $soldQuantity }}</td>
                                                        <td class="text-center">{{ $revenue }}</td>
                                                    @endfor
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="14" class="text-center">No product found for the selected ID.</td>
                                                </tr>
                                            @endif
                                        @else
                                            @php
                                                $totalQuantity = array_fill(1, 12, 0);
                                                $totalRevenue = array_fill(1, 12, 0);
                                            @endphp
                                            @foreach($products as $index => $product)
                                                <tr>
                                                    <td class="text-center">{{ $index + 1 }}</td>
                                                    <td>{{ $product->title }}</td>
                                                    @for($month = 1; $month <= 12; $month++)
                                                        @php
                                                            $startDate = request('year', date('Y')) . '-' . str_pad($month, 2, '0', STR_PAD_LEFT) . '-01';
                                                            $endDate = date("Y-m-t", strtotime($startDate));
                                                            $soldQuantity = $product->sold_quantity_between_dates_by_product($startDate, $endDate, $product->id);
                                                            $revenue = $product->revenue_between_dates_by_product($startDate, $endDate, $product->id);
                                                            $totalQuantity[$month] += $soldQuantity;
                                                            $totalRevenue[$month] += $revenue;
                                                        @endphp
                                                        <td class="text-center">{{ $soldQuantity }}</td>
                                                        <td class="text-center">{{ $revenue }}</td>
                                                    @endfor
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    @if(!request('product-id'))
                                        <tfoot>
                                            <tr>
                                                <th colspan="2" class="text-center">Total</th>
                                                @for($month = 1; $month <= 12; $month++)
                                                    <th class="text-center">{{ $totalQuantity[$month] }}</th>
                                                    <th class="text-center">{{ $totalRevenue[$month] }}</th>
                                                @endfor
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