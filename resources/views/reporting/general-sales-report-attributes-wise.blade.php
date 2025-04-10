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
                                    <form method="get" action="{{ route ('general-sales-report-attribute-wise') }}"
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
                                                <label class="mb-50">Attribute</label>
                                                <select name="attribute-id[]" class="form-control select2"
                                                        data-placeholder="Select" multiple="multiple">
                                                    <option></option>
                                                    @if(count ($attributes) > 0)
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{ $attribute -> id }}" @if(request() -> filled('attribute-id'))
                                                                @selected(in_array ($attribute -> id, request ('attribute-id')))
                                                                    @endif>
                                                                {{ $attribute -> title }}
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
                                            <a href="{{ route ('general-sales-invoice-attributes-wise', $_SERVER['QUERY_STRING']) }}"
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
                                            <th align="center">#</th>
                                            <th>Attribute</th>
                                            <th align="center">Quantity</th>
                                            <th align="center">Discount</th>
                                            <th align="center">Net Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $totalQty = 0;
                                            $totalPrice = 0;
                                            $totalDiscount = 0;
                                        @endphp
                                        @if(count ($sales) > 0)
                                            @foreach($sales as $sale)
                                                @php
                                                    $totalPrice += ($sale -> net - $sale -> discount);
                                                    $totalQty += $sale -> quantity;
                                                    $totalDiscount += $sale -> discount;
                                                @endphp
                                                <tr>
                                                    <td align="left">
                                                        {{ $loop -> iteration }}
                                                    </td>
                                                    <td align="left">
                                                        {{ $sale -> title }}
                                                    </td>
                                                    <td align="left">
                                                        {{ number_format ($sale -> quantity) }}
                                                    </td>
                                                    <td align="left">
                                                        {{ number_format ($sale -> discount, 2) }}
                                                    </td>
                                                    <td align="left">
                                                        {{ number_format (($sale -> net - $sale -> discount), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="1" class="text-danger fw-bolder" align="left"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                            <td align="left">
                                                <strong>{{ number_format ($totalQty) }}</strong>
                                            </td>
                                            <td align="left">
                                                <strong>{{ number_format ($totalDiscount, 2) }}</strong>
                                            </td>
                                            <td align="left">
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