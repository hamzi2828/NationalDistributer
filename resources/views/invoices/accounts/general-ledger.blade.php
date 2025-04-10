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
            size: auto;
            margin: 15px;
        } */
        @page {
            size : auto;
        margin-top: 20px; 
        margin-bottom: 20px; 
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
            table-layout: fixed;
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
            word-wrap: break-word;
        }

        #header td {
            background: #FFFFFF;
            padding: 0;
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
                <strong>Account Head:</strong> {{ $ledgers[0] -> account_head -> name }}
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
        <th width="5%">#</th>
        <th width="12%">Invoice/Sale ID</th>
        <th width="10%" align="left">Date</th>
        <th width="10%" align="left">Voucher No</th>
        <th width="15%" align="left">Account Head</th>
        <th width="12%" align="left">Description</th>
        <th width="10%" align="left">Debit</th>
        <th width="10%" align="left">Credit</th>
        <th width="16%" align="left">Running Balance</th>
    </tr>
    </thead>
    <tbody>
    @if(count ($ledgers) > 0)
        <tr>
            <td colspan="8"></td>
            <td>
                <strong>{{ number_format ($running_balance, 2) }}</strong>
            </td>
        </tr>

        @php $runningBalance = $running_balance; @endphp
        @foreach($ledgers as $ledger)
            @php
                if ( in_array ($ledger -> account_head -> account_type -> id, config ('constants.account_type_in')) )
                    $runningBalance = $runningBalance + $ledger -> debit - $ledger -> credit;
                else
                    $runningBalance = $runningBalance - $ledger -> debit + $ledger -> credit;
            @endphp
            <tr>
                <td>{{ $loop -> iteration }}</td>
                <td>{{ $ledger -> invoice_no }}</td>
                <td>{{ $ledger -> transaction_date }}</td>
                <td>{{ $ledger -> voucher_no }}</td>
                <td>{{ $ledger -> account_head -> name }}</td>
                <td>{{ $ledger -> description }}</td>
                <td>{{ number_format ($ledger -> debit, 2) }}</td>
                <td>{{ number_format ($ledger -> credit, 2) }}</td>
                <td>{{ number_format ($runningBalance, 2) }}</td>
            </tr>
        @endforeach

        <tr>
            <td colspan="8" align="right">
                <strong>Closing Balance</strong>
            </td>
            <td>
                <strong>{{ number_format ($runningBalance, 2) }}</strong>
            </td>
        </tr>
    @else
        <tr>
            <td colspan="9" align="center">No record found.</td>
        </tr>
    @endif
    </tbody>
</table>
</body>
</html>
