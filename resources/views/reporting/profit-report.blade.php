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
                                    <form method="get" action="{{ route ('profit-report') }}"
                                          id="general-sales-report">
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
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-50">Customer</label>
                                                <select name="customer-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($customers) > 0)
                                                        @foreach($customers as $customer)
                                                            <option value="{{ $customer -> id }}" @selected($customer -> id == request ('customer-id'))>
                                                                {{ $customer -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
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
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="category-id">Category</label>
                                                <select name="category-id" class="form-control select2" id="category-id"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option
                                                                    value="{{ $category -> id }}" @selected($category -> id == request ('category-id'))>
                                                                {{ $category -> title }}
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
                                
                                @if(count ($sales) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('profit-invoice', request () -> all ()) }}"
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
                                            <th>Sale ID</th>
                                            <th>Customer</th>
                                            <th>Price</th>
                                            <th>Discount (%)</th>
                                            <th>Discount (Flat)</th>
                                            <th>Net Price</th>
                                            <th>Profit (Before Disc.)</th>
                                            <th>Profit (After Disc.)</th>
                                            <th>Dated Added</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $totalPrice = 0;
                                            $totalNetPrice = 0;
                                            $profit = 0;
                                        @endphp
                                        @if(count ($sales) > 0)
                                            @foreach($sales as $sale)
                                                @php
                                                    $products = explode (',', $sale -> products);
                                                    $stocks = explode (',', $sale -> stocks);
                                                    $quantities = explode (',', $sale -> quantities);
                                                    $totalPrice = $totalPrice + $sale -> sale -> total;
                                                    $totalNetPrice = $totalNetPrice + $sale -> sale -> net;
                                                    $gross_profit = 0;
                                                    $cost_of_products_sold = 0;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $sale -> sale_id }}</td>
                                                    <td>{{ $sale -> sale -> customer -> name }}</td>
                                                    <td>{{ number_format ($sale -> sale -> total, 2) }}</td>
                                                    <td>{{ number_format ($sale -> sale -> percentage_discount, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> sale -> flat_discount, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> sale -> net, 2) }}</td>
                                                    <td>
                                                        @if(count ($stocks) > 0)
                                                            @foreach($stocks as $key => $stock_id)
                                                                @php
                                                                    $stock = \App\Models\ProductStock::find($stock_id);
                                                                @endphp
                                                                @if(!empty($stock))
                                                                    @php
                                                                        $customerPrice = \App\Models\CustomerProductPrice::where(['product_id' => $stock -> product_id, 'customer_id' => $sale -> sale -> customer -> id]) -> first();
                                                                        
                                                                        $unit_price = $stock -> sale_unit - $stock -> tp_unit;
                                                                        if(!empty($customerPrice))
                                                                            $unit_price = $customerPrice -> price - $stock -> tp_unit;
                                                                        
                                                                        $gross_profit = $gross_profit + ($unit_price * $quantities[$key]);
                                                                        $cost_of_products_sold = $cost_of_products_sold + ($unit_price * $quantities[$key]);
                                                                    @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        {{ number_format ($gross_profit, 2) }}
                                                        @php
                                                            $profit += $gross_profit;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @if($sale -> sale -> percentage_discount > 0)
                                                            @php
                                                                $discount = ($sale -> sale -> total * ($sale -> sale -> percentage_discount / 100) );
                                                            @endphp
                                                            {{ number_format (($gross_profit - $discount), 2) }}
                                                        @elseif($sale -> sale -> flat_discount > 0)
                                                            {{ number_format (($gross_profit - $sale -> sale -> flat_discount), 2) }}
                                                        @else
                                                            {{ number_format ($gross_profit, 2) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ (new \App\Services\GeneralService()) -> date_formatter ($sale -> sale -> created_at) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                            <td align="left">
                                                <strong>{{ number_format ($totalPrice, 2) }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td align="left">
                                                <strong>{{ number_format ($totalNetPrice, 2) }}</strong>
                                            </td>
                                            <td align="left">
                                                <strong>{{ number_format ($profit, 2) }}</strong>
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