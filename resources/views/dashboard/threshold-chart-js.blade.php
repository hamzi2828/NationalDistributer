<script type="text/javascript">
    let threshold_options = {
        series: [{
            name: 'Actual',
            type: 'column',
            data: [{{ implode (',', $products['expected']) }}]
        }, {
            name: 'Expected',
            type: 'line',
            data: [{{ implode (',', $products['actual']) }}]
        }],
        chart: {
            height: 350,
            type: 'line',
        },
        stroke: {
            width: [0, 4]
        },
        title: {
            text: ''
        },
        dataLabels: {
            enabled: true,
            enabledOnSeries: [1]
        },
        labels: [{{ implode (',', $products['labels']) }}],
    };

    let threshold_chart = new ApexCharts ( document.querySelector ( "#threshold-chart" ), threshold_options );
    threshold_chart.render ();
</script>