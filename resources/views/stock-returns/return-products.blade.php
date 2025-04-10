@if(!empty($product))
    <tr class="sale-product-{{ $product -> id }}">
        <input type="hidden" name="products[]" value="{{ $product -> id }}">
        <td>
            <a href="javascript:void(0)" data-product-id="{{ $product -> id }}" class="remove-sale-product">
                <i data-feather="trash-2"></i>
            </a>
        </td>
        
        <td>{{ $product -> productTitle() }}</td>
        
        <td>
            <input class="form-control available-qty-{{ $product -> id }}" readonly="readonly"
                   value="{{ $product -> available_quantity() }}">
        </td>
        
        <td>
            <input type="number" class="form-control sale-qty-{{ $product -> id }}" name="quantity[]"
                   data-product-id="{{ $product -> id }}"
                   onchange="calculate_vendor_return_product_price({{ $product -> id }})"
                   required="required" value="1"
                   placeholder="Quantity" min="0">
        </td>
        
        <td class="product-price-{{ $product -> id }}">
            <input class="form-control" type="number" step="0.01" required="required" name="tp_unit[]"
                   id="product-price-{{ $product -> id }}"
                   onchange="calculate_vendor_return_product_price({{ $product -> id }})">
        </td>
        
        <td class="product-net-price-{{ $product -> id }}">
            <input class="net-price form-control" readonly="readonly" id="product-net-price-{{ $product -> id }}">
        </td>
    </tr>
@endif