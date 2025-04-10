<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vendor Ageing Report</title>
    <style>
        /* @page {
            size   : auto;
            margin : 15px;
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
                <h1 style="margin: 0">Vendor Ageing Report</h1>
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
        <th width="5%" align="center">#</th>
        <th width="15%" align="left">Acc. Head</th>
        <th width="15%" align="left">Opening Bal.</th>
        <th width="15%" align="left">Debit</th>
        <th width="15%" align="left">Credit</th>
        <th width="15%" align="left">Balance</th>
        <th width="15%" align="left">Last Payment</th>
        <th width="15%" align="left">2nd Last Payment</th>
        <th width="15%" align="left">3rd Last Payment</th>
    </tr>
    </thead>
    <tbody>
    @php
        $net_debit  = 0;
        $net_credit = 0;
        $netRB      = 0;
        $netOB      = 0;
    @endphp
    @if(count ($account_heads) > 0)
        @foreach($account_heads as $account_head)
            @php
                $net_debit          += $account_head -> totalDebit;
                $net_credit         += $account_head -> totalCredit;
                $opening_balance    = (new \App\Http\Services\GeneralLedgerService()) -> get_opening_balance_previous_than_searched_start_date(request ('start-date'), $account_head -> id);
                $running_balance    = (new \App\Http\Services\GeneralLedgerService()) -> calculate_running_balance($opening_balance, $account_head -> totalCredit, $account_head -> totalDebit, $account_head);
                $lastPayments       = (new \App\Http\Services\GeneralLedgerService()) -> get_account_head_last_payments($account_head -> id, 3, 'debit');
                $netRB              += $running_balance;
                $netOB              += $opening_balance;
            @endphp
            
            <tr>
                <td>{{ $loop -> iteration }}</td>
                <td>{{ $account_head -> name }}</td>
                <td>{{ number_format ($opening_balance, 2) }}</td>
                <td>{{ number_format ($account_head -> totalDebit, 2) }}</td>
                <td>{{ number_format ($account_head -> totalCredit, 2) }}</td>
                <td>{{ number_format ($running_balance, 2) }}</td>
                @if(count ($lastPayments) > 0)
                    @foreach($lastPayments as $lastPayment)
                        <td>
                            {{ number_format ($lastPayment -> debit, 2) }}
                            @if(!empty(trim ($lastPayment -> transaction_date)))
                                <br />
                                <small>
                                    {{ (new \App\Http\Helpers\GeneralHelper()) -> format_date ($lastPayment -> transaction_date) }}
                                </small>
                            @endif
                        </td>
                    @endforeach
                @endif
            </tr>
        @endforeach
    @endif
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td>
            <strong>{{ number_format ($netOB, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format ($net_debit, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format ($net_credit, 2) }}</strong>
        </td>
        <td>
            <strong>{{ number_format (($netOB + $net_debit - $net_credit), 2) }}</strong>
        </td>
        <td colspan="3"></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
