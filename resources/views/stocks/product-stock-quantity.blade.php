@if(!empty($product))
    <tr class="sale-product-{{ $product -> id }}">
        <td>{{ $product -> productTitle() }}</td>

        <td>
            <input class="form-control available-qty-{{ $product -> id }}" readonly="readonly"
                   value="{{ $product -> available_quantity() }}">
        </td>
    </tr>
@endif
