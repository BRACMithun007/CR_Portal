
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
@endsection

<style>

</style>

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info itemBoxOngoing">
                            <div class="inner" style="cursor: pointer;">
                                <h3>{{$ongoingCR}}</h3>
                                <h5>Item Ongoing</h5>
                            </div>
                            <div class="icon">
                                <i class="ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer"></a>
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div class="image loading_brac_img_for_chart" style="text-align: center;display: none;">
                            <img src="{{url('/admin_src/img/brac_logo.gif')}}" class="img" alt="User Image">
                        </div>
                        <div class="crChartContent"></div>
                    </div>

                    <div class="col-md-8">
                        <div class="image loading_brac_img_for_area_chart" style="text-align: center;display: none;">
                            <img src="{{url('/admin_src/img/brac_logo.gif')}}" class="img" alt="User Image">
                        </div>
                        <div class="crAreaChartContent"></div>
                    </div>

                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection


@section('scripts')
    @include('layouts.admin_common_js')
@endsection
<script src="{{asset('admin_src/plugins/jquery/jquery.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
<script>

    $(document).ready(function() {

        loadChart();
        loadAreaChart();

        function loadChart(){
           $('.loading_brac_img_for_chart').css({'display':'block'});

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('/admin/load-cr-status-chart') }}",
                data: {
                    _token: $('input[name="_token"]').val()
                },
                success: function (response) {
                    $('.loading_brac_img_for_chart').css({'display':'none'});
                    if(response.responseCode == 1){
                        $('.crChartContent').html(response.html);
                    }else{

                    }
                }
            });
        }

        function loadAreaChart(){
            $('.loading_brac_img_for_area_chart').css({'display':'block'});

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('/admin/load-cr-area-chart') }}",
                data: {
                    _token: $('input[name="_token"]').val()
                },
                success: function (response) {
                    $('.loading_brac_img_for_area_chart').css({'display':'none'});
                    if(response.responseCode == 1){
                        $('.crAreaChartContent').html(response.html);
                    }else{

                    }
                }
            });
        }

        $(document).on('click', '.itemBoxOngoing', function () {

            $('#loading_img').css({'display':'block'});
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ url('/admin/chart-list-item-content') }}",
                data: {
                    status_name: 'Ongoing',
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

        });




    });

</script>
