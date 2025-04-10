<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>General Sales Report (Attributes Wise)</title>
    <style>
        /* @page {
            size: auto;
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
                <h1 style="margin: 0">General Sales Report (Attributes Wise)</h1>
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
        <th align="left">Attribute</th>
        <th>Quantity</th>
        <th>Net Price</th>
    </tr>
    </thead>
    <tbody>
    @php
        $totalQty = 0;
        $totalPrice = 0;
    @endphp
    @if(count ($sales) > 0)
        @foreach($sales as $sale)
            @php
                $totalPrice += $sale -> net;
                $totalQty += $sale -> quantity;
            @endphp
            <tr>
                <td align="center">
                    {{ $loop -> iteration }}
                </td>
                <td align="left">
                    {{ $sale -> title }}
                </td>
                <td align="center">
                    {{ number_format ($sale -> quantity) }}
                </td>
                <td align="center">
                    {{ number_format ($sale -> net, 2) }}
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2" class="text-danger fw-bolder" align="left">
            This total is without sale discounts.
        </td>
        <td align="center">
            <strong>{{ number_format ($totalQty) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format ($totalPrice, 2) }}</strong>
        </td>
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
