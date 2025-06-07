import ApexCharts from 'apexcharts';

export function renderChart(selector, seriesData, categoryData) {
    const options = {
        series: seriesData,
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            toolbar: { show: true },
            zoom: { enabled: true }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 10,
                borderRadiusApplication: 'end',
                borderRadiusWhenStacked: 'last',
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        xaxis: {
            type: 'category',
            categories: categoryData,
            labels: {
                style: {
                    fontSize: '12px'
                }
            }
        },
        legend: {
            position: 'right',
            offsetY: 40
        },
        fill: {
            opacity: 1
        }
    };

    const chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}
