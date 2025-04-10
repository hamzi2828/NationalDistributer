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
                                    <form method="get" action="{{ route ('purchase-analysis-report') }}">
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
                                                <label class="mb-25">Vendor</label>
                                                <select name="vendor-id" class="form-control select2"
                                                        data-allow-clear="true"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($vendors) > 0)
                                                        @foreach($vendors as $vendor)
                                                            <option
                                                                    value="{{ $vendor -> id }}" @selected(request ('vendor-id') == $vendor -> id)>
                                                                {{ $vendor -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Product</label>
                                                <select name="product-id" class="form-control select2"
                                                        data-allow-clear="true"
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
                                            
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                @if(count ($stocks) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('purchase-analysis-invoice', $_SERVER['QUERY_STRING']) }}"
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
                                                <th>Vendor</th>
                                                <th>Invoice</th>
                                                <th>Products</th>
                                                <th>Quantity</th>
                                                <th>Price/Qty</th>
                                                <th>Net Price</th>
                                                <th>Date Added</th>
                                            </tr>
                                        </thead>
                                        <tbody style="vertical-align: baseline;">
                                            @php
                                                $net = 0;
                                                $totalQuantity = 0;
                                            @endphp
                                            @if(count($stocks) > 0)
                                                @foreach($stocks as $stock)
                                                    @php $stock_net = 0; @endphp
                                                    @if(count($stock->products) > 0)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $stock->vendor->name }}</td>
                                                            <td>{{ $stock->invoice_no }}</td>
                                                            <td>
                                                                @foreach($stock->products as $product)
                                                                    @php
                                                                        $net += $product->net_price;
                                                                        $stock_net += $product->net_price;
                                                                    @endphp
                                                                    {{ $product->product->productTitle() }} <br />
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($stock->products as $product)
                                                                    @php
                                                                        $totalQuantity += $product->quantity;
                                                                    @endphp
                                                                    {{ $product->quantity }} <br />
                                                                @endforeach
                                                            </td>
                                                            <td>
                                                                @foreach($stock->products as $product)
                                                                    {{ number_format($product->tp_box, 2) }} <br />
                                                                @endforeach
                                                            </td>
                                                            <td>{{ number_format($stock_net, 2) }}</td>
                                                            <td>{{ $stock->created_at }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                                <td>
                                                    <strong> Quantity: {{ $totalQuantity }}</strong>
                                                </td>
                                                <td></td>
                                                <td>
                                                    <strong> Net: {{ number_format($net, 2) }}</strong>
                                                </td>
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
