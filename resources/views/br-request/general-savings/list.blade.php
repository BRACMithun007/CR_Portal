
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
                        <h1>Request (General savings)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Request CR</li>
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
                                            <button type="button" class="btn" style="background-color: #009A93;color: white;"  data-toggle="modal" data-target="#add-modal-lg">
                                                Add Item
                                            </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table_area">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-sm table-responsive">
                                    <table id="mf_req_cr_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr style="background: #009A93;color: white;">
                                            <th>Title</th>
                                            <th>Jira</th>
                                            <th>Category</th>
                                            <th>Updated</th>
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
                    <h4 class="modal-title">New Request CR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_cr_modal_body">
                    <div class="add_response_msg_area"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInput">CR Title</label>
                                <textarea name="cr_title" class="form-control cr_title"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">jira ID</label>
                                <input name="jira_code" type="text" class="form-control jira_code" placeholder="jira ID">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">jira Created</label>
                                <input name="jira_created" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control jira_created my_datepicker" placeholder="jira creating date">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">CR Category</label>
                                <select class="form-control category" name="category">
                                    <option value="">Select One</option>
                                    <option value="Loan">Loan</option>
                                    <option value="Insurance">Insurance</option>
                                    <option value="Savings">Savings</option>
                                    <option value="EA_B2B">Integration</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInput">CR Details</label>
                                <textarea name="cr_details" class="form-control cr_details"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Initiate by the Requester Team</label>
                                <input name="initial_requirement_shared_from_mf" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control initial_requirement_shared_from_mf my_datepicker" placeholder="Initial requirement shared by MF">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Requester Team</label>
                                <select class="form-control team_name" name="team_name">
                                    <option value="">Select One</option>
                                    <option value="Product Team">Product Team</option>
                                    <option value="Insurance Team">Insurance Team</option>
                                    <option value="Digital Cluster Team">Digital Cluster Team</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Expected Timeline</label>
                                <input name="mf_expect_timeline" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control mf_expect_timeline my_datepicker" placeholder="MF expect timeline">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Final CR Document (Allowed PDF only)</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input cr_doc" name="cr_doc " accept="application/pdf" id="cr_doc">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary store_new_cr"> <span class="spinner-icon"></span> Save </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.Edit CR Modal -->
    <div class="modal fade" id="edit-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit CR</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="edit_response_msg_area"></div>
                    <div class="edit_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn" style="background-color: #EC008C;color: white;" data-dismiss="modal">Close</button>
                    <button type="button" class="btn update_cr" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Update </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.CR Import Modal -->
    <div class="modal fade" id="cr-import-modal-lg">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">CR Import</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="import_response_msg_area"></div>
                    <div class="import_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn import_cr" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Import </button>
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

            $('input[type="file"]').change(function(e){
                var fileName = e.target.files[0].name;
                $('.custom-file-label').html(fileName);
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

            function getMfRequestCrList() {


                $('#mf_req_cr_list').DataTable({
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
                        url: '{{url("/request/get-mf-request-cr-list")}}',
                        method: 'post',
                    },
                    columns: [
                        {data: 'cr_title', name: 'cr_title', searchable: true ,orderable: false},
                        {data: 'jira_code', name: 'jira_code', searchable: true ,orderable: false},
                        {data: 'category', name: 'category', searchable: true ,orderable: false},
                        {data: 'updated_at', name: 'updated_at', searchable: true ,orderable: false},
                        {data: 'downloads', name: 'downloads', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getMfRequestCrList();


            $(document).on('click', '.store_new_cr', function () {
                $('.add_response_msg_area').empty();
                var cr_title = $('.cr_title').val();
                var jira_code = $('.jira_code').val();
                var category = $('.category').val();
                var cr_details = $('.cr_details').val();
                var initial_requirement_shared_from_mf = $('.initial_requirement_shared_from_mf').val();
                var team_name = $('.team_name').val();
                var mf_expect_timeline = $('.mf_expect_timeline').val();
                var jira_created = $('.jira_created').val();
                var has_input_error = false;

                $('.add_response_msg_area').html('');
                $('.cr_title').removeClass('input_error_mark');
                $('.category').removeClass('input_error_mark');
                $('.vendor_name').removeClass('input_error_mark');
                $('.cr_details').removeClass('input_error_mark');
                $('.team_name').removeClass('input_error_mark');

                if (cr_title == '') {
                    $('.cr_title').addClass('input_error_mark');
                    has_input_error = true;
                }

                if (has_input_error){
                    $('.add_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    $('#add-modal-lg').animate({ scrollTop: 0 }, 'slow');
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
                formData.append('category', category);
                formData.append('cr_details', cr_details);
                formData.append('initial_requirement_shared_from_mf', initial_requirement_shared_from_mf);
                formData.append('team_name', team_name);
                formData.append('mf_expect_timeline', mf_expect_timeline);

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/request/add-new-cr-request') }}',
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

                            $('.cr_title').val("");
                            $('.jira_code').val("");
                            $('.category').val("");
                            $('.cr_details').val("");
                            $('.initial_requirement_shared_from_mf').val("");
                            $('.team_name').val("");
                            $('.mf_expect_timeline').val("");
                            $('.cr_doc').val("");
                            $('.custom-file-label').html('Select file');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            $('#mf_req_cr_list').dataTable().fnClearTable();
                            $('#mf_req_cr_list').dataTable().fnDestroy();
                            getMfRequestCrList();

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

            $(document).on('click', '.open_req_cr_edit_modal', function () {

                var cr_id = jQuery(this).data('cr_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/request/get-mf-req-cr-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        cr_id: cr_id
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

            $(document).on('click', '.update_cr', function () {
                $('.edit_response_msg_area').empty();
                var edit_cr_title = $('.edit_cr_title').val();
                var edit_jira_code = $('.edit_jira_code').val();
                var edit_category = $('.edit_category').val();
                var edit_cr_details = $('.edit_cr_details').val();
                var edit_initial_requirement_shared_from_mf = $('.edit_initial_requirement_shared_from_mf').val();
                var edit_team_name = $('.edit_team_name').val();
                var edit_mf_expect_timeline = $('.edit_mf_expect_timeline').val();
                var update_cr_id = $('.update_cr_id').val();
                var jira_created = $('.edit_jira_created').val();
                var edit_has_input_error = false;

                $('.edit_cr_title').removeClass('input_error_mark');
                $('.edit_category').removeClass('input_error_mark');
                $('.edit_vendor_name').removeClass('input_error_mark');
                $('.edit_cr_details').removeClass('input_error_mark');
                $('.edit_team_name').removeClass('input_error_mark');

                if (edit_cr_title == '') {
                    $('.edit_cr_title').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_category == '') {
                    $('.edit_category').addClass('input_error_mark');
                    edit_has_input_error = true;
                }

                if (edit_cr_details == '') {
                    $('.edit_cr_details').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_team_name == '') {
                    $('.edit_team_name').addClass('input_error_mark');
                    edit_has_input_error = true;
                }

                if (edit_has_input_error){
                    $('.edit_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    $('#edit-modal-lg').animate({ scrollTop: 0 }, 'slow');
                    return false;
                }

                let formData = new FormData();
                var file_for_cr_doc = document.getElementById("edit_cr_doc");
                if( file_for_cr_doc.files.length != 0 ){
                    formData.append('cr_doc', $('.edit_cr_doc')[0].files[0]);
                }

                formData.append('cr_id', update_cr_id);
                formData.append('cr_title', edit_cr_title);
                formData.append('jira_code', edit_jira_code);
                formData.append('jira_created', jira_created);
                formData.append('category', edit_category);
                formData.append('cr_details', edit_cr_details);
                formData.append('initial_requirement_shared_from_mf', edit_initial_requirement_shared_from_mf);
                formData.append('team_name', edit_team_name);
                formData.append('mf_expect_timeline', edit_mf_expect_timeline);

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/request/update-req-mf-cr-info') }}',
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

                            $('#mf_req_cr_list').dataTable().fnClearTable();
                            $('#mf_req_cr_list').dataTable().fnDestroy();
                            getMfRequestCrList();

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


            $(document).on('click', '.open_req_cr_import_modal', function () {

                var cr_id = jQuery(this).data('cr_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/request/get-mf-req-cr-importable-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        cr_id: cr_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.import_data_content').html(response.html);
                            $('#cr-import-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.import_cr', function () {
                $('.import_response_msg_area').empty();
                var cr_title = $('.import_cr_title').val();
                var jira_code = $('.import_jira_code').val();
                var approved_billable_effort = $('.import_approved_billable_effort').val();
                var category = $('.import_category').val();
                var vendor_name = $('.import_vendor_name').val();
                var vendor_proposed_timeline = $('.import_vendor_proposed_timeline').val();
                var priority = $('.import_priority').val();
                var cr_status = $('.import_cr_status').val();
                var business_analyst = $('.import_business_analyst').val();
                var uat_instance = $('.import_uat_instance').val();
                var cr_details = $('.import_cr_details').val();
                var initial_requirement_shared_from_mf = $('.import_initial_requirement_shared_from_mf').val();
                var team_name = $('.import_team_name').val();
                var cr_locked_by_vendor = $('.import_cr_locked_by_vendor').val();
                var mf_expect_timeline = $('.import_mf_expect_timeline').val();
                var requester_team = $('.import_requester_team').val();
                var cr_type = $('.import_cr_type').val();
                var completed_on = $('.import_completed_on').val();
                var assigned_from_brac = $('.import_assigned_from_brac').val();
                var uat_credential = $('.import_uat_credential').val();
                var satisfactory_level = $('.import_satisfactory_level').val();
                var jira_created = $('.import_jira_created').val();
                var req_cr_id = $('.req_cr_id_for_import').val();
                var has_input_error = false;

                $('.import_response_msg_area').html('');
                $('.import_cr_title').removeClass('input_error_mark');
                $('.import_category').removeClass('input_error_mark');
                $('.import_vendor_name').removeClass('input_error_mark');
                $('.import_cr_details').removeClass('input_error_mark');
                $('.import_team_name').removeClass('input_error_mark');
                $('.import_requester_team').removeClass('input_error_mark');
                $('.import_cr_type').removeClass('input_error_mark');
                $('.import_assigned_from_brac').removeClass('input_error_mark');

                if (cr_title == '') {
                    $('.import_cr_title').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (category == '') {
                    $('.import_category').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (vendor_name == '') {
                    $('.import_vendor_name').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_status == '') {
                    $('.import_cr_status').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_details == '') {
                    $('.import_cr_details').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (team_name == '') {
                    $('.import_team_name').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (requester_team == '') {
                    $('.import_requester_team').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (cr_type == '') {
                    $('.import_cr_type').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (assigned_from_brac == '') {
                    $('.import_assigned_from_brac').addClass('input_error_mark');
                    has_input_error = true;
                }
                if (has_input_error){
                    $('.import_response_msg_area').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    $('#cr-import-modal-lg').animate({ scrollTop: 0 }, 'slow');
                    return false;
                }

                let formData = new FormData();
                var file_for_cr_doc = document.getElementById("cr_doc");
                if( file_for_cr_doc.files.length != 0 ){
                    formData.append('cr_doc', $('.cr_doc')[0].files[0]);
                }
                formData.append('req_cr_id', req_cr_id);
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

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/request/import-request-cr') }}',
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
                        $('#cr-import-modal-lg').animate({ scrollTop: 0 }, 'slow');

                        if (response.responseCode == 1) {
                            $('.import_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.import_cr_title').val("");
                            $('.import_jira_code').val("");
                            $('.import_approved_billable_effort').val("");
                            $('.import_category').val("");
                            $('.import_vendor_name').val("");
                            $('.import_vendor_proposed_timeline').val("");
                            $('.import_cr_status').val("");
                            $('.import_business_analyst').val("");
                            $('.import_uat_instance').val("");
                            $('.import_cr_details').val("");
                            $('.import_initial_requirement_shared_from_mf').val("");
                            $('.import_team_name').val("");
                            $('.import_cr_locked_by_vendor').val("");
                            $('.import_mf_expect_timeline').val("");
                            $('.import_requester_team').val("");
                            $('.import_cr_type').val("");
                            $('.import_cr_doc').val("");
                            $('.import_completed_on').val("");
                            $('.import_assigned_from_brac').val("");
                            $('.import_uat_credential').val("");
                            $('.import_satisfactory_level').val("");

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#cr-import-modal-lg').modal('hide');
                            }, 3200);

                            $('#mf_req_cr_list').dataTable().fnClearTable();
                            $('#mf_req_cr_list').dataTable().fnDestroy();
                            getMfRequestCrList();

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




        });

    </script>


@endsection
