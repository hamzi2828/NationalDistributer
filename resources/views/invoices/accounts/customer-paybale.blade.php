<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Receivable</title>
    <style>
        /* @page {
            size   : auto;
            margin : 15px;
        }
         */

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
                <h1 style="margin: 0">Customer Receivable</h1>
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

<table width="100%" border="1">
    <thead>
    <tr>
        <th>#</th>
        <th align="left">Account Head</th>
        <th>Opening Balance</th>
        <th>Debit</th>
        <th>Credit</th>
        <th>Balance</th>
    </tr>
    </thead>
    <tbody>
    @php
        $net_debit = 0;
        $net_credit = 0;
        $netRB = 0;
        $netOB = 0;
    @endphp
    @if(count ($account_heads) > 0)
        @foreach($account_heads as $account_head)
            @php
                $net_debit += $account_head -> totalDebit;
                $net_credit += $account_head -> totalCredit;
                $opening_balance = (new \App\Http\Services\GeneralLedgerService()) -> get_opening_balance_previous_than_searched_start_date(request ('start-date'), $account_head -> id);
                $running_balance = (new \App\Http\Services\GeneralLedgerService()) -> calculate_running_balance($opening_balance, $account_head -> totalCredit, $account_head -> totalDebit, $account_head);
                $netRB += $running_balance;
                $netOB += $opening_balance;
            @endphp
            
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $account_head -> name }}</td>
                <td align="center">{{ number_format ($opening_balance, 2) }}</td>
                <td align="center">{{ number_format ($account_head -> totalDebit, 2) }}</td>
                <td align="center">{{ number_format ($account_head -> totalCredit, 2) }}</td>
                <td align="center">{{ number_format ($running_balance, 2) }}</td>
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td align="center">
            <strong>{{ number_format ($netOB, 2) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format ($net_debit, 2) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format ($net_credit, 2) }}</strong>
        </td>
        <td align="center">
            <strong>{{ number_format (($netOB + $net_debit - $net_credit), 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
