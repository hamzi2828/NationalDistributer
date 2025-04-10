<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Analysis Report (Purchase)</title>
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
                <h1 style="margin: 0">Analysis Report (Purchase)</h1>
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
        <th>#</th>
        <th align="left">Vendor</th>
        <th align="left">Invoice</th>
        <th align="left">Products</th>
        <th align="left">Quantity</th>
        <th align="left">Price/Qty</th>
        <th align="left">Net Price</th>
        <th align="left">Date Added</th>
    </tr>
    </thead>
    <tbody style="vertical-align: baseline;">
    @php
        $net = 0;
        $totalQuantity = 0;
    @endphp
    @if(count($stocks) > 0)
        @foreach($stocks as $stock)
            @php
                $stock_net = 0;
            @endphp
            @if(count($stock->products) > 0)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>{{ $stock->vendor->name }}</td>
                    <td>{{ $stock->invoice_no }}</td>
                    <td>
                        @foreach($stock->products as $product)
                            @php
                                $net += $product->net_price;
                                $stock_net += $product->net_price;
                            @endphp
                            {{ $product->product->productTitle() }} <br />
                        @endforeach
                    </td>
                    <td>
                        @foreach($stock->products as $product)
                            @php
                                $totalQuantity += $product->quantity;
                            @endphp
                            {{ $product->quantity }} <br />
                        @endforeach
                    </td>
                    <td>
                        @foreach($stock->products as $product)
                            {{ number_format($product->tp_box, 2) }} <br />
                        @endforeach
                    </td>
                    <td>{{ number_format($stock_net, 2) }}</td>
                    <td>{{ $stock->created_at }}</td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"></td>
        <td><strong>{{ $totalQuantity }}</strong></td>
        <td colspan="1"></td>
        <td><strong>{{ number_format($net, 2) }}</strong></td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>
