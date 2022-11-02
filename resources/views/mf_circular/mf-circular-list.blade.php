
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />
    <link rel="stylesheet" href="{{ asset("admin_src/datepicker-oss/css/bootstrap-datetimepicker.min.css") }}" />

    <style>
        .paginate_button.previous{
            background-color: #009A93;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: pointer;
        }
        .paginate_button.next{
            background-color: #009A93;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: pointer;
        }

        .paginate_button.current{
            background-color: #893366;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: no-drop;
        }
        .paginate_button{
            background-color: #009A93;
            color: white;
            padding: 2px;
            border-radius: 2px;
            cursor: pointer;
            margin-right: 10px;
        }
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
                        <h1>Circular list (MF)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Circular</li>
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
                                        @if(App\Libraries\aclHandler::hasActionAccess('circular_write') == true)
                                            <button type="button" class="btn" style="background-color: #009A93;color: white;"  data-toggle="modal" data-target="#add-modal-lg">
                                                Add Circular
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group clearfix" style="margin-top: 2px;">
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="loan" id="checkboxSuccess1">
                                                <label for="checkboxSuccess1"> Loan &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="general_savings" id="checkboxSuccess2">
                                                <label for="checkboxSuccess2"> General Savings &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="special_savings" id="checkboxSuccess3">
                                                <label for="checkboxSuccess3"> Special Savings &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="insurance" id="checkboxSuccess4">
                                                <label for="checkboxSuccess4"> Insurance &nbsp;</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
{{--                                        <button type="button" class="btn btn-primary float-right excel_export" style="background-color: #EC008C;">--}}
{{--                                            <i class="fas fa-download"></i>Export--}}
{{--                                        </button>--}}
                                    </div>
                                </div>

                            </div>
                            <div class="card-body table_area">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-sm table-responsive">
                                    <table id="mf_circular_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr style="background: #009A93;color: white;">
                                            <th>Title</th>
                                            <th>Request by</th>
                                            <th>Category</th>
{{--                                            <th>Expected Timeline</th>--}}
                                            <th>Status</th>
                                            <th>Updated at</th>
                                            <th>Documents</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
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

    <!-- /.Add User Modal -->
    <div class="modal fade" id="add-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New circular</h4>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="add_response_msg_area"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInput">Circular Title <b style="color: red">*</b></label>
                                <textarea name="circular_title" class="form-control circular_title"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Select circular category <b style="color: red">*</b></label>
                                <select class="form-control circular_category" name="circular_category">
                                    <option value="">Select circular category</option>
                                    <option value="insurance">Insurance</option>
                                    <option value="loan">Loan</option>
                                    <option value="general_savings">General Savings</option>
                                    <option value="special_savings">Special Savings</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Circular number <b style="color: red">*</b></label>
                                <input name="circular_number" type="text" class="form-control circular_number" placeholder="circular number">
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Requester team <b style="color: red">*</b></label>
                                <input name="requester_team" type="text" class="form-control requester_team" placeholder="requester team">
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Circular sign date</label>
                                <input name="sign_date" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control sign_date my_datepicker">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInput">Circular Details <b style="color: red">*</b></label>
                                <textarea name="circular_details" class="form-control circular_details"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Expected timeline</label>
                                <input name="mf_expect_timeline" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control mf_expect_timeline my_datepicker" placeholder="Expected timeline">
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Circular type</label>
                                <select class="form-control circular_type" name="circular_type">
                                    <option value="">Select One</option>
                                    <option value="Core_Business">Core Business</option>
                                    <option value="Support_CR">Support CR</option>
                                    <option value="Configurable">Configurable Item</option>
                                    <option value="Integration">Integration</option>
                                    <option value="Data_Correction">Data Correction</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">Effective date</label>
                                <input name="effective_date" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control effective_date my_datepicker">
                            </div>

                            <div class="form-group">
                                <label for="exampleInput">JIRA Code</label>
                                <input name="jira_code" type="text" class="form-control jira_code" placeholder="JIRA code">
                            </div>

                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Circular file attachment (Allow PDF only) <b style="color: red">*</b></label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input circular_doc" name="circular_doc " accept="application/pdf" id="circular_doc">
                                        <label class="custom-file-label label_circular_doc" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    <button type="button" class="btn btn-primary store_circular"> <span class="spinner-icon"></span> Save circular </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.Edit Circular Modal -->
    <div class="modal fade" id="edit-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Circular</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="edit_response_msg_area"></div>
                    <div class="edit_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn" style="background-color: #009A93;color: white;" data-dismiss="modal">Close</button>
                    <button type="button" class="btn update_circular" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Update </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.Circular import Modal -->
    <div class="modal fade" id="import-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import Circular</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="import_response_msg_area"></div>
                    <div class="import_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn" style="background-color: #009A93;color: white;" data-dismiss="modal">Close</button>
                    <button type="button" class="btn import_circular" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Import </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection


