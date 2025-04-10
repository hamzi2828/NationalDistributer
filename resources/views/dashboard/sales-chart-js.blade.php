<script type="text/javascript">
    let h = document.querySelector ( "#line-chart" ), m = {
        chart: {
            height: 400,
            type: "line",
            zoom: { enabled: !1 },
            parentHeightOffset: 0,
            toolbar: { show: !1 }
        },
        series: [{
            data: [{{ implode (',', $month_wise_sales) }}]
        }],
        markers: {
            strokeWidth: 7,
            strokeOpacity: 1,
            strokeColors: [window.colors.solid.white],
            colors: [window.colors.solid.warning]
        },
        dataLabels: { enabled: !1 },
        stroke: { curve: "straight" },
        colors: [window.colors.solid.warning],
        grid: { xaxis: { lines: { show: !0 } }, padding: { top: -20 } },
        tooltip: {
            custom: function ( e ) {
                return '<div class="px-1 py-50"><span>' + e.series[ e.seriesIndex ][ e.dataPointIndex ] + "</span></div>"
            }
        },
        xaxis: {
            categories: [{!! "'" . implode ( "', '", $months ) . "'"  !!}]
        },
        yaxis: { opposite: t }
    };
    void 0 !== typeof h && null !== h && new ApexCharts ( h, m ).render ();
</script>