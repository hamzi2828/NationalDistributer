<x-dashboard :title="$title">
    @push('styles')
        <style>
            tbody, td, tfoot, th, thead, tr {
                padding : 10px !important;
            }
            
            .zero-record {
                border     : 5px solid #FF0000 !important;
                background : #ffff00;
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
                                    <input type="hidden" id="shipping-charges"
                                           value="{{ optional ($settings -> settings) -> shipping_charges }}">
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card">
                                                            
                                                            <div class="card-header d-block mb-2 p-0">
                                                                <select name="customer_id" class="form-control select2"
                                                                        required="required"
                                                                        data-placeholder="Select Customer">
                                                                    <option></option>
                                                                    @if(count ($customers) > 0)
                                                                        @foreach($customers as $customer)
                                                                            <option
                                                                                    value="{{ $customer -> id }}" @selected(old('customer-id', $sale -> customer_id) == $customer -> id)>
                                                                                {{ $customer -> customerDetails() }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            </div>
                                                            
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
                                                            
                                                            <input type="number" name="boxes" class="form-control mt-2"
                                                                   placeholder="No. of Boxes"
                                                                   value="{{ old ('remarks', $sale -> boxes) }}" min="1"
                                                                   required="required">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-8 mb-1">
                                                @if($sale -> is_online == '1')
                                                    <div id="overlay">
                                                        Online sales cannot be edited.
                                                    </div>
                                                @endif
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
                                                    @php
                                                        $attributesArray = [];
                                                        $productsArray = [];
                                                        $counter = 1;
                                                        $quantity = 0;
                                                    @endphp
                                                    @if(count ($sales) > 0)
                                                        @foreach($sales as $key => $saleInfo)
                                                            @if(!in_array ($saleInfo -> attribute_id, $attributesArray))
                                                                <tr>
                                                                    <td colspan="4" align="left"
                                                                        class="text-danger font-medium-5">
                                                                        <strong>{{ $saleInfo -> title }}</strong>
                                                                    </td>
                                                                </tr>
                                                                @php
                                                                    $counter = 1;
                                                                    $quantity = 0;
                                                                    array_push ($attributesArray, $saleInfo -> attribute_id);
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $counter++;
                                                                @endphp
                                                            @endif
                                                            
                                                            @php
                                                                $product = \App\Models\Product::find($saleInfo -> product_id);
                                                                $available = $product -> available_quantity();
                                                                $class = null;

                                                                if ($available - $product -> quantity < 1 )
                                                                    @$available = $available + $product -> quantity;

                                                                if ($available < 1)
                                                                    $class = 'zero-record';

                                                                $quantity += $saleInfo -> quantity;

                                                                array_push ($productsArray, $product -> id)
                                                            @endphp
                                                            <tr class="added-products sale-product-{{ $product -> id }} {{ $class }}"
                                                                data-product-id="{{ $product -> id }}">
                                                                <input type="hidden" name="products[]"
                                                                       value="{{ $product -> id }}">
                                                                <td>
                                                                    <span
                                                                            class="d-flex w-100 justify-content-center align-items-center fw-bold">{{ $counter }}</span>
                                                                    <a href="javascript:void(0)"
                                                                       data-product-id="{{ $product -> id }}"
                                                                       class="remove-sale-product">
                                                                        <i data-feather="trash-2"></i>
                                                                    </a>
                                                                </td>
                                                                
                                                                <td>{{ $product -> productTitle() }}</td>
                                                                
                                                                <td>
                                                                    <input
                                                                            class="form-control available-qty-{{ $product -> id }}"
                                                                            readonly="readonly"
                                                                            value="{{ $available }}">
                                                                </td>
                                                                
                                                                <td>
                                                                    <input type="number"
                                                                           class="form-control sale-qty-{{ $product -> id }}"
                                                                           name="quantity[]"
                                                                           data-product-id="{{ $product -> id }}"
                                                                           onchange="sale_quantity({{ $product -> id }})"
                                                                           required="required"
                                                                           value="{{ $saleInfo -> quantity }}"
                                                                           placeholder="Quantity" min="0">
                                                                </td>
                                                                
                                                                <td class="product-price-{{ $product -> id }}">
                                                                    <input class="form-control"
                                                                           readonly="readonly"
                                                                           value="{{ number_format (($saleInfo -> price/$saleInfo -> noOfRows), 2) }}">
                                                                </td>
                                                                
                                                                <td class="product-net-price-{{ $product -> id }}">
                                                                    <input class="net-price form-control"
                                                                           readonly="readonly"
                                                                           value="{{ number_format(($saleInfo -> net_price), 2) }}">
                                                                </td>
                                                            </tr>
                                                            @if (($key < count($sales) - 1 && $saleInfo -> attribute_id != $sales[$key + 1]->attribute_id) || $loop -> last)
                                                                <tr>
                                                                    <td colspan="3"></td>
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                               disabled="disabled"
                                                                               value="{{ number_format ($quantity) }}">
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                    @include('sales.simple-sales')
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
                                                            <strong>Shipping</strong>
                                                        </td>
                                                        <td>
                                                            <select name="shipping" data-placeholder="Select" id="free-shipping"
                                                                    class="form-control select2"
                                                                    required="required">
                                                                
                                                                <option value="0" 
                                                                        {{ (empty(trim ($sale -> courier_id)) || $sale -> courier_id < 1) ? 'selected="selected"' : '' }}>
                                                                    Free
                                                                </option>
                                                                <option value="1" {{ $sale -> courier_id > 0 ? 'selected="selected"' : '' }}>
                                                                    Paid
                                                                </option>
                                                            </select>
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
                                            <button type="submit" class="btn btn-primary">Update</button>
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
    @push('scripts')
        <script type="text/javascript">
            $ ( window ).on ( 'load', function () {
                const addedProducts = document.querySelectorAll ( '.added-products' );
                addedProducts.forEach ( function ( product ) {
                    const productId = product.dataset.productId;
                    
                    if ( parseInt ( productId ) > 0 && typeof productId != 'undefined' )
                        selected.push ( productId );
                    
                } );
            } );

            $(document).ready(function() {
                $('#sale-products').select2({
                    placeholder: 'Select Product(s)',
                    allowClear: true
                });


                 // Add change event listener to the #sale-products select element
                $('#sale-products').on('change', function() {
                    const closeButton = document.querySelector('a.btn.btn-info');
                    closeButton.style.pointerEvents = 'none';
                    closeButton.style.opacity = '0.5';
                });

            // Initialize Select2
            $('#free-shipping').select2({
                placeholder: 'Select',
                allowClear: true
            });

            // Add change event listener to the select element
            $('#free-shipping').on('change', function() {
                const closeButton = document.querySelector('a.btn.btn-info');
                closeButton.style.pointerEvents = 'none';
                closeButton.style.opacity = '0.5';

            });
        });

            document.addEventListener('DOMContentLoaded', function() {
                // Get the close button
                const closeButton = document.querySelector('a.btn.btn-info');

                // Get all input elements in the form
            const inputs = document.querySelectorAll('.form input, .form textarea, input[name="flat-discount"], input[name="percentage-discount"], input[name="paid-amount"], select[name="shipping"], select[name="customer_id"], #sale-products');

                
                // Function to disable the close button
                function disableCloseButton() {
                    closeButton.style.pointerEvents = 'none';
                    closeButton.style.opacity = '0.5';
                }

                // Function to enable the close button
                function enableCloseButton() {
                    closeButton.style.pointerEvents = 'auto';
                    closeButton.style.opacity = '1';
                }

                // Add event listeners to all input elements to disable the close button on change
                inputs.forEach(function(input) {
                    input.addEventListener('change', function() {
                        disableCloseButton();
                    });
                    input.addEventListener('input', function() {
                        disableCloseButton();
                    });
                });

                // Enable the close button on form load if it is not supposed to be disabled
                if (closeButton) {
                    enableCloseButton();
                }
            });

        </script>
    @endpush
</x-dashboard>
