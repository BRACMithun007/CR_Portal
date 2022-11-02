<style>
    #loading {
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
        <h3 class="card-title">Month wise item deployed summary ( 2022 )</h3>

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
            <div class="image" id="loading" style="display: none;">
                <img src="{{url('/admin_src/img/brac_logo.gif')}}" style="margin-left: 35%" class="img" id="loading-image">
            </div>
            <canvas id="createCurrYearHccGapChart" height="250" style="width: 100%"></canvas>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<div class="modal fade" id="list-item-modal-lg">
    <div class="modal-dialog modal-xl">
        <div class="modal-content list_item_data_content">

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    var graphData = {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: "Core_business",
                backgroundColor: '#339E66FF',
                data: [
                    <?php echo $monthWiseCrCompletion["Core_Business_jan"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_feb"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_mar"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_apr"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_may"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_jun"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_jul"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_aug"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_sep"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_oct"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_nov"]; ?>,
                    <?php echo $monthWiseCrCompletion["Core_Business_dec"]; ?>
                ]
            }, {
                label: "Support",
                backgroundColor: '#078282FF',
                data: [
                    <?php echo $monthWiseCrCompletion["Support_CR_jan"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_feb"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_mar"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_apr"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_may"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_jun"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_jul"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_aug"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_sep"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_oct"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_nov"]; ?>,
                    <?php echo $monthWiseCrCompletion["Support_CR_dec"]; ?>
                ]
            }, {
                label: "Configurable",
                backgroundColor: '#00A4CCFF',
                data: [
                    <?php echo $monthWiseCrCompletion["Configurable_jan"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_feb"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_mar"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_apr"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_may"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_jun"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_jul"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_aug"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_sep"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_oct"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_nov"]; ?>,
                    <?php echo $monthWiseCrCompletion["Configurable_dec"]; ?>
                ]
            }, {
                label: "Integration",
                backgroundColor: '#414C6B',
                data: [
                    <?php echo $monthWiseCrCompletion["Integration_jan"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_feb"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_mar"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_apr"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_may"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_jun"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_jul"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_aug"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_sep"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_oct"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_nov"]; ?>,
                    <?php echo $monthWiseCrCompletion["Integration_dec"]; ?>
                ]
            }]
        },
        options: {
            responsive: false,
            legend: {
                display: true
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

    var graphCanvas = document.getElementById('createCurrYearHccGapChart');
    var myGraph = new Chart(graphCanvas, graphData);

    graphCanvas.onclick = function(evt) {
        var activePoint = myGraph.getElementAtEvent(evt)[0];
        var data = activePoint._chart.data;
        var datasetIndex = activePoint._datasetIndex;
        var section_name = data.datasets[datasetIndex].label;
        var section_value = data.datasets[datasetIndex].data[activePoint._index];
        var label_name = activePoint._model.label;
      //  console.log(section_name, section_value,label_name);
        loadModalDataForGraph(section_name,label_name);
    };

    function loadModalDataForGraph(section_name,label_name){
        $('#loading').css({'display':'block'});
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ url('/admin/graph-list-item-content') }}",
            data: {
                 cr_type: section_name,
                 month_name: label_name,
                _token: $('input[name="_token"]').val()
            },
            success: function (response) {
                $('#loading').css({'display':'none'});
               // btn.prop('disabled', false);
                if(response.responseCode == 1){
                    $('.list_item_data_content').html(response.html);
                    $('#list-item-modal-lg').modal();
                }else{

                }
            }
        });
    }

</script>
