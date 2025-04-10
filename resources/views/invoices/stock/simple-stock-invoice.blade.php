@if(count ($simple_stock -> products) > 0)
    <tr>
        <td colspan="9" align="left"
            class="text-danger font-medium-5">
            <strong>Simple Products Stock</strong>
        </td>
    </tr>
    @foreach($simple_stock -> products as $key => $product)
        @php
            $price += $product -> stock_price;
            $totalQty += $product -> quantity;
            $net += $product -> net_price;
        @endphp
        <tr>
            <td align="center" width="2%">{{ $loop -> iteration }}</td>
            <td align="left">{{ $product -> product -> productTitle() }}</td>
            <td align="center">{{ $product -> quantity }}</td>
            <td align="center">{{ number_format ($product -> tp_unit, 2) }}</td>
            <td align="center">{{ number_format ($product -> sale_unit, 2) }}</td>
            <td align="center">{{ number_format ($product -> stock_price, 2) }}</td>
            <td align="center">{{ number_format ($product -> discount, 2) }}</td>
            <td align="center">{{ number_format ($product -> sale_tax, 2) }}</td>
            <td align="center">{{ number_format ($product -> net_price, 2) }}</td>
        </tr>
    @endforeach
@endif
