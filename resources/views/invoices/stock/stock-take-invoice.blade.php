<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Take</title>
    <style>
        /* @page {
            size : auto;
        }
         */

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
                <h1 style="margin: 0">Stock Take Invoice</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<h1>Adjustment Increase</h1>
<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th>Attribute</th>
        <th>Term</th>
        <th>Barcode</th>
        <th>Available Quantity</th>
        <th>Physical Quantity</th>
        <th>Difference</th>
    </tr>
    </thead>
    <tbody>
    @php $counter = 1 @endphp
    @if(count ($products) > 0)
        @foreach($products as $product)
            <tr>
                <td></td>
                <td colspan="6"
                    class="font-medium-5 fw-bolder text-danger">
                    <strong>{{ $product -> title }}</strong>
                </td>
            </tr>
            @if(count ($product -> terms) > 0)
                @foreach($product -> terms as $term)
                    @if(count ($term -> product_terms) > 0)
                        @php $difference = 0 @endphp
                        @foreach($term -> product_terms as $product_terms)
                            @foreach($product_terms -> stock_takes as $stock_take)
                                @if(!empty($stock_take -> product))
                                    @php $difference = ($stock_take -> live_qty - $stock_take -> available_qty) @endphp
                                @endif
                            @endforeach
                        @endforeach
                        
                        @if($difference > 0)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td></td>
                                <td>{{ $term -> title }}</td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> product -> productTitle() }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> available_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> live_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> live_qty - $stock_take -> available_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
    
    @if(count ($simpleProducts) > 0)
        @foreach($simpleProducts as $simpleProduct)
            @php $difference = ($simpleProduct -> live_qty - $simpleProduct -> available_qty) @endphp
            @if($difference > 0)
                <tr>
                    <td></td>
                    <td colspan="6"
                        class="font-medium-5 fw-bolder text-danger">
                        <strong>{{ $simpleProduct -> product -> title }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td colspan="2"></td>
                    <td>{{ $simpleProduct -> product -> productTitle() }}</td>
                    <td>{{ $simpleProduct -> available_qty }}</td>
                    <td>{{ $simpleProduct -> live_qty }}</td>
                    <td>{{ $simpleProduct -> live_qty - $simpleProduct -> available_qty }}</td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>

<h1>Adjustment Decrease</h1>
<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th>Attribute</th>
        <th>Term</th>
        <th>Barcode</th>
        <th>Available Quantity</th>
        <th>Physical Quantity</th>
        <th>Difference</th>
    </tr>
    </thead>
    <tbody>
    @php $counter = 1 @endphp
    @if(count ($products) > 0)
        @foreach($products as $product)
            <tr>
                <td></td>
                <td colspan="6"
                    class="font-medium-5 fw-bolder text-danger">
                    <strong>{{ $product -> title }}</strong>
                </td>
            </tr>
            @if(count ($product -> terms) > 0)
                @foreach($product -> terms as $term)
                    @if(count ($term -> product_terms) > 0)
                        @php $difference = 0 @endphp
                        @foreach($term -> product_terms as $product_terms)
                            @foreach($product_terms -> stock_takes as $stock_take)
                                @if(!empty($stock_take -> product))
                                    @php $difference = ($stock_take -> live_qty - $stock_take -> available_qty) @endphp
                                @endif
                            @endforeach
                        @endforeach
                        
                        @if($difference < 0)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td></td>
                                <td>{{ $term -> title }}</td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> product -> productTitle() }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> available_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> live_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> live_qty - $stock_take -> available_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
    
    @if(count ($simpleProducts) > 0)
        @foreach($simpleProducts as $simpleProduct)
            @php $difference = ($simpleProduct -> live_qty - $simpleProduct -> available_qty) @endphp
            @if($difference < 0)
                <tr>
                    <td></td>
                    <td colspan="6"
                        class="font-medium-5 fw-bolder text-danger">
                        <strong>{{ $simpleProduct -> product -> title }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td colspan="2"></td>
                    <td>{{ $simpleProduct -> product -> productTitle() }}</td>
                    <td>{{ $simpleProduct -> available_qty }}</td>
                    <td>{{ $simpleProduct -> live_qty }}</td>
                    <td>{{ $simpleProduct -> live_qty - $simpleProduct -> available_qty }}</td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>

<h1>No Change</h1>
<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th>Attribute</th>
        <th>Term</th>
        <th>Barcode</th>
        <th>Available Quantity</th>
        <th>Physical Quantity</th>
        <th>Difference</th>
    </tr>
    </thead>
    <tbody>
    @php $counter = 1 @endphp
    @if(count ($products) > 0)
        @foreach($products as $product)
            <tr>
                <td></td>
                <td colspan="6"
                    class="font-medium-5 fw-bolder text-danger">
                    <strong>{{ $product -> title }}</strong>
                </td>
            </tr>
            @if(count ($product -> terms) > 0)
                @foreach($product -> terms as $term)
                    @if(count ($term -> product_terms) > 0)
                        @php $difference = 0 @endphp
                        @foreach($term -> product_terms as $product_terms)
                            @foreach($product_terms -> stock_takes as $stock_take)
                                @if(!empty($stock_take -> product))
                                    @php $difference = ($stock_take -> live_qty - $stock_take -> available_qty) @endphp
                                @endif
                            @endforeach
                        @endforeach
                        
                        @if($difference == 0)
                            <tr>
                                <td>{{ $counter++ }}</td>
                                <td></td>
                                <td>{{ $term -> title }}</td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> product -> productTitle() }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> available_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> live_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($term -> product_terms as $product_terms)
                                        @foreach($product_terms -> stock_takes as $stock_take)
                                            @if(!empty($stock_take -> product))
                                                {{ $stock_take -> live_qty - $stock_take -> available_qty }}
                                            @endif
                                        @endforeach
                                    @endforeach
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @endif
        @endforeach
    @endif
    
    @if(count ($simpleProducts) > 0)
        @foreach($simpleProducts as $simpleProduct)
            @php $difference = ($simpleProduct -> live_qty - $simpleProduct -> available_qty) @endphp
            @if($difference == 0)
                <tr>
                    <td></td>
                    <td colspan="6"
                        class="font-medium-5 fw-bolder text-danger">
                        <strong>{{ $simpleProduct -> product -> title }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>{{ $counter++ }}</td>
                    <td colspan="2"></td>
                    <td>{{ $simpleProduct -> product -> productTitle() }}</td>
                    <td>{{ $simpleProduct -> available_qty }}</td>
                    <td>{{ $simpleProduct -> live_qty }}</td>
                    <td>{{ $simpleProduct -> live_qty - $simpleProduct -> available_qty }}</td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>

</body>
</html>
