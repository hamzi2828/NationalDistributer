<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Price List Catalog</title>
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
            table-layout    : fixed;
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
            padding   : 0;
            word-wrap : break-word;
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
                <h1 style="margin: 0">Price List Catalog</h1>
                <hr>
            </td>
        </tr>
        </tbody>

        @include('invoices.searchCriteria.searchCriteria')

    </table>
</header>

@if(request ('category-id') > 0)
    <table width="100%" cellpadding="0">
        <tbody>
        <tr>
            <td align="right" width="100%" style="font-size: 9pt">
                <strong>Category: </strong>
                {{ \App\Models\Category::find(request ('category-id')) -> title }}
            </td>
        </tr>
        <tr>
            <td align="right" width="100%">
                <strong>Date & Time: </strong>
                {{ \Carbon\Carbon::now () }}
            </td>
        </tr>
        </tbody>
    </table>
@endif

<table width="100%" border="1" style="border-collapse: collapse;" cellpadding="0">
    <tbody style="vertical-align: baseline;">
    @if(count($products) > 0)
        @php $counter = 0; @endphp
        @foreach($products as $product)
            @if($counter % 4 == 0)
                @if($counter > 0)
                    </tr>
    @endif
    <tr>
        @endif
        <td width="25%" align="center">
            @if(!empty(trim($product->avatar())))
                <div style="height: 100px; padding: 10px">
                    <img src="{{ asset($product->avatar()) }}" alt="{{ $product->productTitleWithSku() }}"
                         style="max-height: 100px; max-width: 100%">
                </div>
            @endif
            <h3 style="border-top: 1px solid #000000; padding: 0 10px; height: 90px">{{ $product->productTitleWithSku() }}</h3>
            <p style="margin-bottom: 0;"><strong>{{ $product->barcode }}</strong></p>
            <p style="margin-bottom: 0; margin-top: 0">Pack Size: <strong>{{ $product->pack_size }}</strong></p>
            <h3 style="padding: 2px 10px; background: #068306; color: #FFFFFF; text-align: center; margin-bottom: 0">
                Price/Box:
                @if(request('price-appreciation') > 0)
                    @php
                        $appreciation = ($product->sale_box * request('price-appreciation')) / 100;
                    @endphp
                    {{ number_format(($product->sale_box + $appreciation), 2) }}
                @elseif(request('price-depreciation') > 0)
                    @php
                        $appreciation = ($product->sale_box * request('price-depreciation')) / 100;
                    @endphp
                    {{ number_format(($product->sale_box - $appreciation), 2) }}
                @else
                    {{ number_format($product->sale_box, 2) }}
                @endif
            </h3>
        </td>
        @php $counter++; @endphp
        @endforeach
        @if($counter > 0)
    </tr>
    @endif
    @endif
    </tbody>
</table>

</body>
</html>
