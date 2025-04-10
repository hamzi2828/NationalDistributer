<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>General Ledger</title>
    <style>
        /* @page {
            size   : landscape;
            margin : 15px;
        } */
        @page {
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
            padding   : 8px 10px;
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
                <h1 style="margin: 0">General Ledger</h1>
                <hr>
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Account Head:</strong> {{ $account_head -> name }}
            </td>
        </tr>
        <tr>
            <td width="100%" align="left">
                <strong>Search Date: </strong> {{ request ('start-date') . ' - ' . request ('end-date') }}
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1" style="border-collapse: collapse;">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Trans. ID</th>
        <th>Invoice/Sale ID</th>
        <th> Chq/Trans. No</th>
        <th> Voucher No.</th>
        <th> Date</th>
        <th> Description</th>
        <th> Debit</th>
        <th> Credit</th>
        <th> Running Balance</th>
    </tr>
    </thead>
    <tbody>
    {!! $ledgers['html'] !!}
    </tbody>
    <tfoot>
    <tr>
        <td></td>
        <td colspan="7">
            <strong style="font-size: 12pt; color: #000000;">Net Closing</strong>
        </td>
        <td colspan="2" align="right">
            <strong style="font-size: 12pt; color: #000000;">
                {{ number_format ( $ledgers[ 'net_closing' ], 2 ) }}
            </strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
