<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reference No# {{ $stock_return -> reference_no }}</title>
    <style>
        /* @page {
            margin : 15px;
            size   : auto;
        }
         */
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
                <h1 style="margin: 0">Vendor Return Invoice</h1>
                <hr>
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Vendor: </strong>
                {{ $stock_return -> vendor -> name }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Reference No:</strong>
                {{ $stock_return -> reference_no }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Stock Date:</strong>
                {{ $stock_return -> created_at }}
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
        <th align="center">Return TP/Unit</th>
        <th align="center">Net Price</th>
    </tr>
    </thead>
    <tbody>
    @php
        $price = 0;
        $net = 0;
        $netQty = 0;
    @endphp
    @if(count ($stock_return -> products) > 0)
        @foreach($stock_return -> products as $product)
            @php
                $price = $price + $product -> stock_price;
                $net = $net + $product -> net_price;
                $netQty += $product -> quantity;
            @endphp
            <tr>
                <td align="center" width="2%">{{ $loop -> iteration }}</td>
                <td align="left">{{ $product -> product -> productTitle() }}</td>
                <td align="center">{{ $product -> quantity }}</td>
                <td align="center">{{ number_format ($product -> tp_unit, 2) }}</td>
                <td align="center">{{ number_format ($product -> net_price, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td align="center">
            <strong>{{ $netQty }}</strong>
        </td>
        <td></td>
        <td align="center">
            <strong>{{ number_format ($net, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>

<table width="50%" border="1" style="width: 40%; float: right;">
    <tbody>
    <tr>
        <td align="right"><strong>Total</strong></td>
        <td align="center">{{ number_format ($stock_return -> net_price, 2) }}</td>
    </tr>
    @if($stock_return -> discount > 0)
        <tr>
            <td align="right">
                <strong>Discount (Flat)</strong> <br />
                <strong style="color: #FF0000">
                    Entries are not being recorded in GL.
                </strong>
            </td>
            <td align="center">{{ number_format ($stock_return -> discount, 2) }}</td>
        </tr>
    @endif
    <tr>
        <td align="right"><strong>Net</strong></td>
        <td align="center">{{ number_format ($stock_return -> price, 2) }}</td>
    </tr>
    </tbody>
</table>

@if(!empty(trim ($stock_return -> description)))
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td>
                <strong><u>Remarks</u></strong>
            </td>
        </tr>
        <tr>
            <td>
                {{ $stock_return -> description }}
            </td>
        </tr>
        </tbody>
    </table>
@endif

</body>
</html>
