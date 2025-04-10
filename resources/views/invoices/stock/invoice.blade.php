<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @if($stock -> stock_type == 'vendor')
            Invoice No# {{ $stock -> invoice_no }}
        @else
            Reference No# {{ $stock -> invoice_no }}
        @endif
    </title>
    <style>
        /* @page {
            size   : auto;
            margin : 15px;
        } */

        @page {
            size : auto;
        margin-top: 20px; 
        margin-bottom: 10px; 
        margin-left: 10px;
        margin-right: 10px; 
         }
        
        body {
            position   : relative;
            margin     : 0 auto;
            color      : #001028;
            background : #FFFFFF;
            font-size  : 10px;
        }
        
        table {
            width           : 100%;
            border-collapse : collapse;
            border-spacing  : 0;
            margin-bottom   : 10px;
        }
        
        table th {
            padding       : 8px 10px;
            color         : #5D6975;
            background    : #F5F5F5;
            border-bottom : 1px solid #C1CED9;
            white-space   : nowrap;
            font-weight   : normal;
            font-size     : 1.1em;
        }
        
        table td {
            padding : 8px 10px;
        }
        
        #header td {
            background : #FFFFFF;
            padding    : 0;
        }
    </style>
</head>
<body>

<header>
    {!! $pdf_header !!}
    <table width="100%" id="header">
        <tbody>
        <tr>
            <td align="center" width="100%">
                @if($stock -> stock_type == 'vendor')
                    <h1 style="margin: 0">Stock Invoice</h1>
                @else
                    <h1 style="margin: 0">Customer Return Invoice</h1>
                @endif
                <hr>
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Vendor: </strong>
                @if($stock -> stock_type == 'vendor')
                    {{ $stock -> vendor -> name }}
                @else
                    {{ $stock -> customer -> name }}
                @endif
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                @if($stock -> stock_type == 'vendor')
                    <strong>Invoice No:</strong>
                    {{ $stock -> invoice_no }}
                @else
                    <strong>Reference No:</strong>
                    {{ $stock -> invoice_no }}
                @endif
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Stock Date:</strong>
                {{ $stock -> stock_date }}
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th align="left">Product</th>
        <th align="center">Quantity</th>
        <th align="center">Cost/Unit</th>
        <th align="center">Sale/Unit</th>
        <th align="center">Price</th>
        <th align="center">Discount</th>
        <th align="center">S.Tax</th>
        <th align="center">Total</th>
    </tr>
    </thead>
    <tbody>
    @php
        $price = 0;
        $net = 0;
        $totalQty = 0;
    @endphp
    @if(count ($attributes) > 0)
        @foreach($attributes as $attribute)
            @php
                $attributeWisePrice = 0;
                $attributeWiseQty = 0;
                $attributeWiseNet = 0;
                $products = explode (',', $attribute -> products);
                $quantities = explode (',', $attribute -> quantities);
                $stock_prices = explode (',', $attribute -> stock_prices);
                $net_prices = explode (',', $attribute -> net_prices);
                $tp_units = explode (',', $attribute -> tp_units);
                $sale_units = explode (',', $attribute -> sale_units);
                $discounts = explode (',', $attribute -> discounts);
                $sale_taxes = explode (',', $attribute -> sale_taxes);
            @endphp
            <tr>
                <td colspan="9" align="left"
                    class="text-danger font-medium-5">
                    <strong>{{ $attribute -> title }}</strong>
                </td>
            </tr>
            @if(count ($products) > 0)
                @foreach($products as $key => $product)
                    @php
                        $price += $stock_prices[$key];
                        $attributeWisePrice += $stock_prices[$key];
                        $net += $net_prices[$key];
                        $attributeWiseNet += $net_prices[$key];
                        $totalQty += $quantities[$key];
                        $attributeWiseQty += $quantities[$key];
                        $productInfo = \App\Models\Product::find($product);
                    @endphp
                    <tr>
                        <td align="center" width="2%">{{ $loop -> iteration }}</td>
                        <td align="left">{{ $productInfo -> productTitle() }}</td>
                        <td align="center">{{ $quantities[$key] }}</td>
                        <td align="center">{{ number_format ($tp_units[$key], 2) }}</td>
                        <td align="center">{{ number_format ($sale_units[$key], 2) }}</td>
                        <td align="center">{{ number_format ($stock_prices[$key], 2) }}</td>
                        <td align="center">{{ number_format ($discounts[$key], 2) }}</td>
                        <td align="center">{{ number_format ($sale_taxes[$key], 2) }}</td>
                        <td align="center">{{ number_format ($net_prices[$key], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"></td>
                    <td align="center">{{ number_format ($attributeWiseQty) }}</td>
                    <td colspan="2"></td>
                    <td align="center">
                        <strong>{{ number_format ($attributeWisePrice, 2) }}</strong>
                    </td>
                    <td colspan="2"></td>
                    <td align="center">
                        <strong>{{ number_format ($attributeWiseNet, 2) }}</strong>
                    </td>
                </tr>
            @endif
        @endforeach
    @endif
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
    
    </tbody>
</table>

<table width="40%" border="1" style="width: 40%; float: right;">
    <tbody>
    <tr>
        <td><strong>Quantity</strong></td>
        <td align="center">{{ number_format ($totalQty) }}</td>
    </tr>
    <tr>
        <td><strong>Price</strong></td>
        <td align="center">{{ number_format ($price, 2) }}</td>
    </tr>
    <tr>
        <td><strong>Total</strong></td>
        <td align="center">{{ number_format ($net, 2) }}</td>
    </tr>
    </tbody>
</table>

@if(!empty(trim ($stock -> description)))
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td>
                <strong><u>Remarks</u></strong>
            </td>
        </tr>
        <tr>
            <td>
                {{ $stock -> description }}
            </td>
        </tr>
        </tbody>
    </table>
@endif

</body>
</html>
