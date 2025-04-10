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
                                    <form method="get" action="{{ route ('stock-valuation-sale-report') }}">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Branch</label>
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
                                                <label class="mb-25">Attribute</label>
                                                <select name="attribute-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($attributes) > 0)
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{ $attribute -> id }}" @selected($attribute -> id == request ('attribute-id'))>
                                                                {{ $attribute -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="category-id">Category</label>
                                                <select name="category-id" class="form-control select2" id="category-id"
                                                        data-placeholder="Select ">
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
                                            
                                            <div class="form-group col-md-3 mb-1 ">
                                                <label class="mb-25" for="vendor-id">Vendor</label>
                                                <select name="vendor-id" class="form-control select2" id="vendor-id"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($vendors) > 0)
                                                        @foreach($vendors as $vendor)
                                                            <option
                                                                    value="{{ $vendor -> id }}" @selected($vendor -> id == request ('vendor-id'))>
                                                                {{ $vendor -> name }}
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

                                @if(count ($products) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('stock-valuation-sale-invoice', request () -> all ()) }}"
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
                                            <th>Available Quantity</th>
                                            <th>Stock Value (Sale Wise)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $net = 0; @endphp
                                        @if(count ($products) > 0)
                                            @foreach($products as $product)
                                                @php
                                                    $value = ($product -> stock_value_sale_wise() * $product -> available_quantity());
                                                    $net += $value;
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $product -> productTitle() }}</td>
                                                    <td>{{ $product -> available_quantity() }}</td>
                                                    <td>{{ number_format ($value, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="2"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                            <td>
                                                <strong>{{ number_format ($net, 2) }}</strong>
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