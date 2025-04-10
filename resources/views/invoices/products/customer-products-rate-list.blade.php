<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Products Rate List</title>
    <style>
        /* @page {
            size: auto;
        } */

        @page {
            size : auto;
        margin-top: 20px; 
        margin-bottom: 10px; 
        margin-left: 10px;
        margin-right: 10px; 
         }
        body {
            position: relative;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 10px;
        }

        table th {
            padding: 8px 10px;
            color: #5D6975;
            background: #F5F5F5;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
            font-size: 1.1em;
        }

        table td {
            padding: 8px 10px;
        }

        #header td {
            background: #FFFFFF;
            padding: 0;
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
                <h1 style="margin: 0">Customer Products Rate List</h1>
                <hr>
            </td>
        </tr>

        <tr>
            <td width="50%" align="left">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Customer Name:</strong>
                            {{  $customer -> name }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Email:</strong>
                            {{ $customer -> email }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Mobile:</strong>
                            {{ $customer -> mobile }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Address:</strong>
                            {{ $customer -> address }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th align="left">Product</th>
        <th>Price</th>
    </tr>
    </thead>
    <tbody>
    @if(count ($prices) > 0)
        @foreach($prices as $price)
            @php
                $products = explode (',', $price -> products);
                $prices = explode (',', $price -> prices);
            @endphp
            <tr>
                <td></td>
                <td align="left" colspan="2" style="color: #FF0000;">
                    <strong>{{ $price -> title }}</strong>
                </td>
            </tr>
            @if(count ($products) > 0)
                @foreach($products as $key => $product_id)
                    @php $product = \App\Models\Product::find($product_id) @endphp
                    <tr>
                        <td align="center">
                            <span>{{ $loop -> iteration }}</span>
                        </td>

                        <td align="left">
                            {{ $product -> productTitle() }}
                        </td>

                        <td align="center">{{ number_format ($prices[$key], 2) }}</td>
                    </tr>
                @endforeach
            @endif
        @endforeach
    @endif
    @if(count ($simple_products_prices) > 0)
        <tr>
            <td></td>
            <td align="left" colspan="2" style="color: #FF0000;">
                <strong>Simple Products</strong>
            </td>
        </tr>
        @foreach($simple_products_prices as $simple_products_price)
            <tr>
                <td align="center"> {{ $loop -> iteration }} </td>

                <td align="left">
                    {{ $simple_products_price -> product -> productTitle() }}
                </td>

                <td align="center"> {{ $simple_products_price -> price }} </td>
            </tr>
        @endforeach
    @endif
    </tbody>
</table>
</body>
</html>
