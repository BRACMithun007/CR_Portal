
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<body>

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Month wise CR completion (2022)</h3>

        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="chart">
        <canvas id="createCurrYearHccGapChart" height="400" style="width: 100%"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<script>
    var chartData = {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: "FAP",
                backgroundColor: '#cc3399',
                data: [6, 7, 6, 8, 6, 10, 3]
            }, {
                label: "FAO",
                backgroundColor: '#0099ff',
                data: [8, 9, 5, 8, 6, 10, 3]
            }, {
                label: "EA",
                backgroundColor: '#0022ff',
                data: [6, 7, 6, 8, 6, 10, 3]
            }]
        },
        options: {
            responsive: false,
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    stacked: true
                }],
                xAxes: [{
                    stacked: true
                }]
            },

        }
    }

    var canvas = document.getElementById('createCurrYearHccGapChart');
    var myChart = new Chart(canvas, chartData);

    canvas.onclick = function(evt) {
        var activePoint = myChart.getElementAtEvent(evt)[0];
        var data = activePoint._chart.data;
        var datasetIndex = activePoint._datasetIndex;
        var label = data.datasets[datasetIndex].label;
        var value = data.datasets[datasetIndex].data[activePoint._index];
        console.log(label, value);
    };
</script>
