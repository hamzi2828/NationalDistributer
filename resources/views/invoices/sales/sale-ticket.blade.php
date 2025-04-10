<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket ID# {{ $sale -> id }}</title>
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
            background: transparent;
            font-size: 14px;
        }

        footer {
            position: absolute;
            left: 0;
            bottom: -20px;
            text-align: left;
            width: 100%;
            font-size: 24px;
        }

        footer .page:after {
            content: counter(page, decimal);
        }
    </style>
</head>
<body>

<table border="0" width="100%">
    <tbody>
    @if($sale -> boxes > 0)
        @for($counter = 1; $counter <= $sale -> boxes; $counter++)
            <tr>
                <td width="70%">
                    <table width="100%" border="0">
                        <tbody>
                        <tr>
                            <td>
                                <h2 style="margin: 0">
                                    <u>Invoice# {{ $sale -> id }}</u>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 15px">
                                <strong>Customer: </strong>
                                <u>{{ $sale -> customer -> name }}</u>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top: 10px">
                                <strong>Remarks: </strong>
                                <u>{{ $sale -> remarks }}</u>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
                <td width="30%" align="right">
                    <img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl={{ $sale -> id }}&choe=UTF-8"
                         title="{{ $sale -> id }}" style="margin-right: -25px;"/>
                </td>
            </tr>
            <footer align="left" colspan="2" style="display: flex; justify-content: center; align-content: center">
                <strong>Boxes: </strong>
                {{ $counter }} of <strong>{{ $sale -> boxes }}</strong>
            </footer>
        @endfor
    @endif
    </tbody>
</table>

</body>
</html>
