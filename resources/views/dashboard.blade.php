
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
@endsection


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
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$ongoingCR}}</h3>
                                <p>Ongoing CR</p>
                            </div>
                            <div class="icon">
                                <i class="ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">Details..<i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>


                <div class="row">
                    <div class="col-md-5">
                        <div class="image loading_brac_img_for_chart" style="text-align: center;display: none;">
                            <img src="{{url('/admin_src/img/brac_logo.gif')}}" class="img" alt="User Image">
                        </div>
                        <div class="crChartContent"></div>
                    </div>

                    <div class="col-md-7">
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






    });

</script>
