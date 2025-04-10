<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analysis Report (Sale)</title>
    <style>
        /* @page {
            size   : auto;
            margin : 15px;

            margin-top: 70px;
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
                <h1 style="margin: 0">Analysis Report (Sale)</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th align="left">Customer</th>
        <th align="left">Invoice</th>
        <th align="left">Products</th>
        <th align="left">Quantity</th>
        <th align="left">Price/Qty</th>
        <th align="left">Discount (%)</th>
        <th align="left">Net Price</th>
        <th align="left">Date Added</th>
    </tr>
    </thead>
    <tbody style="vertical-align: baseline;">
    @php $net = 0;
         $total_qty = 0; @endphp
    @if(count ($sales) > 0)
        @foreach($sales as $sale)
            @php $net += $sale -> net_price; 
                 $total_qty += $sale -> quantity;@endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $sale -> sale ?-> customer ?-> name }}</td>
                <td align="left">{{ $sale -> sale_id }}</td>
                <td align="left">{{ $sale -> product ?-> productTitle() }}</td>
                <td align="left">{{ $sale -> quantity }}</td>
                <td align="left">{{ number_format ($sale -> price, 2) }}</td>
                <td align="left">{{ number_format ($sale -> discount, 2) }}</td>
                <td align="left">{{ number_format ($sale -> net_price, 2) }}</td>
                <td align="left">{{ $sale -> sale ?-> closed_at }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td colspan="1"><strong>Total</strong></td>

        <td align="left">
            <strong>{{ number_format ($total_qty, 2) }}</strong>
        </td>
        <td></td>
        <td></td>
        <td align="left">
            <strong>{{ number_format ($net, 2) }}</strong>
        </td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