@section('scripts')
    @include('layouts.admin_common_js')
    <script src="{{ asset("admin_src/datatable/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/dataTables.responsive.min.js") }}"></script>
    <script src="{{ asset("admin_src/datatable/responsive.bootstrap.min.js") }}"></script>
    <script src="{{ asset("admin_src/datepicker-oss/js/bootstrap-datetimepicker.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>


    <script language="javascript">

        $(document).ready(function() {

            $(document).on('click', '.import_circular', function () {
                $('.import_response_msg_area').empty();
                var cr_title = $('.cr_title').val();
                var jira_code = $('.import_jira_code').val();
                var approved_billable_effort = $('.approved_billable_effort').val();
                var category = $('.category').val();
                var vendor_name = $('.vendor_name').val();
                var vendor_proposed_timeline = $('.vendor_proposed_timeline').val();
                var priority = $('.priority').val();
                var cr_status = $('.cr_status').val();
                var business_analyst = $('.business_analyst').val();
                var uat_instance = $('.uat_instance').val();
                var cr_details = $('.cr_details').val();
                var initial_requirement_shared_from_mf = $('.initial_requirement_shared_from_mf').val();
                var team_name = $('.team_name').val();
                var cr_locked_by_vendor = $('.cr_locked_by_vendor').val();
                var mf_expect_timeline = $('.importable_mf_expect_timeline').val();
                var requester_team = $('.import_requester_team').val();
                var cr_type = $('.cr_type').val();
                var completed_on = $('.completed_on').val();
                var assigned_from_brac = $('.assigned_from_brac').val();
                var uat_credential = $('.uat_credential').val();
                var satisfactory_level = $('.satisfactory_level').val();
                var jira_created = $('.jira_created').val();
                var circular_id = $('.circular_id').val();
                var has_input_error = false;


                $('.import_response_msg_area').html('');
                $('.cr_title').removeClass('input_error_mark');
                $('.category').removeClass('input_error_mark');
                $('.vendor_name').removeClass('input_error_mark');
                $('.cr_details').removeClass('input_error_mark');
                $('.team_name').removeClass('input_error_mark');
                $('.import_requester_team').removeClass('input_error_mark');
                $('.mf_expect_timeline').removeClass('input_error_mark');
                $('.cr_type').removeClass('input_error_mark');
                $('.assigned_from_brac').removeClass('input_error_mark');

                if (mf_expect_timeline == '') {
                    $('.mf_expect_timeline').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_title == '') {
                    $('.cr_title').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (category == '') {
                    $('.category').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (vendor_name == '') {
                    $('.vendor_name').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_status == '') {
                    $('.cr_status').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_details == '') {
                    $('.cr_details').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (team_name == '') {
                    $('.team_name').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (requester_team == '') {
                    $('.import_requester_team').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_type == '') {
                    $('.cr_type').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (assigned_from_brac == '') {
                    $('.assigned_from_brac').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (has_input_error){
                    $('.import_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    $('#import-modal-lg').animate({ scrollTop: 0 }, 'slow');
                    return false;
                }

                let formData = new FormData();
                var file_for_cr_doc = document.getElementById("cr_doc");
                if( file_for_cr_doc.files.length != 0 ){
                    formData.append('cr_doc', $('.cr_doc')[0].files[0]);
                }
                formData.append('cr_title', cr_title);
                formData.append('jira_code', jira_code);
                formData.append('jira_created', jira_created);
                formData.append('approved_billable_effort', approved_billable_effort);
                formData.append('category', category);
                formData.append('vendor_name', vendor_name);
                formData.append('vendor_proposed_timeline', vendor_proposed_timeline);
                formData.append('priority', priority);
                formData.append('cr_status', cr_status);
                formData.append('business_analyst', business_analyst);
                formData.append('uat_instance', uat_instance);
                formData.append('cr_details', cr_details);
                formData.append('initial_requirement_shared_from_mf', initial_requirement_shared_from_mf);
                formData.append('team_name', team_name);
                formData.append('cr_locked_by_vendor', cr_locked_by_vendor);
                formData.append('mf_expect_timeline', mf_expect_timeline);
                formData.append('requester_team', requester_team);
                formData.append('cr_type', cr_type);
                formData.append('completed_on', completed_on);
                formData.append('assigned_from_brac', assigned_from_brac);
                formData.append('uat_credential', uat_credential);
                formData.append('satisfactory_level', satisfactory_level);
                formData.append('circular_id', circular_id);


                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/circular/import-new-circular') }}',
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData: false,
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();
                        $('#import-modal-lg').animate({ scrollTop: 0 }, 'slow');

                        if (response.responseCode == 1) {
                            $('.import_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.cr_title').val("");
                            $('.jira_code').val("");
                            $('.approved_billable_effort').val("");
                            $('.category').val("");
                            $('.vendor_name').val("");
                            $('.vendor_proposed_timeline').val("");
                            $('.cr_status').val("");
                            $('.business_analyst').val("");
                            $('.uat_instance').val("");
                            $('.cr_details').val("");
                            $('.initial_requirement_shared_from_mf').val("");
                            $('.team_name').val("");
                            $('.cr_locked_by_vendor').val("");
                            $('.mf_expect_timeline').val("");
                            $('.requester_team').val("");
                            $('.cr_type').val("");
                            $('.cr_doc').val("");
                            $('.custom-file-label').html('Select file');
                            $('.completed_on').val("");
                            $('.assigned_from_brac').val("");
                            $('.uat_credential').val("");
                            $('.satisfactory_level').val("");

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#import-modal-lg').modal('hide');
                            }, 3200);

                            $('#mf_circular_list').dataTable().fnClearTable();
                            $('#mf_circular_list').dataTable().fnDestroy();
                            getMFCircularList();

                        } else {
                            $('.import_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $('.my_datepicker').datetimepicker({
                //   viewMode: 'years',
                format: 'DD-MM-YYYY',
                // maxDate: (new Date()),
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

            function getMFCircularList() {

                var loan = false;
                var general_savings = false;
                var special_savings = false;
                var insurance = false;

                $("input:checkbox[name=checkBoxVal]:checked").each(function(){
                    if ($(this).val() == 'loan'){
                        loan = true;
                    }else if($(this).val() == 'general_savings'){
                        general_savings = true;
                    }else if($(this).val() == 'special_savings'){
                        special_savings = true;
                    }else if($(this).val() == 'insurance'){
                        insurance = true;
                    }
                });

                $('#mf_circular_list').DataTable({
                    iDisplayLength: 15,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    paging: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/circular/get-mf-circular-list")}}',
                        method: 'post',
                        data: function (d) {
                            d.loan = loan;
                            d.general_savings = general_savings;
                            d.special_savings = special_savings;
                            d.insurance = insurance;
                        }
                    },
                    columns: [
                        {data: 'title', name: 'title', searchable: true ,orderable: false},
                        {data: 'request_by', name: 'request_by', searchable: true ,orderable: false},
                        {data: 'category', name: 'category', searchable: true ,orderable: false},
                        // {data: 'mf_expect_timeline', name: 'mf_expect_timeline', searchable: true ,orderable: false},
                        {data: 'status', name: 'status', searchable: true ,orderable: false},
                        {data: 'updated_at', name: 'updated_at', searchable: true ,orderable: false},
                        {data: 'downloads', name: 'downloads', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getMFCircularList();

            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
            });

            $(document).on('click', '.checkBoxVal', function () {
                $('#mf_circular_list').dataTable().fnClearTable();
                $('#mf_circular_list').dataTable().fnDestroy();
                getMFCircularList();
            });

            $(document).on('click', '.store_circular', function () {

                $('.add_response_msg_area').empty();
                var circular_category = $('.circular_category').val();
                var circular_title = $('.circular_title').val();
                var circular_details = $('.circular_details').val();
                var circular_number = $('.circular_number').val();
                var requester_team = $('.requester_team').val();
                var sign_date = $('.sign_date').val();
                var circular_type = $('.circular_type').val();
                var effective_date = $('.effective_date').val();
                var jira_code = $('.jira_code').val();
                var mf_expect_timeline = $('.mf_expect_timeline').val();
                var file_for_circular_doc = document.getElementById("circular_doc");
                var has_input_error = false;

                $('.add_response_msg_area').html('');
                $('.circular_category').removeClass('input_error_mark');
                $('.circular_title').removeClass('input_error_mark');
                $('.circular_details').removeClass('input_error_mark');
                $('.label_circular_doc').removeClass('input_error_mark');
                $('.circular_number').removeClass('input_error_mark');
                $('.requester_team').removeClass('input_error_mark');

                if (circular_number == '') {
                    $('.circular_number').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (requester_team == '') {
                    $('.requester_team').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (circular_category == '') {
                    $('.circular_category').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (circular_title == '') {
                    $('.circular_title').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (circular_details == '') {
                    $('.circular_details').addClass('input_error_mark');
                    has_input_error = true;
                }
                if( file_for_circular_doc.files.length == 0 ){
                    $('.label_circular_doc').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (has_input_error){
                    $('.add_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    $('#add-modal-lg').animate({ scrollTop: 0 }, 'slow');
                    return false;
                }

                let formData = new FormData();
                formData.append('circular_doc', $('.circular_doc')[0].files[0]);
                formData.append('circular_title', circular_title);
                formData.append('circular_details', circular_details);
                formData.append('circular_category', circular_category);
                formData.append('mf_expect_timeline', mf_expect_timeline);
                formData.append('circular_number', circular_number);
                formData.append('requester_team', requester_team);
                formData.append('sign_date', sign_date);
                formData.append('circular_type', circular_type);
                formData.append('effective_date', effective_date);
                formData.append('jira_code', jira_code);

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/circular/add-new-circular') }}',
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData: false,
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();
                        $('#add-modal-lg').animate({ scrollTop: 0 }, 'slow');

                        if (response.responseCode == 1) {
                            $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.circular_title').val("");
                            $('.circular_details').val("");
                            $('.circular_category').val("");
                            $('.circular_doc').val("");
                            $('.label_circular_doc').html("Choose File");
                            $('.mf_expect_timeline').val("");
                            $('.circular_number').val("");
                            $('.requester_team').val("");
                            $('.sign_date').val("");
                            $('.circular_type').val("");
                            $('.effective_date').val("");
                            $('.jira_code').val("");

                            $('.alert-success').fadeOut(3000);

                            $('#mf_circular_list').dataTable().fnClearTable();
                            $('#mf_circular_list').dataTable().fnDestroy();
                            getMFCircularList();


                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                        } else {
                            $('.add_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $(document).on('click', '.open_circular_modal', function () {

                var circular_id = jQuery(this).data('circular_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/circular/get-mf-circular-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        circular_id: circular_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.edit_data_content').html(response.html);
                            $('#edit-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.open_circular_import_modal', function () {

                var circular_id = jQuery(this).data('circular_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/circular/get-importable-circular-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        circular_id: circular_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.import_data_content').html(response.html);
                            $('#import-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.update_circular', function () {
                $('.edit_response_msg_area').empty();
                var circular_id = $('.update_circular_id').val();
                var circular_category = $('.update_circular_category').val();
                var circular_title = $('.update_circular_title').val();
                var circular_doc = $('.update_circular_doc').val();
                var circular_details = $('.update_circular_details').val();
                var update_mf_expect_timeline = $('.update_mf_expect_timeline').val();

                var circular_number = $('.update_circular_number').val();
                var requester_team = $('.update_requester_team').val();
                var sign_date = $('.update_sign_date').val();
                var circular_type = $('.update_circular_type').val();
                var effective_date = $('.update_effective_date').val();
                var jira_code = $('.update_jira_code').val();

                var file_for_circular_doc = document.getElementById("update_circular_doc");
                var edit_has_input_error = false;


                $('.update_circular_category').removeClass('input_error_mark');
                $('.update_circular_title').removeClass('input_error_mark');
                $('.update_circular_details').removeClass('input_error_mark');
                $('.label_update_circular_doc').removeClass('input_error_mark');
                $('.update_circular_number').removeClass('input_error_mark');
                $('.update_requester_team').removeClass('input_error_mark');

                if (circular_number == '') {
                    $('.update_circular_number').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (requester_team == '') {
                    $('.update_requester_team').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (circular_category == '') {
                    $('.update_circular_category').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (circular_title == '') {
                    $('.update_circular_title').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (circular_details == '') {
                    $('.update_circular_details').addClass('input_error_mark');
                    edit_has_input_error = true;
                }

                if (edit_has_input_error){
                    $('.edit_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    $('#edit-modal-lg').animate({ scrollTop: 0 }, 'slow');
                    return false;
                }

                let formData = new FormData();
                if( file_for_circular_doc.files.length != 0 ){
                    formData.append('circular_doc', $('.update_circular_doc')[0].files[0]);
                }
                formData.append('circular_id', circular_id);
                formData.append('circular_title', circular_title);
                formData.append('circular_details', circular_details);
                formData.append('circular_category', circular_category);
                formData.append('mf_expect_timeline', update_mf_expect_timeline);
                formData.append('circular_number', circular_number);
                formData.append('requester_team', requester_team);
                formData.append('sign_date', sign_date);
                formData.append('circular_type', circular_type);
                formData.append('effective_date', effective_date);
                formData.append('jira_code', jira_code);

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/circular/update-mf-circular-info') }}',
                    type: "POST",
                    contentType: false,
                    cache: false,
                    processData: false,
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: formData,
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();
                        $('#edit-modal-lg').animate({ scrollTop: 0 }, 'slow');

                        if (response.responseCode == 1) {
                            $('.edit_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#edit-modal-lg').modal('hide');
                            }, 3200);

                            $('#mf_circular_list').dataTable().fnClearTable();
                            $('#mf_circular_list').dataTable().fnDestroy();
                            getMFCircularList();

                        } else {
                            $('.edit_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $(document).on('click', '.delete_circular', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var circular_id = jQuery(this).data('circular_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/circular/delete-mf-circular') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        circular_id: circular_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.delete_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            $('#mf_circular_list').dataTable().fnClearTable();
                            $('#mf_circular_list').dataTable().fnDestroy();
                            getMFCircularList();
                        }else{
                            $('.delete_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    }
                });

            });

        });

    </script>


@endsection
