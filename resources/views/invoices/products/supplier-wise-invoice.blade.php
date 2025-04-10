<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Supplier Wise Report</title>
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
    <table width="100%" id="header">
        <tbody>
        <tr>
            <td align="center" width="100%">
                <h1 style="margin: 0">Supplier Wise Report</h1>
                <hr>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th align="center">#</th>
        <th align="left">Reference No</th>
        <th align="left">Vendor</th>
        <th align="left">Return Date</th>
        <th align="left">Net Price</th>
    </tr>
    </thead>
    <tbody>
    @php $net = 0; @endphp
    @if(count ($stocks) > 0)
        @foreach($stocks as $stock)
            @php $net += $stock -> total; @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td>{{ $stock -> reference_no }}</td>
                <td>{{ $stock -> vendor -> name }}</td>
                <td>{{ $stock -> created_at }}</td>
                <td>{{ number_format ($stock -> total, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"></td>
        <td>
            <strong>{{ number_format ($net, 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
