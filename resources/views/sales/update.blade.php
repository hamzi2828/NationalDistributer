<x-dashboard :title="$title">
    @push('styles')
        <style>
            tbody, td, tfoot, th, thead, tr {
                padding: 10px !important;
            }
        </style>
    @endpush
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post"
                                      {{ $sale -> sale_closed == '1' ? 'onsubmit="return false"' : '' }}
                                      action="{{ route ('sales.update', ['sale' => $sale -> id]) }}">
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden" id="sale-customer" name="customer_id"
                                           value="{{ $sale -> customer_id }}">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <h5><u>Sale ID:</u> {{ $sale -> id }}</h5>
                                                <h5><u>Customer:</u> {{ $sale -> customer -> customerDetails() }}</h5>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            <div class="card-body p-0 border p-1 rounded-2"
                                                                 style="height: 270px">
                                                                <select class="form-control"
                                                                        id="sale-products"
                                                                        data-placeholder="Select Product(s)">
                                                                    <option></option>
                                                                    @if(count ($products) > 0)
                                                                        @foreach($products as $product)
                                                                            @if($product -> available_quantity() > 0 && !in_array ($product -> id, $selected_products))
                                                                                <option value="{{ $product -> id }}">
                                                                                    {{ $product -> productTitle() }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>

                                                            <textarea name="remarks" class="form-control mt-2"
                                                                      maxlength="100" placeholder="Remarks"
                                                                      rows="2">{{ old ('remarks', $sale -> remarks) }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-1">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th width="2%"></th>
                                                        <th width="35%">Product</th>
                                                        <th width="8%">Available Qty.</th>
                                                        <th width="15%">Sale Qty.</th>
                                                        <th width="20%">Price</th>
                                                        <th width="20%">Net Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="sold-products">
                                                    @if(count ($sale -> products) > 0)
                                                        @foreach($sale -> products as $product)
                                                            @php
                                                                $available = $product -> product -> available_quantity();
                                                                if ($available - $product -> quantity < 1 )
                                                                    @$available = $available + $product -> quantity;
                                                            @endphp
                                                            <tr class="sale-product-{{ $product -> product -> id }}">
                                                                <input type="hidden" name="products[]"
                                                                       value="{{ $product -> product -> id }}">
                                                                <td>
                                                                    <span class="d-flex w-100 justify-content-center align-items-center fw-bold">{{ $loop -> iteration }}</span>
                                                                    <a href="javascript:void(0)"
                                                                       data-product-id="{{ $product -> product -> id }}"
                                                                       class="remove-sale-product">
                                                                        <i data-feather="trash-2"></i>
                                                                    </a>
                                                                </td>

                                                                <td>{{ $product -> product -> productTitle() }}</td>

                                                                <td>
                                                                    <input class="form-control available-qty-{{ $product -> product -> id }}"
                                                                           readonly="readonly"
                                                                           value="{{ $available }}">
                                                                </td>

                                                                <td>
                                                                    <input type="number"
                                                                           class="form-control sale-qty-{{ $product -> product -> id }}"
                                                                           name="quantity[]"
                                                                           data-product-id="{{ $product -> product -> id }}"
                                                                           onchange="sale_quantity({{ $product -> product -> id }})"
                                                                           required="required"
                                                                           value="{{ $product -> quantity }}"
                                                                           placeholder="Quantity" min="0">
                                                                </td>

                                                                <td class="product-price-{{ $product -> product -> id }}">
                                                                    <input class="form-control" readonly="readonly"
                                                                           value="{{ number_format (($product -> price / $product -> no_of_rows), 2) }}">
                                                                </td>

                                                                <td class="product-net-price-{{ $product -> product -> id }}">
                                                                    <input class="net-price form-control"
                                                                           readonly="readonly"
                                                                           value="{{ $product -> net_price, 2 }}">
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <td colspan="5" align="right">
                                                            <strong>Total</strong>
                                                        </td>
                                                        <td>
                                                            <input type="text" step="0.01" readonly="readonly"
                                                                   class="form-control" id="sale-total"
                                                                   value="{{ $sale -> total }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" align="right">
                                                            <strong>Discount (%)</strong>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" max="100"
                                                                   name="percentage-discount" required="required"
                                                                   class="form-control" id="sale-discount"
                                                                   value="{{ $sale -> percentage_discount }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" align="right">
                                                            <strong>Discount (Flat)</strong>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01"
                                                                   name="flat-discount" required="required"
                                                                   class="form-control" id="flat-discount"
                                                                   value="{{ $sale -> flat_discount }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" align="right">
                                                            <strong>Net Price</strong>
                                                        </td>
                                                        <td>
                                                            <input type="text" step="0.01" readonly="readonly"
                                                                   class="form-control" id="net-price"
                                                                   value="{{ number_format ($sale -> net, 2) }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" align="right">
                                                            <strong>Paid Amount</strong>
                                                        </td>
                                                        <td>
                                                            <input type="number" step="0.01" name="paid-amount"
                                                                   required="required"
                                                                   class="form-control" id="paid-amount"
                                                                   value="{{ $sale -> amount_added }}">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5" align="right">
                                                            <strong>Balance</strong>
                                                        </td>
                                                        <td>
                                                            <input type="text" step="0.01" readonly="readonly"
                                                                   class="form-control" id="balance"
                                                                   value="{{ number_format (($sale -> net - $sale -> amount_added), 2) }}">
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        @if($sale -> sale_closed == '0')
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            @can('close_bill', $sale)
                                                <a class="btn btn-info d-inline-block m-0 mt-25 ms-25"
                                                   onclick="return confirm('Are you sure?')"
                                                   href="{{ route ('sales.close-sale', ['sale' => $sale -> id]) }}">
                                                    Close
                                                </a>
                                            @endcan
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>