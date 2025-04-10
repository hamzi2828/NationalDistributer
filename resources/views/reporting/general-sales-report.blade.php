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
                                    <form method="get" action="{{ route ('general-sales-report') }}"
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
                                                <label class="mb-50">Refunded</label>
                                                <select name="refunded" class="form-control select2" data-placeholder="Select">
                                                    <option value=""></option> <!-- Ensure there is a blank option for no selection -->
                                                    <option value="1" @selected(request('refunded') == '1')>Yes</option>
                                                    <option value="0" @selected(request('refunded') === '0' || is_null(request('refunded')))>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-50">Sale Type</label>
                                                <select name="is_online" class="form-control select2" data-placeholder="Select">
                                                    <option value=""></option> <!-- Blank option for no selection -->
                                                    <option value="1" @selected(request('is_online') == '1')>Online</option>
                                                    <option value="0" @selected(request('is_online') === '0' || is_null(request('is_online')))>POS</option>
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
                                            <a href="{{ route ('general-sales-invoice', ['customer-id' => request ('customer-id'), 'user-id' => request ('user-id'), 'branch-id' => request ('branch-id'), 'start-date' => request ('start-date'), 'end-date' => request ('end-date')]) }}"
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
                                            <th>Tax</th>
                                            <th>Discount (%)</th>
                                            <th>Discount (Flat)</th>
                                            <th>Net Price</th>
                                            <th>closed At</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $totalPrice = 0;
                                            $totalNetPrice = 0;
                                        @endphp
                                        @if(count ($sales) > 0)
                                            @foreach($sales as $sale)
                                                @php

                                                    $products = explode (',', $sale -> products);
                                                    $totalPrice = $totalPrice + $sale -> sale -> total;
                                                    $totalNetPrice = $totalNetPrice + $sale -> sale -> net;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $sale -> sale_id }}</td>
                                                    <td>{{ $sale -> sale -> customer -> name }}</td>
                                                    <td>{{ number_format ($sale -> sale -> total, 2) }}</td>
                                                    <td>{{ $sale -> sale -> tax_total ?? 0 }}</td>
                                                    <td>{{ number_format ($sale -> sale -> percentage_discount, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> sale -> flat_discount, 2)	 }}</td>
                                                    <td>{{ number_format ($sale -> sale -> net, 2) }}</td>
                                                    <td>{{ $sale -> sale -> closed_at }}</td>
                                                    <td>
                                                        <a class="btn btn-dark btn-sm d-block mb-25 me-25"
                                                           target="_blank"
                                                           href="{{ route ('sales.invoice', ['sale' => $sale -> sale_id]) }}">
                                                            View/Print
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2"> </td>

                                            <td colspan="1"> <strong>Total</strong></td>
                                            <td align="left">
                                                <strong>{{ number_format ($totalPrice, 2) }}</strong>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td align="left">
                                                <strong>{{ number_format ($totalNetPrice, 2) }}</strong>
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
