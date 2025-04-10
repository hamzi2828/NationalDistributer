<x-dashboard :title="$title">
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
                                <div class="border-bottom-light card-header mb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <form class="form" method="post"
                                      action="{{ route ('stocks.update', ['stock' => $stock -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-2 ps-2 pe-2">
                                        <div class="col-md-4 mb-1">
                                            <label class="col-form-label font-small-4">Warehouse/Branch</label>
                                            <select name="branch-id" class="form-control select2"
                                                    required="required" data-placeholder="Select">
                                                <option></option>
                                                {{-- @if(count ($branches))
                                                    @foreach($branches as $key => $branch)
                                                        <option value="{{ $branch -> id }}"
                                                                @selected(old ('branch-id', $stock -> branch_id) == $branch -> id)>
                                                            {{ $branch -> fullName() }}
                                                        </option>
                                                    @endforeach
                                                @endif --}}
                                                @if(count($branches))
                                                    {
                                                        @php
                                                            $selectedBranch = $branches->firstWhere('id', old('branch-id', $stock->branch_id));
                                                        @endphp

                                                        @if($selectedBranch)
                                                        {
                                                            <option value="{{ $selectedBranch->id }}" selected>
                                                                {{ $selectedBranch->fullName() }}
                                                            </option>
                                                        }
                                                        @endif
                                                    }
                                                    @endif

                                            </select>
                                        </div>
                                        
                                        @if($stock -> stock_type == 'vendor')
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Vendor</label>
                                                <select id="vendors" name="vendor-id" class="form-control select2"
                                                        required="required" data-placeholder="Select"
                                                        onchange="validateInvoiceNo()">
                                                    <option></option>
                                                    {{-- @if(count ($vendors))
                                                        @foreach($vendors as $vendor)
                                                            <option
                                                                    value="{{ $vendor -> id }}" @selected(old ('vendor-id', $stock -> vendor_id) == $vendor -> id)>
                                                                {{ $vendor -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif --}}

                                                    @if(count($vendors))
                                                        {
                                                            @php
                                                                $selectedVendor = $vendors->firstWhere('id', old('vendor-id', $stock->vendor_id));
                                                            @endphp

                                                            @if($selectedVendor)
                                                            {
                                                                <option value="{{ $selectedVendor->id }}" selected>
                                                                    {{ $selectedVendor->name }}
                                                                </option>
                                                            }
                                                            @endif
                                                        }
                                                    @endif

                                                </select>
                                            </div>

                                            {{-- <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Vendor</label>
                                                <input type="text" class="form-control" value="{{ $vendors->firstWhere('id', $stock->vendor_id)->name }}" readonly>
                                            </div> --}}

                                            
                                            
                                        @else
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Customer</label>
                                                <select id="vendors" name="customer-id" class="form-control select2"
                                                        required="required" data-placeholder="Select"
                                                        onchange="validateInvoiceNo()">
                                                    <option></option>
                                                    @if(count ($customers))
                                                        @foreach($customers as $customer)
                                                            <option
                                                                    value="{{ $customer -> id }}" @selected(old ('customer-id', $stock -> customer_id) == $customer -> id)>
                                                                {{ $customer -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        @endif
                                        
                                        <div class="col-md-3 mb-1">
                                            <label class="col-form-label font-small-4">
                                                {{ $stock -> stock_type == 'vendor' ? 'Invoice No' : 'Reference No' }}
                                            </label>
                                            <input type="text" class="form-control"
                                                   required="required"
                                                   name="invoice-no" id="invoice-no" placeholder="Invoice No"
                                                   value="{{ old ('invoice-no', $stock -> invoice_no) }}"
                                                   onchange="validateInvoiceNo()" />
                                        </div>
                                        
                                        <div class="col-md-2 mb-1">
                                            <label class="col-form-label font-small-4">Stock Date</label>
                                            <input type="text" class="form-control flatpickr-basic"
                                                   required="required"
                                                   name="stock-date" placeholder="Stock Date"
                                                   value="{{ old ('stock-date', $stock -> stock_date) }}" />
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-2 ps-1 pe-1">
                                        <div class="col-md-12">
                                            @php
                                                $discount = 0;
                                                $counter = 0;
                                            @endphp
                                            @if(count ($attributes) > 0 || count ($simple_stock -> products) > 0)
                                                @foreach($attributes as $attribute)
                                                    @php
                                                        $id = explode (',', $attribute -> id);
                                                        $products = explode (',', $attribute -> products);
                                                        $quantities = explode (',', $attribute -> quantities);
                                                        $stock_prices = explode (',', $attribute -> stock_prices);
                                                        $net_prices = explode (',', $attribute -> net_prices);
                                                        $tp_units = explode (',', $attribute -> tp_units);
                                                        $sale_units = explode (',', $attribute -> sale_units);
                                                        $discounts = explode (',', $attribute -> discounts);
                                                        $sale_taxes = explode (',', $attribute -> sale_taxes);
                                                        $box_qty = explode (',', $attribute -> box_qty);
                                                        $pack_size = explode (',', $attribute -> pack_size);
                                                        $tp_box = explode (',', $attribute -> tp_box);
                                                        $cost_box = explode (',', $attribute -> cost_box);
                                                        $sale_box = explode (',', $attribute -> sale_box);
                                                        $return_unit = explode (',', $attribute -> return_unit);
                                                        $netQty = 0;
                                                    @endphp
                                                    
                                                    <h3 class="text-danger fw-bolder ps-1">{{ $attribute -> title }}</h3>
                                                    
                                                    @if(count ($products) > 0)
                                                        @foreach($products as $key => $product)
                                                            
                                                            @php
                                                                $discount += $discounts[$key];
                                                                $productInfo = \App\Models\Product::find($product);
                                                                $netQty += $quantities[$key];
                                                            @endphp
                                                            
                                                            <input type="hidden" name="stocks[]"
                                                                   value="{{ $id[$key] }}"
                                                                   id="stock-id-{{ $id[$key] }}">
                                                            <div
                                                                    class="row ps-2 pe-2 mb-2 pt-1 bg-light-secondary position-relative"
                                                                    id="stock-product-id-{{ $id[$key] }}">
                                                                
                                                                <counter
                                                                        class="position-absolute border-black">{{ $loop -> iteration }}</counter>
                                                                
                                                                <a href="javascript:void(0)"
                                                                   data-url="{{ route ('stock.product.delete', ['product_stock' => $id[$key]]) }}"
                                                                   data-stock-product-id="{{ $id[$key] }}"
                                                                   class="position-absolute remove-stock-product"
                                                                   style="top: 12px; left: 5px;">
                                                                    <i data-feather="trash"></i>
                                                                </a>
                                                                
                                                                <div class="form-group col-md-4 mb-1">
                                                                    <label class="mb-25">Product</label>
                                                                    <input type="text" class="form-control"
                                                                           readonly="readonly"
                                                                           value="{{ $productInfo -> productTitle() }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Box Qty</label>
                                                                    <input type="number" min="1"
                                                                           class="form-control box-quantity-{{ $id[$key] }}"
                                                                           name="box-qty[]" required="required"
                                                                           autofocus="autofocus"
                                                                           onchange="calculate_quantity({{ $id[$key] }})"
                                                                           value="{{ old ('box-qty.'.$key, $box_qty[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Pack Size</label>
                                                                    <input type="number"
                                                                           class="form-control pack-size-{{ $id[$key] }}"
                                                                           name="pack-size[]" required="required"
                                                                           onchange="calculate_quantity({{ $id[$key] }})"
                                                                           value="{{ old ('pack-size.'.$key, $pack_size[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Quantity</label>
                                                                    <input type="number"
                                                                           class="form-control quantity-{{ $id[$key] }}"
                                                                           name="quantity[]" required="required"
                                                                           readonly="readonly"
                                                                           value="{{ old ('quantity.'.$key, $quantities[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">TP/Box</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control tp-box-{{ $id[$key] }}"
                                                                           name="tp-box[]" required="required"
                                                                           onchange="calculate_tp_per_unit_price('{{ $id[$key] }}')"
                                                                           value="{{ old ('tp-box.'.$key, $tp_box[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Price</label>
                                                                    <input type="number" readonly="readonly"
                                                                           class="form-control price-{{ $id[$key] }}"
                                                                           name="stock-price[]" required="required"
                                                                           step="0.01"
                                                                           value="{{ old ('stock-price.'.$key, $stock_prices[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Discount (%)</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control discounts discount-{{ $id[$key] }}"
                                                                           name="discount[]" required="required"
                                                                           onchange="calculate_net_bill({{ $id[$key] }})"
                                                                           value="{{ old ('discount.'.$key, $discounts[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">S.Tax (%)</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control s-tax-{{ $id[$key] }}"
                                                                           name="sales-tax[]" required="required"
                                                                           onchange="calculate_net_bill({{ $id[$key] }})"
                                                                           value="{{ old ('sales-tax.'.$key, $sale_taxes[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Net Price</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control net-price net-price-{{ $id[$key] }}"
                                                                           name="net-price[]" required="required"
                                                                           readonly="readonly"
                                                                           value="{{ old ('net-price.'.$key, $net_prices[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Cost/Box</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control cost-box-{{ $id[$key] }}"
                                                                           name="cost-box[]" required="required"
                                                                           value="{{ old ('cost-box.'.$key, $cost_box[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Cost/Unit</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control tp-unit-{{ $id[$key] }}"
                                                                           name="tp-unit[]" required="required"
                                                                           onchange="calculate_total_price({{ $id[$key] }})"
                                                                           value="{{ old ('tp-unit.'.$key, $tp_units[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Sale/Box</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control sale-box-{{ $id[$key] }}"
                                                                           name="sale-box[]" required="required"
                                                                           onchange="calculate_sale_price(this.value, {{ $id[$key] }})"
                                                                           value="{{ old ('sale-box.'.$key, $sale_box[$key]) }}">
                                                                </div>
                                                                
                                                                <div class="form-group col-md-2 mb-1">
                                                                    <label class="mb-25">Sale/Unit</label>
                                                                    <input type="number" step="0.01"
                                                                           class="form-control sale-unit-{{ $id[$key] }}"
                                                                           name="sale-unit[]" required="required"
                                                                           value="{{ old ('sale-unit.'.$key, $sale_units[$key]) }}">
                                                                </div>
                                                                
                                                                @if($stock -> stock_type == 'customer-return')
                                                                    <div class="form-group col-md-2 mb-1">
                                                                        <label class="mb-25">Return/Unit</label>
                                                                        <input type="number" step="0.01"
                                                                               class="form-control return-price return-unit-{{ $id[$key] }}"
                                                                               onchange="calculate_return_unit_price({{ $id[$key] }})"
                                                                               name="return-unit[]" required="required"
                                                                               value="{{ old ('return-unit.'.$key, $return_unit[$key]) }}">
                                                                    </div>
                                                                    
                                                                    <div class="form-group col-md-2 mb-1">
                                                                        <label class="mb-25">Net Return Price</label>
                                                                        <input type="text" step="0.01"
                                                                               readonly="readonly"
                                                                               value="{{ number_format (($quantities[$key] * $return_unit[$key]), 2) }}"
                                                                               class="form-control net-return-price net-return-unit-{{ $id[$key] }}">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                    
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h5 class="text-danger fw-bolder pe-1 mb-2 text-end">
                                                                <strong>{{ $attribute -> title }} Quantity:</strong>
                                                                {{ $netQty }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                
                                                @endforeach
                                                
                                                @include('stocks.simple-stock', ['counter' => $counter, 'simple_stock' => $simple_stock])
                                                
                                                <input type="hidden" id="sum-total" value="{{ $stock -> total }}">
                                                
                                                @if($stock -> stock_type !== 'customer-return')
                                                    <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25 d-none ">
                                                        <label class="mb-25">Discount (%)</label>
                                                        <input type="number" step="0.01" name="net-discount"
                                                               class="form-control net-discount"
                                                               @if($discount > 0) readonly="readonly" @endif
                                                               onchange="calculate_grand_total_discount(this.value)"
                                                               value="{{ old ('net-discount', $stock -> discount) }}">
                                                    </div>
                                                @endif
                                                
                                                <div class="offset-md-9 col-md-3 pe-2 mb-2">
                                                    <label class="mb-25">
                                                        G.Total
                                                        {{ $stock -> stock_type === 'customer-return' ? '(Stock In Amount)' : '' }}
                                                    </label>
                                                    <input type="number" readonly="readonly" step="0.01"
                                                           class="form-control grand-total" name="grand-total"
                                                           value="{{ old ('grand-total', $stock -> total) }}">
                                                </div>
                                                
                                                @if($stock -> stock_type === 'customer-return')
                                                    @php
                                                        $totalReturnAmount = (new \App\Http\Services\StockService()) -> calculate_stock_return_total($stock);
                                                    @endphp
                                                    <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25">
                                                        <label class="mb-25" for="total-return-amount">
                                                            Total Return Amount
                                                        </label>
                                                        <input type="text" id="total-return-amount"
                                                               class="form-control" readonly="readonly"
                                                               value="{{ number_format ($totalReturnAmount, 2) }}">
                                                    </div>
                                                    
                                                    <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25">
                                                        <label class="mb-25" for="return-discount">
                                                            Discount (%) - Return
                                                        </label>
                                                        <input type="number" step="0.01" name="net-discount"
                                                               class="form-control net-discount" id="return-discount"
                                                               onchange="calculate_customer_return_stock_discount(this.value, 'percentage')"
                                                               value="{{ old ('net-discount', $stock -> discount) }}">
                                                    </div>
                                                    
                                                    <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25">
                                                        <label class="mb-25" for="flat-return-discount">
                                                            Discount (Flat) - Return
                                                        </label>
                                                        <input type="number" step="0.01" name="flat-net-discount"
                                                               class="form-control net-discount" id="flat-return-discount"
                                                               onchange="calculate_customer_return_stock_discount(this.value, 'flat')"
                                                               value="{{ old ('flat-net-discount', $stock -> flat_discount) }}">
                                                    </div>
                                                @endif
                                                
                                                @if($stock -> stock_type == 'customer-return')
                                                    <div class="offset-md-9 col-md-3 pe-2 mb-2">
                                                        <label class="mb-25">Paid To Customer</label>
                                                        <input type="text" readonly="readonly" step="0.01"
                                                               class="form-control return-grand-total" min="0" max="100"
                                                               value="{{ number_format ($stock -> return_net, 2) }}">
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($stock -> stock_type != 'vendor')
                                        <div class="row ps-2 pe-2">
                                            <div class="col-md-12 mb-1">
                                                <label>Description</label>
                                                <textarea name="description" class="form-control"
                                                          maxlength="100" placeholder="Description"
                                                          rows="2">{{ old ('description', $stock -> description) }}</textarea>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                        <button type="button" class="btn btn-outline-dark me-1"
                                                onclick="addMoreStockProduct('{{ route ('products.add-more-stock-product', ['stock' => $stock -> id]) }}')">
                                            Add More
                                        </button>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-warning waves-effect waves-light">
                                                Add New Product
                                            </button>
                                            <button type="button"
                                                    class="btn btn-warning dropdown-toggle dropdown-toggle-split waves-effect waves-light"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Add New Product</span>
                                            </button>
                                            <ul class="dropdown-menu" style="">
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                       onclick="addNewProduct('{{ route ('products.add-new-product') }}', 'simple')">
                                                        Simple Product
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                       onclick="addNewProduct('{{ route ('products.add-new-product') }}', 'variable')">
                                                        Variable Product
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
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
