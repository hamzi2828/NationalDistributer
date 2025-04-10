<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row"></div>
            <div class="content-body">
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-md-12">
                            @include('products.search')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex gap-1 justify-content-end pt-1 pb-1">
                                        <a href="javascript:void(0)" class="btn btn-primary rounded btn-sm"
                                           onclick="downloadExcel('All Simple Products')">
                                            <i data-feather='download-cloud'></i>
                                            Download Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table w-100 table-striped w-100" id="excel-table">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th></th>
                                            <th>Sku</th>
                                            <th>Product</th>
                                            <th>Type</th>
                                            <th>Available Qty.</th>
                                            <th>Sale/Unit</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($products) > 0)
                                            @foreach($products as $product)
                                                <tr>
                                                    <td align="center">{{ $loop -> iteration }}</td>
                                                    <td>
                                                        @if(!empty(trim ($product -> image)))
                                                            <div class="avatar avatar-lg">
                                                                <img src="{{ asset ($product -> image) }}">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product -> sku }}</td>
                                                    <td>
                                                        {{ $product -> productTitle() }}
                                                    </td>
                                                    <td>
                                                        @if($product -> product_type == 'simple')
                                                            <span class="badge bg-success">
                                                            {{ $product -> product_type }}
                                                        </span>
                                                        @else
                                                            <span class="badge bg-primary">
                                                            {{ $product -> product_type }}
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product -> available_quantity() }}</td>
                                                    <td>{{ number_format ($product -> sale_unit, 2) }}</td>
                                                    <td>
                                                        @if($product -> status == '1')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-warning">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @can('ticket', $product)
                                                            <a class="btn btn-dark btn-sm d-block mb-25" target="_blank"
                                                               href="{{ route ('product-ticket', ['product' => $product -> id]) }}">
                                                                Ticket
                                                            </a>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{ $products -> appends(request() -> query()) -> links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script type="text/javascript">
            $ ( "div.head-label" ).html ( '<h4 class="fw-bolder mb-0">{{ $title }}</h6>' );
        </script>
    @endpush
</x-dashboard>
