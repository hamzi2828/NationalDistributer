<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>High Low Sale Report (Pos Vs Online)</title>
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
                <h1 style="margin: 0">High Low Sale Report(Pos Vs Online)</h1>
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
            <th>Picture</th>
            <th>Sku</th>
            <th>Product Name</th>
            <th>Category</th>
            <th>Sold Quantity <br> (Online)</th>
            <th>Sale Value <br> (Online)</th>
            <th>Sold Quantity <br> (Pos)</th>
            <th>Sale Value <br>(Pos)</th>
        </tr>
    </thead>
    <tbody>
        @php $i = 1; @endphp
        @foreach($products as $product)
        <tr>
            <td>{{ $i++ }}</td>
            <td>
                <img src="{{ asset($product->image) }}" alt="image" width="50">
            </td>
            <td>{{ $product->sku }}</td>
            <td>{{ $product->title }}</td>
            <td>{{ $product->category ? $product->category->title : 'N/A' }}</td>
            <td>{{ number_format($product->soldQuantity) }}</td>
            <td>{{ number_format($product->saleValue, 2) }}</td>
            <td>{{ number_format($product->soldQuantityPos) }}</td>
            <td>{{ number_format($product->saleValuePos, 2) }}</td>
        </tr>
        @endforeach
    </tbody>
    @if(count($products) > 0)
    <tfoot>
        <tr>
            <td colspan="5" class="text-end"><strong>Total:</strong></td>
            <td><strong>{{ number_format($totalSoldQuantity) }}</strong></td>
            <td><strong>{{ number_format($totalSaleValue, 2) }}</strong></td>
            <td><strong>{{ number_format($totalSoldQuantityPos) }}</strong></td>
            <td><strong>{{ number_format($totalSaleValuePos, 2) }}</strong></td>
        </tr>
    </tfoot>
    @endif
</table>

</body>
</html>
