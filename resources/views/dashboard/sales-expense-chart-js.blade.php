<script type="text/javascript">
    var options = {
        series: [{
            name: 'Sales',
            data: [{{ implode (',', $month_wise_sales) }}]
        }, {
            name: 'Cash In Hand',
            data: [{{ implode (',', $cash_in_hand) }}]
        }, {
            name: 'Expanse',
            data: [{{ implode (',', $expenses) }}]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [{!! "'" . implode ( "', '", $months ) . "'" !!}],
        },
        yaxis: {
            // title: {
            //     text: '$ (thousands)'
            // }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function ( val ) {
                    return val
                }
            }
        }
    };

    var chart = new ApexCharts ( document.querySelector ( "#revenue-report-chart" ), options );
    chart.render ();
</script>
<script type="text/javascript">
    {{--$ ( window ).on ( "load", ( function () {--}}
    {{--    "use strict";--}}
    {{--    let y = document.querySelector ( "#revenue-report-chart" );--}}
    {{--    t = {--}}
    {{--        chart: { height: 230, stacked: !0, type: "bar", toolbar: { show: false } },--}}
    {{--        colors: [window.colors.solid.primary, window.colors.solid.warning],--}}
    {{--        plotOptions: { bar: { columnWidth: "17%", endingShape: "rounded" }, distributed: !0 },--}}
    {{--        series: [{--}}
    {{--            name: "Sales", data: [@if(count ($month_wise_sales)) @foreach($month_wise_sales as $month_wise_sale) {{ $month_wise_sale -> net }} {{ $loop -> last ? '' : ',' }} @endforeach @endif]--}}
    {{--        }, {--}}
    {{--            name: "Expense",--}}
    {{--            data: [@if ( count ( $expenses ) > 0 ) @php $account_head = \App\Models\Account ::find ( config ( 'constants.expenses' ) ) -> with ( 'account_type' ) -> first (); @endphp @foreach ( $expenses as  $expense) @php $running_balance = 0 @endphp @if ( in_array ( $account_head -> account_type -> id, [4, 5] ) ) @php $running_balance += $expense -> debit - $expense -> credit; @endphp @else @php $running_balance -= $expense -> debit + $expense -> credit; @endphp @endif {{ $running_balance }} {{ $loop -> last ? '' : ',' }} @endforeach @endif]--}}
    {{--        }],--}}
    {{--        dataLabels: {--}}
    {{--            enabled: false,--}}
    {{--            // formatter: function ( val ) {--}}
    {{--            //     return val;--}}
    {{--            // },--}}
    {{--            // offsetY: -20,--}}
    {{--            // style: {--}}
    {{--            //     fontSize: '14px',--}}
    {{--            //     colors: ["#ffffff", "#ffffff"]--}}
    {{--            // }--}}
    {{--        },--}}
    {{--        legend: { show: true },--}}
    {{--        grid: { padding: { top: -20, bottom: -10 }, yaxis: { lines: { show: !1 } } },--}}
    {{--        xaxis: {--}}
    {{--            categories: [@if(count ($month_wise_sales)) @foreach($month_wise_sales as $month_wise_sale) @php $time = mktime(0, 0, 0, $month_wise_sale -> month); $name = strftime("%b", $time); @endphp '{{ $name }}' {{ $loop -> last ? '' : ',' }} @endforeach @endif],--}}
    {{--            labels: { style: { colors: p, fontSize: "0.86rem" } },--}}
    {{--            axisTicks: { show: true },--}}
    {{--            axisBorder: { show: true }--}}
    {{--        },--}}
    {{--        yaxis: {--}}
    {{--            axisTicks: { show: true },--}}
    {{--            axisBorder: { show: true }--}}
    {{--        },--}}
    {{--    }, new ApexCharts ( y, t ).render ();--}}
    {{--} ) );--}}
</script>