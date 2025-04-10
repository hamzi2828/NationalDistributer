<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>General Sales Report</title>
    <style>
        @page {
            size : auto;
        margin-top: 20px; /* Reduced top margin */
        margin-bottom: 20px; /* Reduced bottom margin */
        margin-left: 10px; /* Optional: adjust left margin */
        margin-right: 10px; /* Optional: adjust right margin */
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
                <h1 style="margin: 0">General Sales Report</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>

    @include('invoices.searchCriteria.searchCriteria')


</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th>Sale ID</th>
        <th align="left">Customer</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Tax</th>
        <th>Discount <br> (%)</th>
        <th>Discount <br> (Flat)</th>
        <th>Net Price</th>
        <th>Dated Added</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalQty = 0;
        $totalPrice = 0;
        $totalNetPrice = 0;
    @endphp
    @if(count ($sales) > 0)
        @foreach($sales as $sale)
            @php
                $products = explode (',', $sale -> products);
                $totalQty = $totalQty + $sale -> sale -> sold_quantity();
                $totalPrice = $totalPrice + $sale -> sale -> total;
                $totalNetPrice = $totalNetPrice + $sale -> sale -> net;
            @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="center">{{ $sale -> sale_id }}</td>
                <td align="left">{{ $sale -> sale -> customer -> name }}</td>
                <td align="center">{{ $sale -> sale -> sold_quantity() }}</td>
                <td align="center">{{ number_format ($sale -> sale -> total, 2) }}</td>
                <td align="center">{{ number_format ($sale -> sale -> tax_total ?? 0, 2) }}</td>
                <td align="center">{{ number_format ($sale -> sale -> percentage_discount, 2)	 }}</td>
                <td align="center">{{ number_format ($sale -> sale -> flat_discount, 2)	 }}</td>
                <td align="center">{{ number_format ($sale -> sale -> net, 2) }}</td>
                <td align="center">{{ $sale -> sale -> created_at }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" align="center">
                <strong>Total</strong>
         </td>

        <td align="center">
            <strong>{{ number_format ($totalQty, 2) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format ($totalPrice, 2) }}</strong>
        </td>
        <td></td>
        <td></td>
        <td></td>
        <td align="center">
            <strong>{{ number_format ($totalNetPrice, 2) }}</strong>
        </td>
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
