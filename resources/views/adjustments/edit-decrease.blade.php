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
                                      action="{{ route ('adjustments.update-adjustment-decrease', ['stock_return' => $returns -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" id="return-vendor" value="{{ $returns -> vendor_id }}">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th width="2%"></th>
                                                        <th width="35%">Product</th>
                                                        <th width="8%">Available Qty.</th>
                                                        <th width="15%">Return Qty.</th>
                                                        <th width="20%">TP/Unit</th>
                                                        <th width="20%">Net Price</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="sold-products">
                                                    @if(count ($returns -> products) > 0)
                                                        @foreach($returns -> products as $product)
                                                            @php
                                                                $available = $product -> product -> available_quantity();
                                                                if ($available - $product -> quantity < 1 )
                                                                    @$available = $available + $product -> quantity;
                                                            @endphp
                                                            <tr class="sale-product-{{ $product -> product -> id }}">
                                                                <input type="hidden" name="products[]"
                                                                       value="{{ $product -> product -> id }}">
                                                                <td>
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
                                                                           onchange="return_quantity({{ $product -> product -> id }})"
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
                                                            <input type="text" step="0.01" name="return-total"
                                                                   readonly="readonly"
                                                                   class="form-control" id="return-total"
                                                                   value="{{ $returns -> net_price }}">
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <label>Reference No.</label>
                                                <input type="text" name="reference-no"
                                                       class="form-control mb-1"
                                                       value="{{ old ('reference-no', $returns -> reference_no) }}"
                                                       placeholder="Reference No." required="required">
                                            </div>
                                            <div class="col-md-8 mb-1">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control"
                                                          maxlength="100" placeholder="Description"
                                                          rows="2">{{ old ('description', $returns -> description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
