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
        } */

        @page {
            size : auto;
        margin-top: 20px; 
        margin-bottom: 20px; 
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
                <h1 style="margin: 0">Profit & Loss Report</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>
    <table width="100%">
        <tbody>
        <tr>
            <td width="100%" align="left">
                <strong>Search Date: </strong> {{ request ('start-date') . ' - ' . request ('end-date') }}
            </td>
        </tr>
        </tbody>
    </table>
</header>

@php
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
    $f = 0;
    $g = 0;
    $h = 0;
    $i = 0;
    $j = 0;
    $k = 0;
//
//    if (!empty($sale_discounts)) :
//        $d = ($sale_discounts -> total - $sale_discounts -> net);
//    endif;
//
//    $e = $a - ($b + $c + $d);
@endphp
<table width="100%" border="1">
    <thead>
    <tr>
        <th align="left">Account Head</th>
        <th align="left">Net Cash</th>
    </tr>
    </thead>
    <tbody>
    
    {!! $sales['items'] !!}
    @php
        $a += $sales['net'];
    @endphp
    
    <tr>
        <td>
            Sales Refund
        </td>
        <td>
            {{ number_format ($sales_refund['net'], 2) }}
            @php
                $b += $sales_refund['net'];
            @endphp
        </td>
    </tr>
    {!! $sale_discounts['items'] !!}
    @php
        $c += $sale_discounts['net'];
        $e = ($a - $b - $c);
    @endphp
    
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Net Sale</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($e, 2) }}
        </td>
    </tr>
    
    {!! $direct_costs['items'] !!}
    @php
        $f += $direct_costs['net'];
        $g += $e - $f;
    @endphp
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Gross Profit/Loss</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($g, 2) }}
        </td>
    </tr>
    
    {!! $general_admin_expenses['items'] !!}
    @php
        $h += $general_admin_expenses['net'];
        $i = $g - $h;
    @endphp
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>G.Total</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($h, 2) }}
        </td>
    </tr>
    
    {!! $income['items'] !!}
    
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Net Profit/Loss (Without Tax)</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            @php $i += $income['net'] @endphp
            {{ number_format ($i, 2) }}
        </td>
    </tr>
    
    {!! $taxes['items'] !!}
    @php
        $j += $taxes['net'];
        $k = $i > 0 ? $i - $j : $i + $j;
    @endphp
    
    <tr>
        <td class="text-danger font-medium-3 fw-bolder">
            <strong>Net Profit/Loss (With Tax)</strong>
        </td>
        <td class="text-danger font-medium-3 fw-bolder">
            {{ number_format ($k, 2) }}
        </td>
    </tr>
    
    </tbody>
</table>
</body>
</html>
