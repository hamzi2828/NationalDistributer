<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Valuation Report (Sale Wise)</title>
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
                <h1 style="margin: 0">Stock Valuation Report (Sale Wise)</h1>
                <hr>
            </td>
        </tr>
        </tbody>

        @include('invoices.searchCriteria.searchCriteria')

    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">#</th>
        <th align="left">Product</th>
        <th align="left">Available Quantity</th>
        <th align="left">Stock Value (Sale Wise)</th>
    </tr>
    </thead>
    <tbody>
    @php $net = 0; @endphp
    @if(count ($products) > 0)
        @foreach($products as $product)
            @php
                $value = ($product -> stock_value_sale_wise() * $product -> available_quantity());
                $net += $value;
            @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $product -> productTitle() }}</td>
                <td align="left">{{ $product -> available_quantity() }}</td>
                <td align="left">{{ number_format ($value, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td align="center">
            <strong>{{ number_format ($net, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
