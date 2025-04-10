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
                                    <form method="get" action="{{ route ('category-wise-quantity-report') }}">
                                        <div class="row">
                                            
                                            <div class="form-group  col-md-4 mb-1">
                                                <label class="mb-25" for="category-id">Category</label>
                                                <select name="category-id" class="form-control select2"
                                                        id="category-id"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($categories) > 0)
                                                        @foreach($categories as $category)
                                                            <option
                                                                    value="{{ $category -> id }}" @selected(request('category-id') == $category -> id)>
                                                                {{ $category -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-4 mb-1">
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
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                @if(count ($categories) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('category-wise-quantity-invoice', request () -> all ()) }}"
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
                                            <th>Barcode</th>
                                            <th>Available Quantity</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php $quantity = 0 @endphp
                                        @if(count ($products) > 0)
                                            <tr>
                                                <td></td>
                                                <td colspan="3"
                                                    class="font-medium-5 fw-bolder text-danger">{{ $searchedCategory ?-> title }}</td>
                                            </tr>
                                            @foreach($products as $product)
                                                @php $quantity += $product -> available_quantity() @endphp
                                                <tr>
                                                    <td>{{ $loop -> iteration }}</td>
                                                    <td>{{ $product -> productTitleWithoutBarcode() }}</td>
                                                    <td>{{ $product -> barcode }}</td>
                                                    <td>{{ $product -> available_quantity() }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                Total Available Quantity:
                                            </td>
                                            <td>
                                                <strong>{{ number_format ($quantity) }}</strong>
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
