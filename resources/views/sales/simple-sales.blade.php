@php $quantity = 0; @endphp
@if(count ($simple_sales) > 0)
    <tr>
        <td colspan="4" align="left"
            class="text-danger font-medium-5">
            <strong>Simple Products</strong>
        </td>
    </tr>
    @foreach($simple_sales as $simple_sale)
        @php
            $product = \App\Models\Product::find($simple_sale -> product_id);
            $available = $product -> available_quantity();
            $class = null;

            if ($available - $product -> quantity < 1 )
                @$available = $available + $product -> quantity;

            if ($available < 1)
                $class = 'zero-record';

            $quantity += $simple_sale -> quantity;
        @endphp
        <tr class="sale-product-{{ $product -> id }} {{ $class }}">
            <input type="hidden" name="products[]"
                   value="{{ $product -> id }}">
            <td>
                <span
                    class="d-flex w-100 justify-content-center align-items-center fw-bold">{{ $loop -> iteration }}</span>
                <a href="javascript:void(0)"
                   data-product-id="{{ $product -> id }}"
                   class="remove-sale-product">
                    <i data-feather="trash-2"></i>
                </a>
            </td>

            <td>{{ $product -> productTitle() }}</td>

            <td>
                <input class="form-control available-qty-{{ $product -> id }}"
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
                       value="{{ $simple_sale -> quantity }}"
                       placeholder="Quantity" min="0">
            </td>

            <td class="product-price-{{ $product -> id }}">
                <input class="form-control"
                       readonly="readonly"
                       value="{{ number_format (($simple_sale -> price/$simple_sale -> noOfRows), 2) }}">
            </td>

            <td class="product-net-price-{{ $product -> id }}">
                <input class="net-price form-control"
                       readonly="readonly"
                       value="{{ number_format(($simple_sale -> net_price), 2) }}">
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="3"></td>
        <td>
            <input type="text" class="form-control" disabled="disabled" value="{{ number_format ($quantity) }}">
        </td>
    </tr>
@endif
