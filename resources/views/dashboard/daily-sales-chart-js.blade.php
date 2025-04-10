<script type="text/javascript">
    let daily_sales = {
        series: [{
            name: 'Sale',
            data: [{{ $daily_sales['values'] }}],
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded',
                distributed: true
            },
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [{!! "'" . implode ( "', '", $daily_sales['days'] ) . "'" !!}],
        },
        yaxis: {
            title: {
                text: 'Sales Value'
            }
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            y: {
                formatter: function ( val ) {
                    return val;
                }
            }
        }
    };

    let daily_sales_chart = new ApexCharts ( document.querySelector ( "#daily-sales-chart" ), daily_sales );
    daily_sales_chart.render ();
</script>