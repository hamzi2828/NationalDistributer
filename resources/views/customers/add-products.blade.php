@if(isset($products) && count($products) > 0)
    @foreach($products as $product)
        <tr class="sale-product-{{ $product -> id }}">
            <input type="hidden" name="products[]" value="{{ $product -> id }}">
            <td>
                <a href="javascript:void(0)" data-product-id="{{ $product -> id }}" class="remove-sale-product">
                    <i data-feather="trash-2"></i>
                </a>
            </td>

            <td>{{ $product -> productTitle() }}</td>

            <td>{{ number_format ($product -> sale_unit, 2) }}</td>

            <td>
                <input class="form-control customer-product" type="number" step="0.01" name="price[]" required="required">
            </td>
        </tr>
    @endforeach
@endif