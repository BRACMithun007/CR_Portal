
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
    <link rel="stylesheet" href="{{ asset("admin_src/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}" />
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
                        <h1>Loan Premium Calculation</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('/')}}">Calculators</a></li>
                            <li class="breadcrumb-item active">Premium</li>
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
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <b>Payment Type </b>
                                                <select class="form-control payment_type">
                                                    <option value="General">General</option>
                                                    <option value="Bullet">Bullet</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 ">
                                                <b>Policy Type </b>
                                                <select class="form-control premium_type">
                                                    <option value="Single">Single</option>
                                                    <option value="Double">Double</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 ">
                                                <b>Loan duration in month </b>
                                                <input type="number" min="0" class="form-control loan_duration" oninput="validity.valid||(value='');">
                                            </div>
                                            <div class="col-md-4 ">
                                                <b>Loan Amount </b>
                                                <input type="number" min="0" class="form-control loan_amount" oninput="validity.valid||(value='');">
                                            </div>
                                            <div class="col-md-4 ">
                                                <b>Borrower birthday </b>
                                                <input name="borrower_birth_day" type="text" autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control borrower_birth_day my_datepicker">
                                            </div>
                                            <div class="col-md-4 second_insurer_birth_day_div" style="display: none;">
                                                <b>2nd Insurer birthday </b>
                                                <input name="second_insurer_birth_day" autocomplete="off" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control second_insurer_birth_day my_datepicker">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div>&nbsp;</div>
                                        <button class="btn btn-md calculate_premium" style="background-color: #009A93;color: white;"> Calculate Loan Premium Amount <b class="spinner-icon"></b></button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <div class="image loading_brac_img" style="text-align: center;display: none;">
                                    <img src="{{url('/admin_src/img/brac_logo.gif')}}" class="img" alt="User Image">
                                </div>
                                <div class="response_msg_area">
                                </div>
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
    <script src="{{ asset("admin_src/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>


    <script language="javascript">

        $(document).ready(function() {

            $('.my_datepicker').datetimepicker({
                //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                maxDate: new Date(),
                useCurrent: false,
                // minDate: calDate
                icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
                    previous: "fa fa-chevron-left",
                    next: "fa fa-chevron-right",
                    today: "fa fa-clock-o",
                    clear: "fa fa-trash-o"
                }
            });

            $(document).on('change', '.premium_type', function () {
                var premium_type = $('.premium_type').val();
                if(premium_type == 'Double'){
                    $('.second_insurer_birth_day_div').css({'display':'block'})
                }else {
                    $('.second_insurer_birth_day').val('');
                    $('.second_insurer_birth_day_div').css({'display':'none'})
                }

            });

            $(document).on('click', '.calculate_premium', function () {
                var payment_type = $('.payment_type').val();
                var premium_type = $('.premium_type').val();
                var loan_duration = $('.loan_duration').val();
                var loan_amount = $('.loan_amount').val();
                var borrower_birth_day = $('.borrower_birth_day').val();
                var second_insurer_birth_day = $('.second_insurer_birth_day').val();

                $('.payment_type').removeClass('input_error_mark');
                $('.premium_type').removeClass('input_error_mark');
                $('.loan_duration').removeClass('input_error_mark');
                $('.loan_amount').removeClass('input_error_mark');
                $('.borrower_birth_day').removeClass('input_error_mark');
                $('.second_insurer_birth_day').removeClass('input_error_mark');
                var has_input_error = false;

                if (payment_type == '') {
                    $('.payment_type').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (premium_type == '') {
                    $('.premium_type').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (loan_duration == '') {
                    $('.loan_duration').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (loan_amount == '') {
                    $('.loan_amount').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (borrower_birth_day == '') {
                    $('.borrower_birth_day').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (second_insurer_birth_day == '' && premium_type == 'Double') {
                    $('.second_insurer_birth_day').addClass('input_error_mark');
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
                    url: '{{ url('/calculators/get-loan-premium-result') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        payment_type: payment_type,
                        premium_type: premium_type,
                        loan_duration: loan_duration,
                        loan_amount: loan_amount,
                        borrower_birth_day: borrower_birth_day,
                        second_insurer_birth_day: second_insurer_birth_day
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();
                        $('.loading_brac_img').css({'display':'none'});
                        if (response.responseCode == 1) {
                            $('.response_msg_area').html(response.html);

                        } else {
                            $('.response_msg_area').html('<div class="alert alert-warning">\n' +
                                '                                <strong></strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('.loading_brac_img').css({'display':'none'});
                    }
                });
            });

        });

    </script>


@endsection
