
@extends('layouts.admin_layout')

@section('styles')
    @include('layouts.admin_common_css')
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/dataTables.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/datatable/responsive.bootstrap.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/plugins/select2/css/select2.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("admin_src/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css") }}" />

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
        .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
            color: black;
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
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">User list</li>
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
                                        @if(App\Libraries\aclHandler::hasActionAccess('user_write') == true)
                                            <button type="button" class="btn btn-info" style="background-color: #009A93;color: white;"  data-toggle="modal" data-target="#add-modal-lg">
                                                Add New User
                                            </button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-sm table-responsive">
                                    <table id="user_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr style="background-color: #009A93;color: white;">
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Updated</th>
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
                    <h4 class="modal-title">New User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="add_response_msg_area"></div>
                    <div class="form-group">
                        <label for="exampleInput">Name</label>
                        <input name="user_name" type="text" class="form-control user_name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInput">Email</label>
                        <input name="user_email" type="text" class="form-control user_email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Account Type</label>
                        <select name="user_type" class="form-control user_type">
                            <option value="">Please select</option>
                            <option value="Admin">Admin</option>
                            <option value="Management">Management</option>
                            <option value="General">General</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Assign permission</label>
                        <select class="select2 user_permission" name="user_permission" multiple="multiple" data-placeholder="Select permission" style="width: 100%;">
                            <option value="calculators">calculators</option>
                            <option value="user_read">user_read</option>
                            <option value="user_write">user_write</option>
                            <option value="mf_cr_read">mf_cr_read</option>
                            <option value="mf_cr_write">mf_cr_write</option>
                            <option value="circular_read">circular_read</option>
                            <option value="circular_write">circular_write</option>
                            <option value="req_cr_read">req_cr_read</option>
                            <option value="req_cr_write">req_cr_write</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInput">Phone</label>
                        <input name="user_phone" type="text" class="form-control user_phone" placeholder="Enter Phone">
                    </div>
                    <div class="form-group">
                        <label for="exampleInput">Country</label>
                        <input name="user_country" type="text" class="form-control user_country" placeholder="Enter Country Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInput">Designation</label>
                        <input name="user_designation" type="text" class="form-control user_designation" placeholder="Enter Designation">
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn" style="background-color: #009A93;color: white;" data-dismiss="modal">Close</button>
                    <button type="button" class="btn store_new_user" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Save </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.Edit User Modal -->
    <div class="modal fade" id="edit-modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit User</h4>
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
                    <button type="button" class="btn update_user" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Update </button>
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
    <script src="{{ asset("admin_src/plugins/select2/js/select2.full.min.js") }}"></script>

    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>


    <script language="javascript">

        $(document).ready(function() {
            $('.select2').select2();

            function getUserList() {
                $('#user_list').DataTable({
                    iDisplayLength: 25,
                    processing: true,
                    serverSide: true,
                    lengthChange: false,
                    searching: true,
                    ajax: {
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{url("/admin/get-user-list")}}',
                        method: 'post'
                    },
                    columns: [
                        {data: 'name', name: 'name', searchable: true ,orderable: false},
                        {data: 'email', name: 'email', searchable: true ,orderable: false},
                        {data: 'type', name: 'role', searchable: true ,orderable: false},
                        {data: 'status', name: 'status', searchable: true ,orderable: false},
                        {data: 'updated_at', name: 'updated', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getUserList();

            $(document).on('click', '.store_new_user', function () {
                $('.add_response_msg_area').empty();
                var user_name = $('.user_name').val();
                var user_email = $('.user_email').val();
                var user_type = $('.user_type').val();
                var user_phone = $('.user_phone').val();
                var user_country = $('.user_country').val();
                var user_designation = $('.user_designation').val();
                var user_permission = $('.user_permission').select2("val");

                if (user_name == '') {
                    alert("please enter name");
                    return false;
                }
                if (user_email == '') {
                    alert("please enter valid email");
                    return false;
                }
                if (user_type == '') {
                    alert("please select account type");
                    return false;
                }
                if (user_phone == '') {
                    alert("please enter phone number");
                    return false;
                }
                if (user_country == '') {
                    alert("please enter country name");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/admin/add-new-user') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        user_name: user_name,
                        email: user_email,
                        user_type: user_type,
                        user_phone: user_phone,
                        user_country: user_country,
                        user_permission: user_permission,
                        user_designation: user_designation
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.add_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');
                            $('#add-modal-lg').animate({ scrollTop: 0 }, 'slow');

                            $('.user_name').val('');
                            $('.user_email').val('');
                            $('.user_type').val('');
                            $('.user_phone').val('');
                            $('.user_country').val('');
                            $('.user_designation').val('');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            $('#user_list').dataTable().fnClearTable();
                            $('#user_list').dataTable().fnDestroy();
                            getUserList();

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


            $(document).on('click', '.open_user_modal', function () {

                var user_id = jQuery(this).data('user_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/admin/get-user-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        user_id: user_id
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


            $(document).on('click', '.update_user', function () {
                $('.edit_response_msg_area').empty();
                var update_user_id = $('.update_user_id').val();
                var user_name = $('.user_name_update').val();
                var user_type = $('.user_type_update').val();
                var user_phone = $('.user_phone_update').val();
                var user_country = $('.user_country_update').val();
                var user_designation = $('.user_designation_update').val();
                var user_permission = $('.user_permission_update').select2("val");

                if (user_name == '') {
                    alert("please enter name");
                    return false;
                }
                if (user_type == '') {
                    alert("please select account type");
                    return false;
                }
                if (user_phone == '') {
                    alert("please enter phone number");
                    return false;
                }
                if (user_country == '') {
                    alert("please enter country name");
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/admin/update-user-info') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        user_id: update_user_id,
                        user_name: user_name,
                        user_type: user_type,
                        user_phone: user_phone,
                        user_country: user_country,
                        user_permission: user_permission,
                        user_designation: user_designation
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.edit_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');
                            $('#edit-modal-lg').animate({ scrollTop: 0 }, 'slow');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#edit-modal-lg').modal('hide');
                            }, 3200);

                            $('#user_list').dataTable().fnClearTable();
                            $('#user_list').dataTable().fnDestroy();
                            getUserList();

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


            $(document).on('click', '.deleteUser', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var user_id = jQuery(this).data('user_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/admin/delete-user') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        user_id: user_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.delete_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            setTimeout(function () {
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            $('#user_list').dataTable().fnClearTable();
                            $('#user_list').dataTable().fnDestroy();
                            getUserList();
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
