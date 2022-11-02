
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
{{--    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />--}}
{{--    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />--}}

    <style>
        .input_error_mark{
            border-color: red;
        }
        .input_valid_mark{
            border-color: #d9c6c6;
        }
    </style>
@endsection


@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Loan Repayment Schedule</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Calculators</a></li>
                            <li class="breadcrumb-item active">Loan Repayment Schedule</li>
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
                                    <div class="col-md-2 ">
                                        <b>Loan Amount </b><input type="number" min="0" class="form-control loan_amount" oninput="validity.valid||(value='');">
                                    </div>
                                    <div class="col-md-2 ">
                                        <b>Interest Rate (%) </b><input type="number" min="0" class="form-control interest_percentage" oninput="validity.valid||(value='');">
                                    </div>
                                    <div class="col-md-3 ">
                                        <b>Loan Period </b><select class="form-control loan_period">
                                            <option value="">Select loan period</option>
                                            <option value="3">3 Months</option>
                                            <option value="6">6 Months</option>
                                            <option value="9">9 Months</option>
                                            <option value="12">12 Months</option>
                                            <option value="18">18 Months</option>
                                            <option value="24">24 Months</option>
                                            <option value="36">36 Months</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 pull-left">
                                        <div>&nbsp;</div>
                                        <button class="btn btn-md calculate_schedule" style="background-color: #009A93;color: white;"> Calculate <b class="spinner-icon"></b></button>
                                    </div>
                                    <div class="col-md-2 pull-right">
                                        <div>&nbsp;</div>
                                        <button type="button" class="btn btn-primary float-right excel_export" style="background-color: #009A93;">
                                            <i class="fas fa-download"></i> Export
                                        </button>
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

            $(document).on('click', '.excel_export', function () {

                var loan_amount = $('.loan_amount').val();
                var loan_period = $('.loan_period').val();
                var interest_percentage = $('.interest_percentage').val();

                $('.loan_amount').removeClass('input_error_mark');
                $('.loan_period').removeClass('input_error_mark');
                $('.interest_percentage').removeClass('input_error_mark');
                var has_input_error = false;

                if (loan_amount == '') {
                    $('.loan_amount').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (loan_period == '') {
                    $('.loan_period').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (interest_percentage == '') {
                    $('.interest_percentage').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (has_input_error){
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);

                location.href = '{{ url('/calculators/export-loan-repayment-schedule-as-excel')}}'+'?loan_amount='+loan_amount+'&loan_period='+loan_period+'&interest_percentage='+interest_percentage;

                btn.prop('disabled', false);
                $('.export-spinner-icon').empty();
            });

            $(document).on('click', '.calculate_schedule', function () {
                var loan_amount = $('.loan_amount').val();
                var loan_period = $('.loan_period').val();
                var interest_percentage = $('.interest_percentage').val();

                $('.loan_amount').removeClass('input_error_mark');
                $('.loan_period').removeClass('input_error_mark');
                $('.interest_percentage').removeClass('input_error_mark');
                var has_input_error = false;

                if (loan_amount == '') {
                    $('.loan_amount').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (loan_period == '') {
                    $('.loan_period').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (interest_percentage == '') {
                    $('.interest_percentage').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (has_input_error){
                    return false;
                }

                $('.loading_brac_img').css({'display':'block'});
                $('.response_msg_area').empty();

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/calculators/get-loan-repayment-schedule') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        loan_amount: loan_amount,
                        interest_percentage: interest_percentage,
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
