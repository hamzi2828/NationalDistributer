@if(!empty($product))
    <tr class="sale-product-{{ $product -> id }}">
        <input type="hidden" name="products[]" value="{{ $product -> id }}">
        <td>
            <span class="d-flex w-100 justify-content-center align-items-center fw-bold">{{ ($row + 1) }}</span>
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
                   data-product-id="{{ $product -> id }}" onchange="sale_quantity({{ $product -> id }})"
                   required="required" value="{{ $product -> available_quantity() > 0 ? 1 : 0 }}"
                   placeholder="Quantity" min="0">
        </td>

        {{-- <td class="product-price-{{ $product -> id }}">
            <input class="form-control" readonly="readonly">
        </td> --}}

        <td class="product-price-{{ $product -> id }}">
            <input type="number" class="form-control product-price-{{ $product -> id }}"  name="price[]"
                   data-product-id="{{ $product -> id }}" onchange="update_sale_price({{ $product -> id }})"
                   placeholder="Price" value="0" min="0" step="0.01">
        </td>

        {{-- <td>
            <input type="number" class="form-control discount-{{ $product -> id }}" name="discount[]"
                   data-product-id="{{ $product -> id }}" onchange="sale_discount({{ $product -> id }})"
                   placeholder="Discount" value="0" min="0" step="0.01">
        </td> --}}



        <td class="product-net-price-{{ $product -> id }}">
            <input class="net-price form-control" readonly="readonly">
        </td>
    </tr>
@endif
