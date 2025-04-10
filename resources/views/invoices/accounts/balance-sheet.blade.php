<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Balance Sheet</title>
    <style>
        /* @page {
            size   : auto;
            margin : 15px;
        } */

        @page {
            size : auto;
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
                <h1 style="margin: 0">Balance Sheet</h1>
                <hr>
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
        <th align="left">Account Head</th>
        <th align="left">Closing Balance</th>
    </tr>
    </thead>
    <tbody style="vertical-align: baseline;">
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.current_assets')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $current_assets['html'] !!}
    <tr>
        <td></td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format ($current_assets['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.non_current_assets')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $non_current_assets['html'] !!}
    <tr>
        <td></td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format ($non_current_assets['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td align="right">
            <strong>
                Total Assets
            </strong>
        </td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.liabilities')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $liabilities['html'] !!}
    <tr>
        <td align="right">
            <strong>
                Total Liabilities
            </strong>
        </td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format ($liabilities['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong style="font-size: 16px; color:#FF0000">
                Shareholder's Equity
            </strong>
        </td>
    </tr>
    
    <tr>
        <td colspan="2">
            <strong>
                {{ \App\Models\Account::find(config ('constants.capital')) -> name }}
            </strong>
        </td>
    </tr>
    {!! $capital['html'] !!}
    <tr>
        <td></td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format ($capital['net'], 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
            <strong>Net Profit (P&L)</strong>
        </td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format ($profit, 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td align="right">
            <strong>
                Total Equity
            </strong>
        </td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format (abs ($capital['net']) + $profit, 2) }}
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
            <strong style="font-size: 12px; color: #000000">
                Total Assets = Total Liabilities + Total Capital
            </strong>
        </td>
        <td>
            <strong style="font-size: 12px; color: #FF0000">
                {{ number_format (($current_assets['net'] + $non_current_assets['net']), 2) }}
                =
                {{ number_format (($liabilities['net'] + abs ($capital['net']) + $profit), 2) }}
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
