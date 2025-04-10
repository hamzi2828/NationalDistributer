<div class="col-md-12" id="row-{{ $product -> id }}">
    <input type="hidden" name="product[]" value="{{ $product -> id }}">
    <div
            class="row ps-2 pe-2 mb-2 pt-1 bg-light-secondary position-relative"
            id="stock-product-id-{{ $product -> id }}">
        
        <counter class="position-absolute border-black">{{ $row }}</counter>
        
        <a href="javascript:void(0)"
           onclick="removeStockRow({{ $product -> id }})"
           class="position-absolute"
           style="top: 12px; left: 5px;">
            <i data-feather="trash"></i>
        </a>
        
        <div class="form-group col-md-4 mb-1">
            <label class="mb-25" for="product-{{ $product -> id }}">Product</label>
            <input type="text" class="form-control"
                   readonly="readonly" id="product-{{ $product -> id }}"
                   value="{{ $product -> productTitle() }}">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="box-qty-{{ $product -> id }}">Box Qty</label>
            <input type="number" min="1" id="box-qty-{{ $product -> id }}"
                   class="form-control box-quantity-{{ $product -> id }}"
                   name="box-qty[]" required="required"
                   autofocus="autofocus"
                   onchange="calculate_quantity({{ $product -> id }})">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="pack-size-{{ $product -> id }}">Pack Size</label>
            <input type="number" id="pack-size-{{ $product -> id }}"
                   class="form-control pack-size-{{ $product -> id }}"
                   name="pack-size[]" required="required"
                   onchange="calculate_quantity({{ $product -> id }})"
                   value="{{ $product -> pack_size }}">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="quantity-{{ $product -> id }}">Quantity</label>
            <input type="number" id="quantity-{{ $product -> id }}"
                   class="form-control quantity-{{ $product -> id }}"
                   name="quantity[]" required="required"
                   readonly="readonly">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="tp-box-{{ $product -> id }}">TP/Box</label>
            <input type="number" step="0.01" id="tp-box-{{ $product -> id }}"
                   class="form-control tp-box-{{ $product -> id }}"
                   name="tp-box[]" required="required"
                   onchange="calculate_tp_per_unit_price('{{ $product -> id }}')"
                   value="{{ $product -> tp_box }}">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="price-{{ $product -> id }}">Price</label>
            <input type="number" readonly="readonly" id="price-{{ $product -> id }}"
                   class="form-control price-{{ $product -> id }}"
                   name="stock-price[]" required="required"
                   step="0.01">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="discount-percentage-{{ $product -> id }}">Discount (%)</label>
            <input type="number" step="0.01" id="discount-percentage-{{ $product -> id }}"
                   class="form-control discounts discount-{{ $product -> id }}"
                   name="discount[]" required="required" value="0"
                   onchange="calculate_net_bill({{ $product -> id }})">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="sales-tax-{{ $product -> id }}">S.Tax (%)</label>
            <input type="number" step="0.01" id="sales-tax-{{ $product -> id }}"
                   class="form-control s-tax-{{ $product -> id }}"
                   name="sales-tax[]" required="required" value="0"
                   onchange="calculate_net_bill({{ $product -> id }})">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="net-price-{{ $product -> id }}">Net Price</label>
            <input type="number" step="0.01" id="net-price-{{ $product -> id }}"
                   class="form-control net-price net-price-{{ $product -> id }}"
                   name="net-price[]" required="required"
                   readonly="readonly">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="cost-box-{{ $product -> id }}">Cost/Box</label>
            <input type="number" step="0.01" id="cost-box-{{ $product -> id }}"
                   class="form-control cost-box-{{ $product -> id }}"
                   name="cost-box[]" required="required">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="tp-unit-{{ $product -> id }}">Cost/Unit</label>
            <input type="number" step="0.01" id="tp-unit-{{ $product -> id }}"
                   class="form-control tp-unit-{{ $product -> id }}"
                   name="tp-unit[]" required="required"
                   onchange="calculate_total_price({{ $product -> id }})">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="sale-box-{{ $product -> id }}">Sale/Box</label>
            <input type="number" step="0.01" id="sale-box-{{ $product -> id }}"
                   class="form-control sale-box-{{ $product -> id }}"
                   name="sale-box[]" required="required"
                   onchange="calculate_sale_price(this.value, {{ $product -> id }})"
                   value="{{ $product -> sale_box }}">
        </div>
        
        <div class="form-group col-md-2 mb-1">
            <label class="mb-25" for="sale-unit-{{ $product -> id }}">Sale/Unit</label>
            <input type="number" step="0.01" id="sale-unit-{{ $product -> id }}"
                   class="form-control sale-unit-{{ $product -> id }}"
                   name="sale-unit[]" required="required"
                   value="{{ $product -> sale_unit }}">
        </div>
    </div>
</div>