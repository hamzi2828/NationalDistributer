<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice ID# {{ $sale -> id }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kalam:wght@300&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
        
        body {
            position    : relative;
            margin      : 0 auto;
            background  : #a4a4a4;
            font-size   : 10px;
            font-family : "Open Sans", sans-serif;
        }
        
        #invoice {
            width      : 300px;
            background : #fff;
            margin     : 0 auto;
            padding    : 0 10px 10px 10px;
        }
        
        @media print {
            body, h1, h2, h3, h4, h5, h6, p, span, label, td, th {
                color       : #000000 !important;
                text-shadow : 0 0 0 #000000 !important;
            }
            
            @media print and (-webkit-min-device-pixel-ratio : 0) {
                body {
                    color                      : #000000 !important;
                    -webkit-print-color-adjust : exact !important;
                }
            }
        }
    </style>
</head>
<body>

<div id="invoice">
    
    {!! $pdf_header !!}
    
    <table border="0" width="100%">
        <tbody>
        <tr>
            <td align="left" width="50%">
                <h1 style="margin: 0">Sale Invoice</h1>
            </td>
            <td align="right" width="100%">
                <h1 style="margin: 0">#{{ $sale -> id }}</h1>
            </td>
        </tr>
        </tbody>
    </table>
    
    <hr style="margin-top: 0;" />
    
    <table border="0" width="100%" cellspacing="0" cellpadding="0" style="margin-bottom: 10px">
        <tbody>
        <tr>
            <td align="left" style="font-size: 10px">
                <strong>Customer Name:</strong>
                {{ $sale -> customer -> name }}
            </td>
        </tr>
        
        <tr>
            <td align="left" style="font-size: 10px">
                <strong>Type:</strong>
                {{ ucwords ($sale -> customer_type) }}
            </td>
        </tr>
        
        @if(!empty(trim ($sale -> created_at)))
            <tr>
                <td align="left" style="font-size: 10px">
                    <strong>Sale Date:</strong>
                    {{ $sale -> created_at }}
                </td>
            </tr>
        @endif
        
        @if(!empty(trim ($sale -> closed_at)))
            <tr>
                <td align="left" style="font-size: 10px">
                    <strong>Closed Date:</strong>
                    {{ $sale -> closed_at }}
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    
    <table width="100%" border="1" cellpadding="4" cellspacing="0">
        <thead>
        <tr>
            <th align="center">Sr.No</th>
            <th align="left">Products</th>
            <th align="center">Price</th>
        </tr>
        </thead>
        <tbody>
        @php
            $net = 0;
            $attributesArray = [];
            $counter = 1;
            $quantity = 0;
        @endphp
        
        @if(count ($sales) > 0 || count ($simple_sales) > 0)
            @foreach($sales as $key => $saleInfo)
                @if(!in_array ($saleInfo -> attribute_id, $attributesArray))
                    <tr>
                        <td colspan="3" align="left" style="padding-left: 15px">
                            <strong>{{ $saleInfo -> title }}</strong>
                        </td>
                    </tr>
                    @php
                        $counter = 1;
                        $quantity = 0;
                        array_push ($attributesArray, $saleInfo -> attribute_id);
                    @endphp
                @else
                    @php $counter++; @endphp
                @endif
                @php
                    $product = \App\Models\Product::find($saleInfo -> product_id);
                    $available = $product -> available_quantity();
                    if ($available - $product -> quantity < 1 )
                        @$available = $available + $product -> quantity;
    
                    $quantity += $saleInfo -> quantity;
                @endphp
                <tr>
                    <td align="center">{{ $counter }}</td>
                    <td>
                        {{ $product -> productTitle() }}
                        {{ $saleInfo -> quantity }}
                        x {{ number_format (($saleInfo -> price/$saleInfo -> noOfRows), 2) }}
                    </td>
                    <td align="center">{{ number_format(($saleInfo -> net_price), 2) }}</td>
                </tr>
            @endforeach
            
            @php $quantity = 0; @endphp
            @if(count ($simple_sales) > 0)
                <tr>
                    <td colspan="3" align="left" class="text-danger font-medium-5" style="padding-left: 15px">
                        <strong>Simple Products</strong>
                    </td>
                </tr>
                @foreach($simple_sales as $simple_sale)
                    @php
                        $product = \App\Models\Product::find($simple_sale -> product_id);
                        $available = $product -> available_quantity();
                        if ($available - $product -> quantity < 1 )
                            @$available = $available + $product -> quantity;
    
                        $quantity += $simple_sale -> quantity;
                    @endphp
                    <tr>
                        <td align="center">{{ $counter++ }}</td>
                        <td>
                            {{ $product -> productTitle() }}
                            {{ $simple_sale -> quantity }}
                            x {{ number_format (($simple_sale -> price/$simple_sale -> noOfRows), 2) }}
                        </td>
                        <td align="center">{{ number_format(($simple_sale -> net_price), 2) }}</td>
                    </tr>
                @endforeach
            @endif
            
            <tr>
                <td colspan="2"
                    class="grand total" align="right">G.TOTAL
                </td>
                <td class="grand total" align="center">
                    <strong>{{ number_format ($sale -> total, 2) }}</strong>
                </td>
            </tr>
            @if($sale -> flat_discount > 0)
                <tr>
                    <td colspan="2"
                        class="grand total" align="right">Flat Discount
                    </td>
                    <td class="grand total" align="center">
                        <strong>{{ number_format ($sale -> flat_discount, 2) }}</strong>
                    </td>
                </tr>
            @endif
            @if($sale -> percentage_discount > 0)
                <tr>
                    <td colspan="2"
                        class="grand total" align="right">Discount(%)
                    </td>
                    <td class="grand total" align="center">
                        <strong>{{ number_format ($sale -> percentage_discount, 2) }}</strong>
                    </td>
                </tr>
            @endif
            <tr>
                <td colspan="2"
                    class="grand total" align="right">Net
                </td>
                <td class="grand total" align="center">
                    <strong>{{ number_format ($sale -> net, 2) }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    class="grand total" align="right">Paid
                </td>
                <td class="grand total" align="center">
                    <strong>{{ number_format ($sale -> amount_added, 2) }}</strong>
                </td>
            </tr>
            <tr>
                <td colspan="2"
                    class="grand total" align="right">Balance
                </td>
                <td class="grand total" align="center">
                    <strong>{{ number_format (($sale -> net - $sale -> amount_added), 2) }}</strong>
                </td>
            </tr>
        @endif
        </tbody>
    </table>
    
    <hr/>
    
    {!! $pdf_footer !!}
</div>

<script type="text/javascript">
    window.print ();
</script>
</body>
</html>
