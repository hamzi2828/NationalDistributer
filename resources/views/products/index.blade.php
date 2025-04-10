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
                                           onclick="downloadExcel('All Products')">
                                            <i data-feather='download-cloud'></i>
                                            Download Excel
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table w-100 table-striped table-responsive" id="excel-table">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Actions</th>
                                            <th></th>
                                            <th>Sku</th>
                                            <th>Product</th>
                                            <th>Type</th>
                                            <th>Available Qty.</th>
                                            <th>Tax Profile</th>
                                            <th>Tax Rate </th>
                                            <th>Manufacturer</th>
                                            <th>Category</th>
                                            <th>Attribute</th>
                                            <th>Term</th>
                                            <th>Threshold</th>
                                            <th>Pack Size</th>
                                            <th>TP/Box</th>
                                            <th>TP/Unit</th>
                                            <th>Sale/Box</th>
                                            <th>Sale/Unit</th>
                                            <th>Margin/Unit (%)</th>
                                            <th>Margin/Box (%)</th>
                                            <th>Total Qty.</th>
                                            <th>Sold Qty.</th>
                                            <th>Refund Customer</th>
                                            <th>Return Customer</th>
                                            <th>Return Supplier</th>
                                            <th>Adjustment Decrease</th>
                                            <th>Damage/Loss</th>
                                            <th>Transfer Qty</th>
                                            <th>Available Qty.</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($products) > 0)
                                            @foreach($products as $product)
                                                <tr>
                                                    <td align="center">{{ $loop -> iteration }}</td>
                                                    <td>
                                                        @include('products.actions', ['product' => $product])
                                                    </td>
                                                    <td>
                                                        @if(!empty(trim ($product -> image)))
                                                            <div class="avatar avatar-lg">
                                                                <img src="{{ asset ($product -> image) }}">
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $product -> sku }}</td>
                                                    <td>
                                                        {{ $product -> productTitle() }} <br />
                                                        @if($product -> available_quantity() < 1)
                                                            <span class="badge bg-danger">
                                                            Out of Stock
                                                        </span>
                                                        @endif
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
                                                    <td>{{ $product -> tax -> title ?? 'N/A' }}</td>
                                                    <td>{{ $product -> tax -> rate ?? '0' }}</td>
                                                    <td>
                                                        {{ $product -> manufacturer -> title }}
                                                    </td>
                                                    <td>
                                                        {{ $product -> category -> title }}
                                                    </td>
                                                    <td>
                                                        @if(!empty($product -> term))
                                                            {{ Str::title($product -> term -> term -> attribute -> title) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($product -> term))
                                                            {{ $product -> term -> term -> title }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $product -> threshold }}</td>
                                                    <td>{{ $product -> pack_size }}</td>
                                                    <td>{{ number_format ($product -> tp_box, 2) }}</td>
                                                    <td>{{ number_format ($product -> tp_unit, 2) }}</td>
                                                    <td>{{ number_format ($product -> sale_box, 2) }}</td>
                                                    <td>{{ number_format ($product -> sale_unit, 2) }}</td>
                                                    <td>
                                                        @if($product -> sale_unit > 0 && $product -> tp_unit > 0)
                                                            {{ number_format (((($product -> sale_unit - $product -> tp_unit) / $product -> tp_unit) * 100), 2) }}
                                                        @else
                                                            {{ number_format (0, 2) }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($product -> sale_box > 0 && $product -> tp_box > 0)
                                                            {{ number_format (((($product -> sale_box - $product -> tp_box) / $product -> tp_box) * 100), 2) }}
                                                        @else
                                                            {{ number_format (0, 2) }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $product -> stock_quantity() }}</td>
                                                    <td>{{ $product -> sold_quantity() }}</td>
                                                    <td>{{ $product -> refund_quantity() }}</td>
                                                    <td>{{ $product -> return_customer() }}</td>
                                                    <td>{{ $product -> returned_quantity() }}</td>
                                                    <td>{{ $product -> adjustment_decrease() }}</td>
                                                    <td>{{ $product -> damage_loss() }}</td>
                                                    <td>{{ $product -> issued_quantity() }}</td>
                                                    <td>{{ $product -> available_quantity() }}</td>
                                                    <td>
                                                        @if($product -> status == '1')
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-warning">Inactive</span>
                                                        @endif
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
