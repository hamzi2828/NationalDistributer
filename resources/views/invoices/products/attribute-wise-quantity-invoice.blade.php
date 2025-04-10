<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Report (Attribute Wise)</title>
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
                <h1 style="margin: 0">Stock Report (Attribute Wise)</h1>
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
        <th align="left">Attribute</th>
        <th align="left">Term</th>
        <th align="left">Barcode</th>
        <th align="center">Available Qty</th>
    </tr>
    </thead>
    <tbody>
    @php $quantity = 0 @endphp
    @if(count ($products) > 0)
        @foreach($products as $product)
            @php $attrWiseQty = 0 @endphp
            <tr>
                <td></td>
                <td colspan="4" align="left"
                    class="font-medium-5 fw-bolder text-danger">{{ $product -> title }}</td>
            </tr>
            @if(count ($product -> terms) > 0)
                @foreach($product -> terms as $term)
                    @if(count ($term -> product_terms) > 0)
                        <tr>
                            <td align="center">{{ $loop -> iteration }}</td>
                            <td></td>
                            <td align="left">{{ $term -> title }}</td>
                            <td align="left">
                                @foreach($term -> product_terms as $product)
                                    @if(!empty($product -> product))
                                        {{ $product -> product -> barcode }}
                                    @endif
                                @endforeach
                            </td>
                            <td align="center">
                                @foreach($term -> product_terms as $product)
                                    @if(!empty($product -> product))
                                        @php
                                            $quantity += $product -> product -> available_quantity();
                                            $attrWiseQty += $product -> product -> available_quantity();
                                        @endphp
                                        {{ $product -> product -> available_quantity() }}
                                    @endif
                                @endforeach
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endif
            <tr>
                <td colspan="4"></td>
                <td align="center">
                    <strong>{{ number_format ($attrWiseQty) }}</strong>
                </td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4" align="right">
            Total Available Quantity:
        </td>
        <td align="center">
            <strong>{{ number_format ($quantity) }}</strong>
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
