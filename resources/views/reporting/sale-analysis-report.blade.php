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
                                    <form method="get" action="{{ route ('sale-analysis-report') }}">
                                        <div class="row">
                                            <div class="form-group col-md-2 mb-1">
                                                <label class="mb-25" for="start-date">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="start-date"
                                                       name="start-date" value="{{ request ('start-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <label class="mb-25" for="end-date">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="end-date"
                                                       name="end-date" value="{{ request ('end-date') }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="product-id">Product</label>
                                                <select name="product-id" class="form-control select2"
                                                        data-allow-clear="true" id="product-id"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($products) > 0)
                                                        @foreach($products as $product)
                                                            <option
                                                                    value="{{ $product -> id }}" @selected(request ('product-id') == $product -> id)>
                                                                {{ $product -> productTitle() }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="customer-id">Customer</label>
                                                <select name="customer-id" class="form-control select2"
                                                        data-allow-clear="true" id="customer-id"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($customers) > 0)
                                                        @foreach($customers as $customer)
                                                            <option
                                                                    value="{{ $customer -> id }}" @selected(request ('customer-id') == $customer -> id)>
                                                                {{ $customer -> name }}
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
                                            <a href="{{ route ('sales-analysis-invoice', request () -> all ()) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer</th>
                                                <th>Invoice</th>
                                                <th>Products</th>
                                                <th>Quantity</th>
                                                <th>Price/Qty</th>
                                                <th>Discount (%)</th>
                                                <th>Net Price</th>
                                                <th>Date Added</th>
                                            </tr>
                                        </thead>
                                        <tbody style="vertical-align: baseline;">
                                            @php
                                                $net = 0;
                                                $totalQuantity = 0;
                                            @endphp
                                            @if(count($sales) > 0)
                                                @foreach($sales as $sale)
                                                    @php
                                                        $net += $sale->net_price;
                                                        $totalQuantity += $sale->quantity;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $sale->sale?->customer?->name }}</td>
                                                        <td>{{ $sale->sale_id }}</td>
                                                        <td>{{ $sale->product?->productTitle() }}</td>
                                                        <td>{{ $sale->quantity }}</td>
                                                        <td>{{ number_format($sale->price, 2) }}</td>
                                                        <td>{{ number_format($sale->discount, 2) }}</td>
                                                        <td>{{ number_format($sale->net_price, 2) }}</td>
                                                        <td>{{ $sale->sale?->closed_at }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                                <td><strong> {{ $totalQuantity }}</strong></td>
                                                <td colspan="2"></td>
                                                <td><strong>{{ number_format($net, 2) }}</strong></td>
                                                <td></td>
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
