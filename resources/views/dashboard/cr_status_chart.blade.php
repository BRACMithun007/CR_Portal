<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">CR Status Chart</h3>

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
        <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
    <!-- /.card-body -->
</div>

<script>
    var donutData        = {
        labels: [
            'Ongoing',
            'Deployed',
            'Backlog',
            'On Halt',
        ],
        datasets: [
            {
                data: [
                    <?php echo $statusValArray["Ongoing"]; ?>,
                    <?php echo $statusValArray["Deployed"]; ?>,
                    <?php echo $statusValArray["Backlog"]; ?>,
                    <?php echo $statusValArray["Halt"]; ?>
                ],
                backgroundColor : ['#ffbf00', '#04AA6D','#bf4040', '#ff8000'],
            }
        ]
    }
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData        = donutData;
    var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
    }
    //Create pie or douhnut chart
    new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieData,
        options: pieOptions
    })
</script>
