<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Product</th>
                                            <th>Vendor</th>
                                            <th>Stock ID</th>
                                            <th>Expiry Date</th>
                                            <th>Quantity</th>
                                            <th>Sold</th>
                                            <th>Refund Customer</th>
                                            <th>Return Supplier</th>
                                            <th>Adjustment Decrease</th>
                                            <th>Damage/Loss</th>
                                            <th>Transfer Qty.</th>
                                            <th>Available Qty.</th>
                                            <th>TP</th>
                                            <th>Value</th>
                                            <th>Sale Price</th>
                                            <th>Discount (%)</th>
                                            <th>S.Tax (%)</th>
                                            <th>Total Stock Value</th>
                                            <th>Date Added</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($product -> stocks) > 0)
                                            @foreach($product -> stocks as $stock)
                                                <tr>
                                                    <td>
                                                        {{ $loop -> iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $product -> productTitle () }}
                                                    </td>
                                                    <td>
                                                        @if(!empty($stock -> stock) && !empty($stock -> stock -> vendor))
                                                            {{ $stock -> stock -> vendor -> name }}
                                                        @elseif(!empty($stock -> stock) && !empty($stock -> stock -> customer))
                                                            {{ $stock -> stock -> customer -> name }} -
                                                            <strong>Returning</strong>
                                                        @elseif(!empty($stock -> stock) && !empty($stock -> stock -> stock_type == 'adjustment-increase'))
                                                            Adjustment Increase
                                                        @elseif(!empty($stock -> stock) && !empty($stock -> stock -> stock_type == 'adjustment-decrease'))
                                                            Adjustment Decrease
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!empty($stock -> stock))
                                                            {{ $stock -> stock -> invoice_no }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $stock -> expiry_date }}
                                                    </td>
                                                    <td>
                                                        {{ $stock -> quantity }}
                                                    </td>
                                                    <td>{{ $stock -> sold_quantity() }}</td>
                                                    <td>{{ $stock -> refund_quantity() }}</td>
                                                    <td>{{ $stock -> returned_quantity() }}</td>
                                                    <td>{{ $stock -> adjustment_decrease() }}</td>
                                                    <td>{{ $stock -> damage_loss() }}</td>
                                                    <td>{{ $stock -> issued_quantity() }}</td>
                                                    <td>{{ $stock -> available() }}</td>
                                                    <td>{{ number_format ($stock -> tp_unit, 2) }}</td>
                                                    <td>{{ number_format ($stock -> tp_unit * $stock -> quantity, 2) }}</td>
                                                    <td>{{ number_format ($stock -> sale_unit, 2) }}</td>
                                                    <td>{{ number_format ($stock -> discount, 2) }}</td>
                                                    <td>{{ number_format ($stock -> sale_tax, 2) }}</td>
                                                    <td>{{ number_format ($stock -> tp_unit * $stock -> quantity, 2) }}</td>
                                                    <td>{{ $stock -> created_at }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
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
