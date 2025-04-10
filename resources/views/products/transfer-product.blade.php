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
                   data-product-id="{{ $product -> id }}" onchange="transfer_quantity({{ $product -> id }})"
                   required="required"
                   placeholder="Quantity" min="0">
        </td>
    </tr>
@endif