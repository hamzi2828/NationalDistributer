<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product ID# {{ $product -> id }}</title>
    <style>
        /* @page {
            size    : auto;
            margin  : 5px;
            padding : 0;
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
            background : transparent;
            font-size  : 14px;
        }
        
        footer {
            position   : absolute;
            left       : 0;
            bottom     : -20px;
            text-align : left;
            width      : 100%;
            font-size  : 24px;
        }
        
        footer .page:after {
            content : counter(page, decimal);
        }
    </style>
</head>
<body>

<table border="0" width="100%">
    <tbody>
    <tr>
        <td width="70%">
            <table width="100%" border="0">
                <tbody>
                <tr>
                    <td>
                        <h5 style="margin: 0">
                            <u>{{ $product -> productTitleWithoutBarcode() }}</u>
                        </h5>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 15px">
                        <img alt='Barcode Generator TEC-IT' height="60px"
                             src='https://barcode.tec-it.com/barcode.ashx?data={{ $product -> barcode }}&code=Code128&translate-esc=on'/>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
        <td width="30%" align="right">
            <img src="{{ asset ($product -> image) }}"
                 title="{{ $product -> productTitleWithoutBarcode() }}" style="height: 80px"
                 alt="{{ $product -> productTitleWithoutBarcode() }}" />
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
