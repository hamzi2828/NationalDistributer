@if(count ($simple_stock -> products) > 0)
    <h3 class="text-danger fw-bolder ps-1">Simple Products</h3>
    @foreach($simple_stock -> products as $key => $product)
        @php
            $counter++;
            $discount += $product -> discount;
            $productInfo = \App\Models\Product::find($product -> product_id);
        @endphp
        
        <input type="hidden" name="stocks[]"
               value="{{ $product -> id }}"
               id="stock-id-{{ $product -> id }}">
        <div
                class="row ps-2 pe-2 mb-2 pt-1 bg-light-secondary position-relative"
                id="stock-product-id-{{ $product -> id }}">
            
            <counter
                    class="position-absolute border-black">{{ $loop -> iteration }}</counter>
            
            @if($product -> sold_quantity() < 1)
                <a href="javascript:void(0)"
                   data-url="{{ route ('stock.product.delete', ['product_stock' => $product -> id]) }}"
                   data-stock-product-id="{{ $product -> id }}"
                   class="position-absolute remove-stock-product"
                   style="top: 12px; left: 5px;">
                    <i data-feather="trash"></i>
                </a>
            @endif
            
            <div class="form-group col-md-4 mb-1">
                <label class="mb-25">Product</label>
                <input type="text" class="form-control"
                       readonly="readonly"
                       value="{{ $productInfo -> productTitle() }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Box Qty</label>
                <input type="number" min="1"
                       class="form-control box-quantity-{{ $product -> id }}"
                       name="box-qty[]" required="required"
                       autofocus="autofocus"
                       @if($product -> sold_quantity() > 0) readonly="readonly" @endif
                       onchange="calculate_quantity({{ $product -> id }})"
                       value="{{ old ('box-qty.'.$counter, $product -> box_qty) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Pack Size</label>
                <input type="number"
                       class="form-control pack-size-{{ $product -> id }}"
                       name="pack-size[]" required="required"
                       onchange="calculate_quantity({{ $product -> id }})"
                       value="{{ old ('pack-size.'.$counter, $product -> pack_size) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Quantity</label>
                <input type="number"
                       class="form-control quantity-{{ $product -> id }}"
                       name="quantity[]" required="required"
                       readonly="readonly"
                       value="{{ old ('quantity.'.$counter, $product -> quantity) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">TP/Box</label>
                <input type="number" step="0.01"
                       class="form-control tp-box-{{ $product -> id }}"
                       name="tp-box[]" required="required"
                       onchange="calculate_tp_per_unit_price('{{ $product -> id }}')"
                       value="{{ old ('tp-box.'.$counter, $product -> tp_box) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Price</label>
                <input type="number" readonly="readonly"
                       class="form-control price-{{ $product -> id }}"
                       name="stock-price[]" required="required"
                       step="0.01"
                       value="{{ old ('stock-price.'.$counter, $product -> stock_price) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Discount (%)</label>
                <input type="number" step="0.01"
                       class="form-control discounts discount-{{ $product -> id }}"
                       name="discount[]" required="required"
                       onchange="calculate_net_bill({{ $product -> id }})"
                       value="{{ old ('discount.'.$counter, $product -> discount) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">S.Tax (%)</label>
                <input type="number" step="0.01"
                       class="form-control s-tax-{{ $product -> id }}"
                       name="sales-tax[]" required="required"
                       onchange="calculate_net_bill({{ $product -> id }})"
                       value="{{ old ('sales-tax.'.$counter, $product -> sale_tax) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Net Price</label>
                <input type="number" step="0.01"
                       class="form-control net-price net-price-{{ $product -> id }}"
                       name="net-price[]" required="required"
                       readonly="readonly"
                       value="{{ old ('net-price.'.$counter, $product -> net_price) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Cost/Box</label>
                <input type="number" step="0.01"
                       class="form-control cost-box-{{ $product -> id }}"
                       name="cost-box[]" required="required"
                       value="{{ old ('cost-box.'.$counter, $product -> cost_box) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Cost/Unit</label>
                <input type="number" step="0.01"
                       class="form-control tp-unit-{{ $product -> id }}"
                       name="tp-unit[]" required="required"
                       onchange="calculate_total_price({{ $product -> id }})"
                       value="{{ old ('tp-unit.'.$counter, $product -> tp_unit) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Sale/Box</label>
                <input type="number" step="0.01"
                       class="form-control sale-box-{{ $product -> id }}"
                       name="sale-box[]" required="required"
                       onchange="calculate_sale_price(this.value, {{ $product -> id }})"
                       value="{{ old ('sale-box.'.$counter, $product -> sale_box) }}">
            </div>
            
            <div class="form-group col-md-2 mb-1">
                <label class="mb-25">Sale/Unit</label>
                <input type="number" step="0.01"
                       class="form-control sale-unit-{{ $product -> id }}"
                       name="sale-unit[]" required="required"
                       value="{{ old ('sale-unit.'.$counter, $product -> sale_unit) }}">
            </div>
            
            @if($stock -> stock_type == 'customer-return')
                <div class="form-group col-md-2 mb-1">
                    <label class="mb-25">Return/Unit</label>
                    <input type="number" step="0.01"
                           class="form-control return-price return-unit-{{ $product -> id }}"
                           onchange="calculate_return_unit_price({{ $product -> id }})"
                           name="return-unit[]" required="required"
                           value="{{ old ('return-unit.'.$counter, $product -> return_unit) }}">
                </div>
                
                <div class="form-group col-md-2 mb-1">
                    <label class="mb-25">Net Return Price</label>
                    <input type="text" step="0.01"
                           readonly="readonly"
                           value="{{ number_format (($product -> quantity * $product -> return_unit), 2) }}"
                           class="form-control net-return-price net-return-unit-{{ $product -> id }}">
                </div>
            @endif
        </div>
    @endforeach
@endif
