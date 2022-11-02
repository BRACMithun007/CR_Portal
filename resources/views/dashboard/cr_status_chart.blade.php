<style>
    #loading_img {
        position: fixed;
        display: block;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        text-align: center;
        opacity: 0.7;
        background-color: #fff;
        z-index: 99;
    }

    #loading-image {
        position: absolute;
        top: 100px;
        left: 240px;
        z-index: 100;
    }
</style>

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
        <div class="image" id="loading_img" style="display: none;">
            <img src="{{url('/admin_src/img/brac_logo.gif')}}" style="margin-left: 35%" class="img" id="loading-image">
        </div>
        <canvas id="statusPieChart" height="250" style="width: 100%"></canvas>
    </div>
    <!-- /.card-body -->
</div>

<div class="modal fade" id="chart-list-item-modal-lg">
    <div class="modal-dialog modal-xl">
        <div class="modal-content chart_list_item_data_content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    const chartData = {
        labels: [
            'Ongoing',
            'Deployed',
            'Backlog',
            'On Halt'
        ],
        datasets: [{
            label: ['Ongoing', 'Deployed', 'Backlog','Halt'],
            data: [
                <?php echo $statusValArray["Ongoing"]; ?>,
                <?php echo $statusValArray["Deployed"]; ?>,
                <?php echo $statusValArray["Backlog"]; ?>,
                <?php echo $statusValArray["Halt"]; ?>
            ],
            backgroundColor: ['#f2ce02', '#209c05','#bb0816', '#434db0'],
            hoverOffset: 4
        }]
    };
    const config = {
        type: 'pie',
        data: chartData,
    };

    var canvas = document.getElementById('statusPieChart');
    var myChart = new Chart(canvas, config);
    //
    canvas.onclick = function(evt) {
        var activePoint = myChart.getElementAtEvent(evt)[0];
        var data = activePoint._chart.data;
        var datasetIndex = activePoint._datasetIndex;
        var section_name = data.datasets[datasetIndex].label;
        var status_name = activePoint._model.label;

        loadModalDataForChart(status_name);
    };

    function loadModalDataForChart(status_name){
        $('#loading_img').css({'display':'block'});
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ url('/admin/chart-list-item-content') }}",
            data: {
                status_name: status_name,
                _token: $('input[name="_token"]').val()
            },
            success: function (response) {
                $('#loading_img').css({'display':'none'});
                // btn.prop('disabled', false);
                if(response.responseCode == 1){
                    $('.chart_list_item_data_content').html(response.html);
                    $('#chart-list-item-modal-lg').modal();
                }else{

                }
            }
        });
    }
</script>
