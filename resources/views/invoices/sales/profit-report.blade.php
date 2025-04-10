<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profit Report</title>
    <style>
        /* @page {
            size   : auto;
            margin : 15px;
            margin-top: 70px; 
        } */
        
        @page {
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
                <h1 style="margin: 0">Profit Report</h1>
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
        <th align="left">#</th>
        <th align="left">Sale ID</th>
        <th align="left">Customer</th>
        <th align="left">Quantity</th>
        <th align="left">Price</th>
        <th align="left">Discount (%)</th>
        <th align="left">Discount (Flat)</th>
        <th align="left">Net Price</th>
        <th align="left">Profit (Before Disc.)</th>
        <th align="left">Profit (After Disc.)</th>
        <th align="left">Dated Added</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalQty = 0;
        $totalPrice = 0;
        $totalNetPrice = 0;
        $profit = 0;
    @endphp
    @if(count ($sales) > 0)
        @foreach($sales as $sale)
            @php
                $products = explode (',', $sale -> products);
                $stocks = explode (',', $sale -> stocks);
                                                    $quantities = explode (',', $sale -> quantities);
                $totalQty = $totalQty + $sale -> sale -> sold_quantity();
                $totalPrice = $totalPrice + $sale -> sale -> total;
                $totalNetPrice = $totalNetPrice + $sale -> sale -> net;
                $gross_profit = 0;
            @endphp
            <tr>
                <td>{{ $loop -> iteration }}</td>
                <td>{{ $sale -> sale_id }}</td>
                <td>{{ $sale -> sale -> customer -> name }}</td>
                <td>{{ $sale -> sale -> sold_quantity() }}</td>
                <td>{{ number_format ($sale -> sale -> total, 2) }}</td>
                <td>{{ number_format ($sale -> sale -> percentage_discount, 2)	 }}</td>
                <td>{{ number_format ($sale -> sale -> flat_discount, 2)	 }}</td>
                <td>{{ number_format ($sale -> sale -> net, 2) }}</td>
                <td>
                    @if(count ($stocks) > 0)
                        @foreach($stocks as $key => $stock_id)
                            @php
                                $stock = \App\Models\ProductStock::find($stock_id);
                            @endphp
                            @if(!empty($stock))
                                @php
                                    $customerPrice = \App\Models\CustomerProductPrice::where(['product_id' => $stock -> product_id, 'customer_id' => $sale -> sale -> customer -> id]) -> first();
                                    
                                    $unit_price = $stock -> sale_unit - $stock -> tp_unit;
                                    if(!empty($customerPrice))
                                        $unit_price = $customerPrice -> price - $stock -> tp_unit;
                                    
                                    $gross_profit = $gross_profit + ($unit_price * $quantities[$key]);
                                @endphp
                            @endif
                        @endforeach
                    @endif
                    {{ number_format ($gross_profit, 2) }}
                    @php
                        $profit += $gross_profit;
                    @endphp
                </td>
                <td>
                    @if($sale -> sale -> percentage_discount > 0)
                        @php
                            $discount = ($sale -> sale -> total * ($sale -> sale -> percentage_discount / 100) );
                        @endphp
                        {{ number_format (($gross_profit - $discount), 2) }}
                    @elseif($sale -> sale -> flat_discount > 0)
                        {{ number_format (($gross_profit - $sale -> sale -> flat_discount), 2) }}
                    @else
                        {{ number_format ($gross_profit, 2) }}
                    @endif
                </td>
                <td>{{ (new \App\Services\GeneralService()) -> date_formatter ($sale -> sale -> created_at) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td align="left">
            <strong>{{ number_format ($totalQty, 2) }}</strong>
        </td>
        <td align="left">
            <strong>{{ number_format ($totalPrice, 2) }}</strong>
        </td>
        <td></td>
        <td></td>
        <td align="left">
            <strong>{{ number_format ($totalNetPrice, 2) }}</strong>
        </td>
        <td align="left">
            <strong>{{ number_format ($profit, 2) }}</strong>
        </td>
        <td></td>
        <td></td>
    </tr>
    </tfoot>
</table>
@php
    $user_name = auth()->user()->name;
@endphp
<footer style="position: absolute; bottom: 0; width: 100%; font-size: 10px; color: #5D6975;">
 
    <hr style="border: 0; border-top: 1px solid #C1CED9;">

        <span>Printed on: {{ date('Y-m-d H:i:s') }}</span>
        <span style="float: right">Printed by: {{ $user_name }}</span>
    
</footer>
</body>
</html>
