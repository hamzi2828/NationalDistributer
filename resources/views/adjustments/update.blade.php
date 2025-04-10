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
                                      action="{{ route ('adjustments.update', ['adjustment' => $stock -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            @php $discount = 0; @endphp
                                            @if(count ($stock -> products) > 0)
                                                @foreach($stock -> products as $key => $products)
                                                    @php $discount = $discount + $products -> discount; @endphp
                                                    <input type="hidden" name="stocks[]"
                                                           value="{{ $products -> id }}"
                                                           id="stock-id-{{ $products -> id }}">
                                                    
                                                    <div class="row ps-2 pe-2 mb-2 pt-1 bg-light-secondary position-relative"
                                                         id="stock-product-id-{{ $products -> id }}">
                                                        
                                                        <counter
                                                                class="position-absolute border-black">{{ $loop -> iteration }}</counter>
                                                        
                                                        <a href="javascript:void(0)"
                                                           data-url="{{ route ('stock.product.delete', ['product_stock' => $products -> id]) }}"
                                                           data-stock-product-id="{{ $products -> id }}"
                                                           class="position-absolute remove-stock-product"
                                                           style="top: 12px; left: 5px;">
                                                            <i data-feather="trash"></i>
                                                        </a>
                                                        
                                                        <div class="form-group col-md-4 mb-1">
                                                            <label class="mb-25">Product</label>
                                                            <input type="text" class="form-control" readonly="readonly"
                                                                   value="{{ $products -> product -> productTitle() }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Box Qty</label>
                                                            <input type="number" min="1"
                                                                   class="form-control box-quantity-{{ $products -> product_id }}"
                                                                   name="box-qty[]" required="required"
                                                                   autofocus="autofocus"
                                                                   onchange="calculate_quantity({{ $products -> product_id }})"
                                                                   value="{{ old ('box-qty.'.$key, $products -> box_qty) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Pack Size</label>
                                                            <input type="number"
                                                                   class="form-control pack-size-{{ $products -> product_id }}"
                                                                   name="pack-size[]" required="required"
                                                                   onchange="calculate_quantity({{ $products -> product_id }})"
                                                                   value="{{ old ('pack-size.'.$key, $products -> pack_size) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Quantity</label>
                                                            <input type="number"
                                                                   class="form-control quantity-{{ $products -> product_id }}"
                                                                   name="quantity[]" required="required"
                                                                   readonly="readonly"
                                                                   value="{{ old ('quantity.'.$key, $products -> quantity) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">TP/Box</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control tp-box-{{ $products -> product_id }}"
                                                                   name="tp-box[]" required="required"
                                                                   onchange="calculate_tp_per_unit_price('{{ $products -> product_id }}')"
                                                                   value="{{ old ('tp-box.'.$key, $products -> tp_box) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Price</label>
                                                            <input type="number" readonly="readonly"
                                                                   class="form-control price-{{ $products -> product_id }}"
                                                                   name="stock-price[]" required="required" step="0.01"
                                                                   value="{{ old ('stock-price.'.$key, $products -> stock_price) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Discount (%)</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control discounts discount-{{ $products -> product_id }}"
                                                                   name="discount[]" required="required"
                                                                   onchange="calculate_net_bill({{ $products -> product_id }})"
                                                                   value="{{ old ('discount.'.$key, $products -> discount) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">S.Tax (%)</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control s-tax-{{ $products -> product_id }}"
                                                                   name="sales-tax[]" required="required"
                                                                   onchange="calculate_net_bill({{ $products -> product_id }})"
                                                                   value="{{ old ('sales-tax.'.$key, $products -> sale_tax) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Net Price</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control net-price net-price-{{ $products -> product_id }}"
                                                                   name="net-price[]" required="required"
                                                                   readonly="readonly"
                                                                   value="{{ old ('net-price.'.$key, $products -> net_price) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Cost/Box</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control cost-box-{{ $products -> product_id }}"
                                                                   name="cost-box[]" required="required"
                                                                   value="{{ old ('cost-box.'.$key, $products -> cost_box) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Cost/Unit</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control tp-unit-{{ $products -> product_id }}"
                                                                   name="tp-unit[]" required="required"
                                                                   onchange="calculate_total_price({{ $products -> product_id }})"
                                                                   value="{{ old ('tp-unit.'.$key, $products -> tp_unit) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Sale/Box</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control sale-box-{{ $products -> product_id }}"
                                                                   name="sale-box[]" required="required"
                                                                   onchange="calculate_sale_price(this.value, {{ $products -> product_id }})"
                                                                   value="{{ old ('sale-box.'.$key, $products -> sale_box) }}">
                                                        </div>
                                                        
                                                        <div class="form-group col-md-2 mb-1">
                                                            <label class="mb-25">Sale/Unit</label>
                                                            <input type="number" step="0.01"
                                                                   class="form-control sale-unit-{{ $products -> product_id }}"
                                                                   name="sale-unit[]" required="required"
                                                                   value="{{ old ('sale-unit.'.$key, $products -> sale_unit) }}">
                                                        </div>
                                                        
                                                        @if($stock -> stock_type == 'customer-return')
                                                            <div class="form-group col-md-2 mb-1">
                                                                <label class="mb-25">Return/Unit</label>
                                                                <input type="number" step="0.01"
                                                                       class="form-control return-price return-unit-{{ $products -> product_id }}"
                                                                       onchange="calculate_return_unit_price({{ $products -> product_id }})"
                                                                       name="return-unit[]" required="required"
                                                                       value="{{ old ('return-unit.'.$key, $products -> return_unit) }}">
                                                            </div>
                                                            
                                                            <div class="form-group col-md-2 mb-1">
                                                                <label class="mb-25">Net Return Price</label>
                                                                <input type="text" step="0.01" readonly="readonly"
                                                                       value="{{ number_format (($products -> quantity * $products -> return_unit), 2) }}"
                                                                       class="form-control net-return-price net-return-unit-{{ $products -> product_id }}">
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                                
                                                <input type="hidden" id="sum-total" value="{{ $stock -> total }}">
                                                
                                                <div class="offset-md-9 col-md-3 mb-1 pe-2 pb-25">
                                                    <label class="mb-25">Discount (%)</label>
                                                    <input type="number" step="0.01" name="net-discount"
                                                           class="form-control net-discount"
                                                           @if($discount > 0) readonly="readonly" @endif
                                                           onchange="calculate_grand_total_discount(this.value)"
                                                           value="{{ old ('net-discount', $stock -> discount) }}">
                                                </div>
                                                <div class="offset-md-9 col-md-3 pe-2 mb-2">
                                                    <label class="mb-25">G.Total</label>
                                                    <input type="number" readonly="readonly" step="0.01"
                                                           class="form-control grand-total" name="grand-total"
                                                           value="{{ old ('grand-total', ($stock -> discount > 0 ? ($stock -> total - (($stock -> total * $stock -> discount) / 100)) : $stock -> total)) }}">
                                                </div>
                                                @if($stock -> stock_type == 'customer-return')
                                                    <div class="offset-md-9 col-md-3 pe-2 mb-2">
                                                        <label class="mb-25">Return G.Total</label>
                                                        <input type="text" readonly="readonly" step="0.01"
                                                               class="form-control return-grand-total"
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
