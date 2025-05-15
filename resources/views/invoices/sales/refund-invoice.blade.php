<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice ID# {{ $sale->id }}</title>
    <style>
        @page {
            size: auto;
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
            padding: 8px 20px;
            color: #5D6975;
            background: #F5F5F5;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;
            font-weight: normal;
            font-size: 1.1em;
        }
        table td {
            padding: 8px 20px;
        }
        table td.grand {
            border-top: 1px solid #5D6975;
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
            <td align="center" width="100%" colspan="2">
                <h1 style="margin: 0">Sale Invoice Refunded</h1>
                <hr>
            </td>
        </tr>
        <tr>
            <td width="50%" align="left">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td style="font-size: 12px"><strong>Customer Name:</strong> {{ $sale->customer->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>Email:</strong> {{ $sale->customer->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>Mobile:</strong> {{ $sale->customer->mobile ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>Address:</strong> {{ $sale->customer->address ?? '-' }}</td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="50%" align="right">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td style="font-size: 12px"><strong>Sale ID:</strong> {{ $sale->id }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>Date:</strong> {{ $sale->created_at }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>Type:</strong> {{ ucwords($sale->customer_type) }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 12px"><strong>Status:</strong> Refunded</td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</header>

@php
    $net = 0;
    $total_tax = 0;
    $counter = 1;
    $attributesArray = [];
@endphp

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th align="left">Products</th>
        <th align="center">Quantity</th>
        <th align="center">Price</th>
        <th align="center">Tax</th>
        <th align="center">Total</th>
    </tr>
    </thead>
    <tbody>

    @if(count($sales) > 0 || count($simple_sales) > 0)

        @foreach($sales as $saleInfo)
            @if(!in_array($saleInfo->attribute_id, $attributesArray))
                <tr>
                    <td colspan="6" align="left"><strong>{{ $saleInfo->title }}</strong></td>
                </tr>
                @php
                    $counter = 1;
                    $attributesArray[] = $saleInfo->attribute_id;
                @endphp
            @else
                @php $counter++; @endphp
            @endif

            @php
                $product = \App\Models\Product::find($saleInfo->product_id);
                $pricePerRow = $saleInfo->price / $saleInfo->noOfRows;
                $taxPerRow = $saleInfo->net_price / $saleInfo->noOfRows;
                $total_tax += $taxPerRow;
            @endphp
            <tr>
                <td align="center">{{ $counter }}</td>
                <td>{{ $product->productTitle() ?? '-' }}</td>
                <td align="center">{{ $saleInfo->quantity }}</td>
                <td align="center">{{ number_format($pricePerRow, 2) }}</td>
                <td align="center">{{ number_format($taxPerRow, 2) }}</td>
                <td align="center">{{ number_format($pricePerRow + $taxPerRow, 2) }}</td>
            </tr>
        @endforeach

        @if(count($simple_sales) > 0)
            <tr>
                <td colspan="6" align="left"><strong>Simple Products</strong></td>
            </tr>
            @foreach($simple_sales as $simple_sale)
                @php
                    $product = \App\Models\Product::find($simple_sale->product_id);
                    $pricePerRow = $simple_sale->price / $simple_sale->noOfRows;
                    $taxPerRow = $simple_sale->tax_value;
                    $total_tax += $taxPerRow;
                @endphp
                <tr>
                    <td align="center">{{ $counter++ }}</td>
                    <td>{{ $product->productTitle() ?? '-' }}</td>
                    <td align="center">{{ $simple_sale->quantity }}</td>
                    <td align="center">{{ number_format($pricePerRow, 2) }}</td>
                    <td align="center">{{ number_format($taxPerRow, 2) }}</td>
                    <td align="center">{{ number_format($pricePerRow + $taxPerRow, 2) }}</td>
                </tr>
            @endforeach
        @endif

        <tr>
            <td colspan="5" align="right" class="grand total">G.TOTAL</td>
            <td align="center" class="grand total">
                <strong>{{ number_format($sale->total - $total_tax, 2, '.', '') }}</strong>
            </td>
        </tr>

        @if($sale->flat_discount > 0)
            <tr>
                <td colspan="5" align="right" class="grand total">Flat Discount</td>
                <td align="center" class="grand total">
                    <strong>{{ number_format($sale->flat_discount, 2) }}</strong>
                </td>
            </tr>
        @endif

        @if($sale->percentage_discount > 0)
            <tr>
                <td colspan="5" align="right" class="grand total">Discount (%)</td>
                <td align="center" class="grand total">
                    <strong>{{ number_format($sale->percentage_discount, 2) }}</strong>
                </td>
            </tr>
        @endif

        <tr>
            <td colspan="5" align="right" class="grand total">Net</td>
            <td align="center" class="grand total">
                <strong>{{ number_format($sale->net, 2) }}</strong>
            </td>
        </tr>

        <tr>
            <td colspan="5" align="right" class="grand total">Paid</td>
            <td align="center" class="grand total">
                <strong>{{ number_format($sale->amount_added, 2) }}</strong>
            </td>
        </tr>

        <tr>
            <td colspan="5" align="right" class="grand total">Balance</td>
            <td align="center" class="grand total">
                <strong>{{ number_format($sale->net - $sale->amount_added, 2) }}</strong>
            </td>
        </tr>

    @endif

    </tbody>
</table>

<h3 style="color: #FF0000; margin-bottom: 10px;"><u>Summary</u></h3>

<table width="50%" border="1" style="float: left">
    <thead>
    <tr>
        <th align="left">Attribute</th>
        <th align="center">Quantity</th>
    </tr>
    </thead>
    <tbody>

    @if(count($summary) > 0)
        @foreach($summary as $product)
            <tr>
                <td style="font-size: 10px">{{ \App\Models\Attribute::find($product['attribute_id'])->title ?? '-' }}</td>
                <td style="font-size: 10px" align="center">{{ $product['quantity'] }}</td>
            </tr>
        @endforeach
    @endif

    @if(count($simple_sales) > 0)
        @php $quantity = 0; @endphp
        @foreach($simple_sales as $simple_sale)
            @php $quantity += $simple_sale->quantity; @endphp
        @endforeach
        <tr>
            <td style="font-size: 10px">Simple Products</td>
            <td style="font-size: 10px" align="center">{{ $quantity }}</td>
        </tr>
    @endif

    </tbody>
</table>

@if(abs($closing_balance) > 0)
    <table width="50%" border="0" style="float: right; font-size: 14px">
        <tbody>
        <tr>
            <td align="right">
                <strong>Previous Balance:</strong> {{ number_format($closing_balance, 2) }}
            </td>
        </tr>
        </tbody>
    </table>
@endif

</body>
</html>
