<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice ID# {{ $sale -> id }}</title>
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
            padding       : 8px 20px;
            color         : #5D6975;
            background    : #F5F5F5;
            border-bottom : 1px solid #C1CED9;
            white-space   : nowrap;
            font-weight   : normal;
            font-size     : 1.1em;
        }
        
        table td {
            padding : 8px 20px;
        }
        
        table td.grand {
            border-top : 1px solid #5D6975;;
        }
        
        #header td {
            background : #FFFFFF;
            padding    : 0;
        }
        
        footer {
            position : fixed;
            bottom   : 10px;
            width    : 100%;
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
                <h1 style="margin: 0">Customer Sale Invoice</h1>
                <hr>
            </td>
        </tr>
        <tr>
            <td width="50%" align="left">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Customer Name:</strong>
                            {{ $sale -> customer -> name }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Email:</strong>
                            {{ $sale -> customer -> email }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Mobile:</strong>
                            {{ $sale -> customer -> mobile }}
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="font-size: 12px">
                            <strong>Address:</strong>
                            {{ $sale -> customer -> address }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
            <td width="50%" align="right">
                <table width="100%">
                    <tbody>
                    <tr>
                        <td align="right" style="font-size: 12px">
                            <strong>Order No:</strong>
                            {{ $sale -> sale_id }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 12px">
                            <strong>Date:</strong>
                            {{ $sale -> created_at }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 12px">
                            <strong>Type:</strong>
                            {{ ucwords ($sale -> customer_type) }}
                        </td>
                    </tr>
                    <tr>
                        <td align="right" style="font-size: 12px">
                            <strong>Status:</strong>
                            {{ $sale -> sale_closed == '1' ? 'Closed' : 'Open' }}
                        </td>
                    </tr>
                    @if(!empty(trim ($sale -> closed_at)))
                        <tr>
                            <td align="right" style="font-size: 12px">
                                <strong>Closed Date:</strong>
                                {{ $sale -> closed_at }}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<footer>
    {!! $pdf_footer !!}
</footer>

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th></th>
        <th align="left">Products</th>
        <th align="center">Quantity</th>
        <th align="center">Price</th>
        <th align="center">Total</th>
    </tr>
    </thead>
    <tbody>
    @if($sale && count ($sale -> products) > 0)
        @foreach($sale -> products as $product)
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td>
                    @if(!empty(trim ($product -> product -> image)))
                        <img src="{{ asset ($product -> product -> image) }}" style="height: 30px; border-radius: 50%">
                    @endif
                </td>
                <td>
                    <strong>{{ $product -> product -> productTitle() }}</strong>
                    <br />
                    @php $barCode = new \Picqer\Barcode\BarcodeGeneratorHTML() @endphp
                    {!! $barCode -> getBarcode($product -> product -> barcode, $barCode::TYPE_CODE_128) !!}
                </td>
                <td align="center">{{ $product -> quantity }}</td>
                <td align="center">{{ number_format (($product -> price), 2) }}</td>
                <td align="center">{{ number_format(($product -> net_price), 2) }}</td>
            </tr>
        @endforeach
        
        <tr>
            <td colspan="5"
                class="grand total" align="right">G.TOTAL
            </td>
            <td class="grand total" align="center">
                <strong>{{ number_format ($sale -> total, 2) }}</strong>
            </td>
        </tr>
        @if($sale -> flat_discount > 0)
            <tr>
                <td colspan="5"
                    class="grand total" align="right">Flat Discount
                </td>
                <td class="grand total" align="center">
                    <strong>{{ number_format ($sale -> flat_discount, 2) }}</strong>
                </td>
            </tr>
        @endif
        @if($sale -> percentage_discount > 0)
            <tr>
                <td colspan="5"
                    class="grand total" align="right">Discount(%)
                </td>
                <td class="grand total" align="center">
                    <strong>{{ number_format ($sale -> percentage_discount, 2) }}</strong>
                </td>
            </tr>
        @endif
        <tr>
            <td colspan="5"
                class="grand total" align="right">SHIPPING
            </td>
            <td class="grand total" align="center">
                <strong>{{ number_format ($sale -> shipping, 2) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="5"
                class="grand total" align="right">Net
            </td>
            <td class="grand total" align="center">
                <strong>{{ number_format ($sale -> net, 2) }}</strong>
            </td>
        </tr>
    @endif
    </tbody>
</table>

</body>
</html>
