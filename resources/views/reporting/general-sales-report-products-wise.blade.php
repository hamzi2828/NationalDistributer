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
                                    <form method="get" action="{{ route ('general-sales-report-product-wise') }}"
                                          id="general-sales-report">
                                        <div class="row">

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
                                                <label class="mb-50">Product</label>
                                                <select name="product-id[]" class="form-control select2"
                                                        data-placeholder="Select" multiple="multiple">
                                                    <option></option>
                                                    @if(count ($products) > 0)
                                                        @foreach($products as $product)
                                                            <option value="{{ $product -> id }}" @if(request() -> filled('product-id'))
                                                                @selected(in_array ($product -> id, request ('product-id')))
                                                                    @endif>
                                                                {{ $product -> productTitle() }}
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
                                                <label class="mb-50">Sale Type</label>
                                                <select name="is_online" class="form-control select2" data-placeholder="Select">
                                                    <option value=""></option> <!-- Blank option for no selection -->
                                                    <option value="1" @selected(request('is_online') == '1')>Online</option>
                                                    <option value="0" @selected(request('is_online') === '0' || is_null(request('is_online')))>Offline</option>
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
                                            <a href="{{ route ('general-sales-invoice-product-wise', $_SERVER['QUERY_STRING']) }}"
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
                                            <th>Product</th>
                                            <th>Quantity</th>
                                            <th>Net Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $totalQty = 0;
                                            $totalPrice = 0;
                                        @endphp
                                        @if(count ($sales) > 0)
                                            @foreach($sales as $sale)
                                                @php
                                                    $totalDiscount = 0;
                                                    $sale_ids = explode (',', $sale -> sale_ids);
                                                    $totalQty += $sale -> quantity;
                                                    $totalPrice += $sale -> net_price;
                                                @endphp
                                                <tr>
                                                    <td>
                                                        {{ $loop -> iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $sale -> product -> productTitle() }}
                                                    </td>
                                                    <td>
                                                        {{ number_format ($sale -> quantity) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format ($sale -> net_price, 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                            <td>
                                                <strong>{{ number_format ($totalQty) }}</strong>
                                            </td>
                                            <td>
                                                <strong>{{ number_format ($totalPrice, 2) }}</strong>
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