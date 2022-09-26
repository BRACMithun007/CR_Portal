
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
{{--    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />--}}

    <style>

    </style>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Monthly Repayment Schedule</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Calculators</a></li>
                            <li class="breadcrumb-item active">Monthly Repayment Schedule</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary card-outline">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <input type="number" min="0" class="form-control loan_amount" placeholder="Enter loan amount" oninput="validity.valid||(value='');">
                                    </div>
                                    <div class="col-md-3 ">
                                        <select class="form-control loan_period">
                                            <option value="">Select loan period</option>
                                            <option value="6">6 Months</option>
                                            <option value="9">9 Months</option>
                                            <option value="12">12 Months</option>
                                            <option value="18">18 Months</option>
                                            <option value="24">24 Months</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 pull-left">
                                        <button class="btn btn-primary btn-md calculate_schedule"> Calculate <b class="spinner-icon"></b></button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="image loading_brac_img" style="text-align: center;display: none;">
                                    <img src="{{url('/admin_src/img/brac_logo.gif')}}" class="img" alt="User Image">
                                </div>
                                <div class="response_msg_area" id="data"></div>
                            </div>
                            <!-- /.card -->
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>
{{--    <script src="{{ asset("admin_src/datatable/jquery.dataTables.min.js") }}"></script>--}}
{{--    <script src="{{ asset("admin_src/datatable/dataTables.responsive.min.js") }}"></script>--}}
{{--    <script src="{{ asset("admin_src/datatable/responsive.bootstrap.min.js") }}"></script>--}}

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>


    <script language="javascript">

        $(document).ready(function() {

            $(document).on('click', '.calculate_schedule', function () {
                $('.loading_brac_img').css({'display':'block'});
                $('.response_msg_area').empty();
                var loan_amount = $('.loan_amount').val();
                var loan_period = $('.loan_period').val();

                if (loan_amount == '') {
                    alert("please enter loan amount");
                    return false;
                }
                if (loan_period == '') {
                    alert("please select loan period");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/loan/get-repayment-schedule') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        loan_amount: loan_amount,
                        loan_period: loan_period
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();
                        $('.loading_brac_img').css({'display':'none'});
                        if (response.responseCode == 1) {
                            $('.response_msg_area').html(response.html);



                        } else {
                            $('.response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('.loading_brac_img').css({'display':'none'});
                    }
                });
            });

        });

        function htmlToPdf() {
            var doc = new jsPDF();
            doc.fromHTML(document.getElementById("data"),
                15,
                15,
                {'width': 170},
                function()
                {
                    doc.save("PDF_Documet.pdf");
                });
        }
    </script>


@endsection
