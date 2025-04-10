<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transaction Invoice - {{ request ('voucher-no') }}</title>
    <style>
        /* @page {
            size   : auto;
            margin : 10px 15px;
        } */
        
        @page {
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
            padding : 4px 5px;
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
            <td colspan="4" align="right" width="100%" style="font-size: 22px; text-transform: uppercase">
                <strong>{{ ucwords (request ('voucher-no')) }}</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left" width="100%">
                <strong>Transaction Date:</strong>
                {{ (new App\Http\Helpers\GeneralHelper) -> format_date($transactions[0] -> transaction_date) }}
            </td>
            <td colspan="2" align="right" width="100%">
                <strong>Payment Mode: </strong> {{ ucwords ($transactions[0] -> payment_mode) }}
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left" width="100%">
                <strong>Transaction Performed:</strong>
                {{ (new App\Http\Helpers\GeneralHelper) -> format_date_time($transactions[0] -> updated_at) }}
            </td>
            @if(!empty(trim ($transactions[0] -> transaction_no)))
                <td colspan="2" align="right" width="100%">
                    <strong>Cheque/Transaction No: </strong> {{ ucwords ($transactions[0] -> transaction_no) }}
                </td>
            @endif
        </tr>
        </tbody>
    </table>
    <table width="100%" id="header" style="margin-top: 10px">
        <tbody>
        <tr>
            <td align="center" width="100%" style="background: #F5F5F5; padding: 5px;">
                <h2 style="margin: 0;">
                    {{ (new App\Http\Helpers\GeneralHelper) -> get_voucher_title(request ('voucher-no')) }}
                </h2>
            </td>
        </tr>
        </tbody>
    </table>
</header>

<table width="100%" border="1">
    <thead>
    <tr>
        <th width="5%">Sr. No</th>
        <th align="left">Account Head</th>
        <th>Debit</th>
        <th>Credit</th>
    </tr>
    </thead>
    @php $credit = 0; $debit = 0; @endphp
    @if(count ($transactions) > 0)
        <tbody>
        @foreach($transactions as $transaction)
            @php
                $credit += $transaction -> credit;
                $debit += $transaction -> credit;
            @endphp
            <tr>
                <td align="center">{{ $loop -> iteration }}</td>
                <td align="left">{{ $transaction -> account_head -> name }}</td>
                <td align="center">{{ number_format ($transaction -> debit, 2) }}</td>
                <td align="center">{{ number_format ($transaction -> credit, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" align="right"></td>
            <td align="center">
                <strong>{{ number_format ($debit, 2) }}</strong>
            </td>
            <td align="center">
                <strong>{{ number_format ($credit, 2) }}</strong>
            </td>
        </tr>
        </tfoot>
    @endif
</table>

<table width="100%" border="0">
    <tbody>
    <tr>
        <td width="22%" style="padding-left: 0">
            <strong>Total Amount In Words:</strong>
        </td>
        <td style="text-transform: uppercase; text-decoration: underline; padding-left: 0">
            {{ (new NumberFormatter("en", NumberFormatter::SPELLOUT)) -> format ($credit) }} Only
        </td>
    </tr>
    </tbody>
</table>

@if(!empty(trim ($transactions[0] -> description)))
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td width="100%" align="left">
                <strong>Description: </strong> {{ $transactions[0] -> description }}
            </td>
        </tr>
        </tbody>
    </table>
@endif

<table width="100%" border="1">
    <tbody>
    @if(count ($transactions) > 0)
        @foreach($transactions as $key => $transaction)
            @if(count ($transaction -> transaction_details) > 0)
                @php
                    $vouchers = $transaction -> transaction_details -> pluck('voucher') -> toArray();
                @endphp
                <tr>
                    <td width="20%">
                        Against
                        @if(in_array ('crv', $vouchers) || in_array ('brv', $vouchers))
                        Sale Invoices
                        @elseif(in_array ('cpv', $vouchers) || in_array ('bpv', $vouchers))
                        Stock Invoices
                        @endif
                    </td>
                    <td>
                        @if(in_array ('crv', $vouchers) || in_array ('brv', $vouchers))
                            @php
                                $sales = $transaction -> transaction_details -> pluck('sale_id') -> toArray();
                            @endphp
                            {{ implode (',', $sales) }}
                        @elseif(in_array ('cpv', $vouchers) || in_array ('bpv', $vouchers))
                            @php
                                $stocks = $transaction -> transaction_details -> pluck('stock_id') -> toArray();
                                $references = \App\Models\Stock::whereIn('id', $stocks) -> pluck('invoice_no') -> toArray();
                            @endphp
                            {{ implode (',', $references) }}
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
    @endif
    </tbody>
</table>

<table width="100%" border="0" style="margin-top: 100px">
    <tbody>
    <tr>
        <td width="25%" align="center" style="padding-left: 0">
            <strong>{{ \App\Models\User::find($transactions[0] -> user_id) -> name }}</strong>
            _____________________________<br />
            Prepared By
        </td>
        
        <td width="25%" align="center" style="padding-left: 0">
            -<br />
            _____________________________<br />
            Verified By
        </td>
        
        <td width="25%" align="center" style="padding-left: 0">
            -<br />
            _____________________________<br />
            Received By
        </td>
        
        <td width="25%" align="center" style="padding-left: 0">
            -<br />
            _____________________________<br />
            Approved By
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
