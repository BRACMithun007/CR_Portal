
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
                        <h1>Item list (MF)</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Admin</a></li>
                            <li class="breadcrumb-item active">Item</li>
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
                                    <div class="col-md-1">
                                        @if(App\Libraries\aclHandler::hasActionAccess('mf_cr_write') == true)
                                            <button type="button" class="btn" style="background-color: #009A93;color: white;"  data-toggle="modal" data-target="#add-modal-lg">
                                                <b>+</b> Item
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group clearfix" style="margin-top: 2px;">
                                            <div class="icheck-success d-inline" style="margin-right: 20px;margin-left: 10px;">
                                                <input type="checkbox" class="checkBoxValAll" name="checkBoxVal" value="all" id="checkboxSuccess10">
                                                <label for="checkboxSuccess10"> All &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="business" id="checkboxSuccess1">
                                                <label for="checkboxSuccess1"> Business &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="support" id="checkboxSuccess8">
                                                <label for="checkboxSuccess8"> Support &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="configurable" id="checkboxSuccess2">
                                                <label for="checkboxSuccess2"> Configurable &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="integration" id="checkboxSuccess9">
                                                <label for="checkboxSuccess9"> Integration &nbsp;</label>
                                            </div>
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="ongoing" checked="true" id="checkboxSuccess6">
                                                <label for="checkboxSuccess6"> Ongoing &nbsp;</label>
                                            </div>
{{--                                            <div class="icheck-success d-inline">--}}
{{--                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="PendingDeployment" id="checkboxSuccess10">--}}
{{--                                                <label for="checkboxSuccess10"> Pending Deployment &nbsp;</label>--}}
{{--                                            </div>--}}
                                            <div class="icheck-success d-inline">
                                                <input type="checkbox" class="checkBoxVal" name="checkBoxVal" value="deployed" id="checkboxSuccess7">
                                                <label for="checkboxSuccess7"> Deployed &nbsp;</label>
                                            </div>


                                            <div class="input-group deployDivSection" style="display: none;">
                                                <b>From: </b><input name="deploy_start" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control-sm deploy_start my_datepicker" placeholder="Deploy start date">
                                                <b>To: </b><input name="deploy_end" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control-sm deploy_end my_datepicker" placeholder="Deploy end date">
                                                <button class="btn btn-info btn-sm searchByDeployDate">Search</button>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary float-right excel_export" style="background-color: #009A93;">
                                            <i class="fas fa-download"></i> Export
                                        </button>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body table_area">

                                <div class="delete_response_msg_area"></div>
                                <div class="table-sm table-responsive">
                                    <table id="mf_cr_list"
                                           class="table table-striped table-bordered dt-responsive " cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr style="background: #009A93;color: white;">
                                            <th>Title</th>
                                            <th>Jira</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Timeline</th>
                                            {{--                                            <th>Focal</th>--}}
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
                    <h4 class="modal-title">New Item</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body add_cr_modal_body">
                    <div class="add_response_msg_area"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInput">Item Title</label>
                                <textarea name="cr_title" class="form-control cr_title"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">jira ID</label>
                                <input name="jira_code" type="text" class="form-control jira_code" placeholder="jira ID">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">jira created</label>
                                <input name="jira_created" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control jira_created my_datepicker" placeholder="jira creating date">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Approved billable effort</label>
                                <input name="approved_billable_effort" type="text" class="form-control approved_billable_effort" placeholder="Approved billable effort">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Item category</label>
                                <select class="form-control category" name="category">
                                    <option value="">Select One</option>
                                    <option value="Insurance">Insurance</option>
                                    <option value="Loan">Loan</option>
                                    <option value="Savings">Savings</option>
                                    <option value="EA_B2B">EA_B2B</option>
                                    <option value="EA_B2C">EA_B2C</option>
                                    <option value="EA_Server">EA_Server</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Vendor Name</label>
                                <input name="vendor_name" type="text" class="form-control vendor_name" placeholder="Approved billable effort">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Vendor proposed timeline</label>
                                <input name="vendor_proposed_timeline" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control vendor_proposed_timeline my_datepicker" placeholder="Vendor proposed timeline">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Priority</label>
                                <select class="form-control priority" name="priority">
                                    <option value="99">N/A</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Item Status</label>
                                <select class="form-control cr_status" name="cr_status">
                                    <option value="">Select One</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="PendingDeployment">Pending Deployment</option>
                                    <option value="Deployed">Deployed in live</option>
                                    <option value="TBD">To Be Decide</option>
                                    <option value="Halt">ON Halt</option>
                                    <option value="Backlog">Backlog</option>
                                    <option value="Abandoned">Abandoned</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Business analyst</label>
                                <input name="business_analyst" type="text" class="form-control business_analyst" placeholder="Business analyst">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">UAT instance</label>
                                <input name="uat_instance" type="text" class="form-control uat_instance" placeholder="UAT instance">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInput">Item Details</label>
                                <textarea name="cr_details" class="form-control cr_details"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Initial requirement shared by MF</label>
                                <input name="initial_requirement_shared_from_mf" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control initial_requirement_shared_from_mf my_datepicker" placeholder="Initial requirement shared by MF">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Team Name</label>
                                <select class="form-control team_name" name="team_name">
                                    <option value="">Select One</option>
                                    <option value="FAP">FAP</option>
                                    <option value="FAO">FAO</option>
                                    <option value="EA">EA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Item locked by vendor</label>
                                <input name="cr_locked_by_vendor" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control cr_locked_by_vendor my_datepicker" placeholder="CR locked by vendor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">MF expect timeline</label>
                                <input name="mf_expect_timeline" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control mf_expect_timeline my_datepicker" placeholder="MF expect timeline">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Requester team</label>
                                <input name="requester_team" type="text" class="form-control requester_team" placeholder="Requester team">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Item Type</label>
                                <select class="form-control cr_type" name="cr_type">
                                    <option value="">Select One</option>
{{--                                    <option value="CR">CR</option>--}}
                                    <option value="Core_Business">Core Business</option>
                                    <option value="Support_CR">Support CR</option>
                                    <option value="Configurable">Configurable Item</option>
                                    <option value="Integration">Integration</option>
                                    <option value="Data_Correction">Data Correction</option>
{{--                                    <option value="CR_Addition">CR (Addition)</option>--}}
{{--                                    <option value="CR_One_Time">CR (One Time)</option>--}}
{{--                                    <option value="CR_Change">CR (Change)</option>--}}
{{--                                    <option value="Non_CR">Non CR</option>--}}

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Completed on</label>
                                <input name="completed_on" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control completed_on my_datepicker" placeholder="Completed on">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Assigned from BRAC tech</label>
                                <select class="form-control assigned_from_brac" name="assigned_from_brac">
                                    <option value="">Select one</option>
                                    <option value="Rakebul">Rakebul</option>
                                    <option value="Shafiqul">Shafiqul</option>
                                    <option value="Lamia">Lamia</option>
                                    <option value="Tanvir">Tanvir</option>
                                    <option value="Pramit">Pramit</option>
                                    <option value="Mithun">Mithun</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">UAT credential</label>
                                <input name="uat_credential" type="text" class="form-control uat_credential" placeholder="UAT credential">
                            </div>
                            <div class="form-group">
                                <label for="exampleInput">Satisfactory level</label>
                                <select class="form-control satisfactory_level" name="satisfactory_level">
                                    <option value="">Select one</option>
                                    <option value="Good">Good</option>
                                    <option value="Average">Average</option>
                                    <option value="Substandard">Substandard</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="exampleInputFile">Final CR/Item Document (Allowed PDF only)</label>
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
                    <h4 class="modal-title">Edit Item</h4>
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
                    <button type="button" class="btn update_cr" style="background-color: #009A93;color: white;"> <span class="spinner-icon"></span> Update </button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- /.CR Note Modal -->
    <div class="modal fade" id="cr-note-modal-lg">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">CR Notes</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="notes_response_msg_area"></div>
                    <div class="notes_data_content"></div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

            function getMFCrList() {

                var business = false;
                var support = false;
                var ongoing = false;
                var deployed = false;
                var configurable = false;
                var integration = false;
                var deploy_start = '';
                var deploy_end = '';

                $("input:checkbox[name=checkBoxVal]:checked").each(function(){
                    if ($(this).val() == 'business'){
                        business = true;
                    }else if($(this).val() == 'support'){
                        support = true;
                    }else if($(this).val() == 'ongoing'){
                        ongoing = true;
                        $('.deploy_start').val('');
                        $('.deploy_end').val('');
                    }else if($(this).val() == 'deployed'){
                        $('.deployDivSection').css('display','block')
                        deployed = true;
                        deploy_start = $('.deploy_start').val();
                        deploy_end = $('.deploy_end').val();
                    }else if($(this).val() == 'configurable'){
                        configurable = true;
                    }else if($(this).val() == 'integration'){
                        integration = true;
                    }
                });

                $("input:checkbox:not(:checked)").each(function(){
                    if ($(this).val() == 'deployed'){
                        $('.deploy_start').val('');
                        $('.deploy_end').val('');
                        $('.deployDivSection').css('display','none')
                    }
                });

                // $('.table_area').fadeOut(2);
                // $('.table_area').fadeIn(3200);

                $('#mf_cr_list').DataTable({
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
                        url: '{{url("/item/get-mf-item-list")}}',
                        method: 'post',
                        data: function (d) {
                            d.business = business;
                            d.support = support;
                            d.ongoing = ongoing;
                            d.deployed = deployed;
                            d.configurable = configurable;
                            d.integration = integration;
                            d.deploy_start = deploy_start;
                            d.deploy_end = deploy_end;
                            // d._token = $('input[name="_token"]').val();
                        }
                    },
                    columns: [
                        {data: 'cr_title', name: 'cr_title', searchable: true ,orderable: false},
                        {data: 'jira_code', name: 'jira_code', searchable: true ,orderable: false},
                        {data: 'category', name: 'category', searchable: true ,orderable: false},
                        {data: 'cr_status', name: 'cr_status', searchable: true ,orderable: false},
                        {data: 'priority', name: 'priority', searchable: true ,orderable: false},
                        {data: 'vendor_proposed_timeline', name: 'vendor_proposed_timeline', searchable: true ,orderable: false},
                        // {data: 'assigned_from_brac', name: 'assigned_from_brac', searchable: true ,orderable: false},
                        {data: 'updated_at', name: 'updated_at', searchable: true ,orderable: false},
                        {data: 'downloads', name: 'downloads', searchable: true ,orderable: false},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ],
                    "aaSorting": []
                });
            }

            getMFCrList();

            $(document).on('click', '.store_new_cr', function () {
                $('.add_response_msg_area').empty();
                var cr_title = $('.cr_title').val();
                var jira_code = $('.jira_code').val();
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
                var mf_expect_timeline = $('.mf_expect_timeline').val();
                var requester_team = $('.requester_team').val();
                var cr_type = $('.cr_type').val();
                var completed_on = $('.completed_on').val();
                var assigned_from_brac = $('.assigned_from_brac').val();
                var uat_credential = $('.uat_credential').val();
                var satisfactory_level = $('.satisfactory_level').val();
                var jira_created = $('.jira_created').val();
                var has_input_error = false;

                $('.add_response_msg_area').html('');
                $('.cr_title').removeClass('input_error_mark');
                $('.category').removeClass('input_error_mark');
                $('.vendor_name').removeClass('input_error_mark');
                $('.cr_details').removeClass('input_error_mark');
                $('.team_name').removeClass('input_error_mark');
                $('.requester_team').removeClass('input_error_mark');
                $('.cr_type').removeClass('input_error_mark');
                $('.assigned_from_brac').removeClass('input_error_mark');

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
                    $('.requester_team').addClass('input_error_mark');
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
                    url: '{{ url('/item/add-new-item') }}',
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
                                $('#add-modal-lg').modal('hide');
                            }, 3200);

                            $('#mf_cr_list').dataTable().fnClearTable();
                            $('#mf_cr_list').dataTable().fnDestroy();
                            getMFCrList();

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

            $(document).on('click', '.open_cr_edit_modal', function () {

                var cr_id = jQuery(this).data('cr_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-mf-item-info') }}",
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
                var edit_approved_billable_effort = $('.edit_approved_billable_effort').val();
                var edit_category = $('.edit_category').val();
                var edit_vendor_name = $('.edit_vendor_name').val();
                var edit_vendor_proposed_timeline = $('.edit_vendor_proposed_timeline').val();
                var edit_priority = $('.edit_priority').val();
                var edit_cr_status = $('.edit_cr_status').val();
                var edit_business_analyst = $('.edit_business_analyst').val();
                var edit_uat_instance = $('.edit_uat_instance').val();
                var edit_cr_details = $('.edit_cr_details').val();
                var edit_initial_requirement_shared_from_mf = $('.edit_initial_requirement_shared_from_mf').val();
                var edit_team_name = $('.edit_team_name').val();
                var edit_cr_locked_by_vendor = $('.edit_cr_locked_by_vendor').val();
                var edit_mf_expect_timeline = $('.edit_mf_expect_timeline').val();
                var edit_requester_team = $('.edit_requester_team').val();
                var edit_cr_type = $('.edit_cr_type').val();
                var edit_completed_on = $('.edit_completed_on').val();
                var edit_assigned_from_brac = $('.edit_assigned_from_brac').val();
                var edit_uat_credential = $('.edit_uat_credential').val();
                var edit_satisfactory_level = $('.edit_satisfactory_level').val();
                var update_cr_id = $('.update_cr_id').val();
                var jira_created = $('.edit_jira_created').val();
                var edit_has_input_error = false;

                $('.edit_cr_title').removeClass('input_error_mark');
                $('.edit_category').removeClass('input_error_mark');
                $('.edit_vendor_name').removeClass('input_error_mark');
                $('.edit_cr_details').removeClass('input_error_mark');
                $('.edit_team_name').removeClass('input_error_mark');
                $('.edit_requester_team').removeClass('input_error_mark');
                $('.edit_cr_type').removeClass('input_error_mark');
                $('.edit_assigned_from_brac').removeClass('input_error_mark');

                if (edit_cr_title == '') {
                    $('.edit_cr_title').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_category == '') {
                    $('.edit_category').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_vendor_name == '') {
                    $('.edit_vendor_name').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_cr_status == '') {
                    $('.edit_cr_status').addClass('input_error_mark');
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
                if (edit_requester_team == '') {
                    $('.edit_requester_team').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_cr_type == '') {
                    $('.edit_cr_type').addClass('input_error_mark');
                    edit_has_input_error = true;
                }
                if (edit_assigned_from_brac == '') {
                    $('.edit_assigned_from_brac').addClass('input_error_mark');
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
                formData.append('approved_billable_effort', edit_approved_billable_effort);
                formData.append('category', edit_category);
                formData.append('vendor_name', edit_vendor_name);
                formData.append('vendor_proposed_timeline', edit_vendor_proposed_timeline);
                formData.append('priority', edit_priority);
                formData.append('cr_status', edit_cr_status);
                formData.append('business_analyst', edit_business_analyst);
                formData.append('uat_instance', edit_uat_instance);
                formData.append('cr_details', edit_cr_details);
                formData.append('initial_requirement_shared_from_mf', edit_initial_requirement_shared_from_mf);
                formData.append('team_name', edit_team_name);
                formData.append('cr_locked_by_vendor', edit_cr_locked_by_vendor);
                formData.append('mf_expect_timeline', edit_mf_expect_timeline);
                formData.append('requester_team', edit_requester_team);
                formData.append('cr_type', edit_cr_type);
                formData.append('completed_on', edit_completed_on);
                formData.append('assigned_from_brac', edit_assigned_from_brac);
                formData.append('uat_credential', edit_uat_credential);
                formData.append('satisfactory_level', edit_satisfactory_level);

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/update-mf-item-info') }}',
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

                            $('#mf_cr_list').dataTable().fnClearTable();
                            $('#mf_cr_list').dataTable().fnDestroy();
                            getMFCrList();

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

            $(document).on('click', '.delete_cr', function () {

                var result = confirm("Want to delete?");
                if (!result) {
                    return false;
                }

                var cr_id = jQuery(this).data('cr_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/delete-mf-item') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        cr_id: cr_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.delete_response_msg_area').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            $('#mf_cr_list').dataTable().fnClearTable();
                            $('#mf_cr_list').dataTable().fnDestroy();
                            getMFCrList();
                        }else{
                            $('.delete_response_msg_area').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    }
                });

            });

            $(document).on('click', '.open_cr_note_modal', function () {

                var cr_id = jQuery(this).data('cr_id');

                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-mf-item-note-info') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        cr_id: cr_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.notes_data_content').html(response.html);
                            $('#cr-note-modal-lg').modal();
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.add_new_note_btn', function () {
                var cr_master_id = $('.cr_master_id').val();
                $('.notes_data_show_area').html('');
                $('.note_list_btn').css({'background-color':'white','color':'black'});
                $('.comment_list_btn').css({'background-color':'white','color':'black'});
                $('.loading_brac_img').css({'display':'block'});
                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-add-note-template') }}",
                    data: {
                        cr_master_id: cr_master_id,
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        $('.loading_brac_img').css({'display':'none'});
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.notes_data_show_area').html(response.html);
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.add_note_btn', function () {
                $('.data_area_response_msg').empty();
                var note_type = $('.note_type').val();
                var note_date = $('.note_date').val();
                var cr_notes = $('.cr_notes').val();
                var cr_master_id = $('.cr_master_id').val();
                var add_cr_note_error = false;

                $('.note_type').removeClass('input_error_mark');
                $('.note_date').removeClass('input_error_mark');
                $('.cr_notes').removeClass('input_error_mark');

                if (note_type == '') {
                    $('.note_type').addClass('input_error_mark');
                    add_cr_note_error = true;
                }
                if (note_date == '') {
                    $('.note_date').addClass('input_error_mark');
                    add_cr_note_error = true;
                }
                if (cr_notes == '') {
                    $('.cr_notes').addClass('input_error_mark');
                    add_cr_note_error = true;
                }
                if (add_cr_note_error){
                    $('.data_area_response_msg').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/add-item-note') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        note_type: note_type,
                        note_date: note_date,
                        cr_notes: cr_notes,
                        cr_master_id: cr_master_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.data_area_response_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.note_list_section').html(response.noteList);
                            $('.cr_notes').val('');

                            $('.alert-success').fadeOut(3000);

                        } else {
                            $('.data_area_response_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $(document).on('click', '.note_list_btn', function () {

                $('.note_list_btn').css({'background-color':'white','color':'black'});
                $('.comment_list_btn').css({'background-color':'white','color':'black'});
                var note_id = jQuery(this).data('note_id');
                $('.loading_brac_img').css({'display':'block'});
                $('.data_area_response_msg').html('');
                $('.notes_data_show_area').html('');
                jQuery(this).css({'background-color':'#009A93','color':'white'});

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-item-note-details') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        note_id: note_id
                    },
                    success: function (response) {
                        $('.loading_brac_img').css({'display':'none'});
                        if(response.responseCode == 1){
                            $('.notes_data_show_area').html(response.html);
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.edit_enable_disable', function () {

                $('.update_note_btn_section').css({'display':'block'});
                $('.edit_enable_disable').css({'display':'none'});
                $('.edit_note_type').attr("readonly", false);
                $('.edit_note_date').attr("readonly", false);
                $('.edit_cr_notes').attr("readonly", false);

            });

            $(document).on('click', '.comment_enable_disable', function () {

                $('.update_comment_btn_section').css({'display':'block'});
                $('.comment_enable_disable').css({'display':'none'});
                $('.edit_comment_type').attr("readonly", false);
                $('.edit_comment_date').attr("readonly", false);
                $('.edit_cr_comment').attr("readonly", false);

            });

            $(document).on('click', '.update_note_btn', function () {
                $('.data_area_response_msg').empty();
                var note_id = $('.note_id').val();
                var edit_note_type = $('.edit_note_type').val();
                var edit_note_date = $('.edit_note_date').val();
                var edit_cr_notes = $('.edit_cr_notes').val();
                var cr_master_id = $('.cr_master_id').val();
                var edit_cr_note_error = false;

                $('.edit_note_type').removeClass('input_error_mark');
                $('.edit_note_date').removeClass('input_error_mark');
                $('.edit_cr_notes').removeClass('input_error_mark');

                if (edit_note_type == '') {
                    $('.edit_note_type').addClass('input_error_mark');
                    edit_cr_note_error = true;
                }
                if (edit_note_date == '') {
                    $('.edit_note_date').addClass('input_error_mark');
                    edit_cr_note_error = true;
                }
                if (edit_cr_notes == '') {
                    $('.edit_cr_notes').addClass('input_error_mark');
                    edit_cr_note_error = true;
                }
                if (edit_cr_note_error){
                    $('.data_area_response_msg').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/update-item-note') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        note_id: note_id,
                        note_type: edit_note_type,
                        note_date: edit_note_date,
                        cr_master_id: cr_master_id,
                        cr_notes: edit_cr_notes
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.data_area_response_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            $('.note_list_section').html(response.noteList);

                            $('.update_note_btn_section').css({'display':'none'});
                            $('.edit_enable_disable').css({'display':'block'});
                            $('.edit_note_type').attr("readonly", true);
                            $('.edit_note_date').attr("readonly", true);
                            $('.edit_cr_notes').attr("readonly", true);

                        } else {
                            $('.data_area_response_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $(document).on('click', '.update_comment_btn', function () {
                $('.data_area_response_msg').empty();
                var comment_id = $('.comment_id').val();
                var edit_comment_type = $('.edit_comment_type').val();
                var edit_comment_date = $('.edit_comment_date').val();
                var edit_cr_comment = $('.edit_cr_comment').val();
                var cr_master_id = $('.cr_master_id').val();
                var edit_cr_comment_error = false;

                $('.edit_comment_type').removeClass('input_error_mark');
                $('.edit_comment_date').removeClass('input_error_mark');
                $('.edit_cr_comment').removeClass('input_error_mark');

                if (edit_comment_type == '') {
                    $('.edit_comment_type').addClass('input_error_mark');
                    edit_cr_comment_error = true;
                }
                if (edit_comment_date == '') {
                    $('.edit_comment_date').addClass('input_error_mark');
                    edit_cr_comment_error = true;
                }
                if (edit_cr_comment == '') {
                    $('.edit_cr_comment').addClass('input_error_mark');
                    edit_cr_comment_error = true;
                }
                if (edit_cr_comment_error){
                    $('.data_area_response_msg').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/update-item-comment') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        comment_id: comment_id,
                        comment_type: edit_comment_type,
                        comment_date: edit_comment_date,
                        cr_master_id: cr_master_id,
                        cr_comment: edit_cr_comment
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.data_area_response_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.alert-success').fadeOut(3000);

                            $('.note_list_section').html(response.commentList);

                            $('.update_comment_btn_section').css({'display':'none'});
                            $('.comment_enable_disable').css({'display':'block'});
                            $('.edit_comment_type').attr("readonly", true);
                            $('.edit_comment_date').attr("readonly", true);
                            $('.edit_cr_comment').attr("readonly", true);

                        } else {
                            $('.data_area_response_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $(document).on('click', '.checkBoxValAll', function () {
                $("input:checkbox[name=checkBoxVal]:checked").each(function(){
                    if ($(this).val() == 'all'){
                        $('#checkboxSuccess1').prop('checked', true);
                        $('#checkboxSuccess2').prop('checked', true);
                        $('#checkboxSuccess6').prop('checked', true);
                        $('#checkboxSuccess7').prop('checked', true);
                        $('#checkboxSuccess8').prop('checked', true);
                        $('#checkboxSuccess9').prop('checked', true);
                        $('.deploy_start').val('');
                        $('.deploy_end').val('');
                        $('.deployDivSection').css('display','block');
                    }
                    return false;
                });

                $("input:checkbox:not(:checked)").each(function(){
                    if ($(this).val() == 'all'){
                        $('#checkboxSuccess1').prop('checked', false);
                        $('#checkboxSuccess2').prop('checked', false);
                        $('#checkboxSuccess6').prop('checked', false);
                        $('#checkboxSuccess7').prop('checked', false);
                        $('#checkboxSuccess8').prop('checked', false);
                        $('#checkboxSuccess9').prop('checked', false);
                        $('.deploy_start').val('');
                        $('.deploy_end').val('');
                        $('.deployDivSection').css('display','none')
                    }
                    return false;
                });

                $('#mf_cr_list').dataTable().fnClearTable();
                $('#mf_cr_list').dataTable().fnDestroy();
                getMFCrList();
            });

            $(document).on('click', '.checkBoxVal', function () {
                $('#mf_cr_list').dataTable().fnClearTable();
                $('#mf_cr_list').dataTable().fnDestroy();
                getMFCrList();
            });

            $(document).on('click', '.searchByDeployDate', function () {

                var deploy_start = $('.deploy_start').val();
                var deploy_end = $('.deploy_end').val();
                if(deploy_start == ''){alert('Start date is required');return false;}
                if(deploy_end == ''){alert('End date is required');return false;}
                if(deploy_start > deploy_end){alert('Start date must be smaller than end date');return false;}

                $('#checkboxSuccess6').prop('checked', false);
                $('#mf_cr_list').dataTable().fnClearTable();
                $('#mf_cr_list').dataTable().fnDestroy();
                getMFCrList();
            });

            $(document).on('click', '.excel_export', function () {

                var business = false;
                var support = false;
                var ongoing = false;
                var deployed = false;
                var configurable = false;
                var integration = false;
                var deploy_start = '';
                var deploy_end = '';

                $("input:checkbox[name=checkBoxVal]:checked").each(function(){
                    if ($(this).val() == 'business'){
                        business = true;
                    }else if($(this).val() == 'support'){
                        support = true;
                    }else if($(this).val() == 'ongoing'){
                        ongoing = true;
                    }else if($(this).val() == 'deployed'){
                        $('.deployDivSection').css('display','block')
                        deployed = true;
                        deploy_start = $('.deploy_start').val();
                        deploy_end = $('.deploy_end').val();
                    }else if($(this).val() == 'configurable'){
                        configurable = true;
                    }else if($(this).val() == 'integration'){
                        integration = true;
                    }
                });

                var btn = $(this);
                btn.prop('disabled', true);
                $('.export-spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                location.href = '{{ url('/item/export-item-report-in-excel')}}'+'?business='+business+'&support='+support+'&ongoing='+ongoing+'&deployed='+deployed+'&configurable='+configurable+'&integration='+integration+'&deploy_start='+deploy_start+'&deploy_end='+deploy_end;

                btn.prop('disabled', false);
                $('.export-spinner-icon').empty();
            });

            $(document).on('click', '.add_new_comment_btn', function () {
                var cr_master_id = $('.cr_master_id').val();
                $('.notes_data_show_area').html('');
                $('.note_list_btn').css({'background-color':'white','color':'black'});
                $('.comment_list_btn').css({'background-color':'white','color':'black'});
                $('.loading_brac_img').css({'display':'block'});
                var btn = $(this);
                btn.prop('disabled', true);

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-item-comment-template') }}",
                    data: {
                        cr_master_id: cr_master_id,
                        _token: $('input[name="_token"]').val()
                    },
                    success: function (response) {
                        $('.loading_brac_img').css({'display':'none'});
                        btn.prop('disabled', false);
                        if(response.responseCode == 1){
                            $('.notes_data_show_area').html(response.html);
                        }else{

                        }
                    }
                });

            });

            $(document).on('click', '.add_comment_btn', function () {
                $('.data_area_response_msg').empty();
                var comment_type = $('.comment_type').val();
                var comment_date = $('.comment_date').val();
                var cr_comment = $('.cr_comment').val();
                var cr_master_id = $('.cr_master_id').val();
                var add_cr_comment_error = false;

                $('.comment_type').removeClass('input_error_mark');
                $('.comment_date').removeClass('input_error_mark');
                $('.cr_comment').removeClass('input_error_mark');

                if (comment_type == '') {
                    $('.comment_type').addClass('input_error_mark');
                    add_cr_comment_error = true;
                }
                if (comment_date == '') {
                    $('.comment_date').addClass('input_error_mark');
                    add_cr_comment_error = true;
                }
                if (cr_comment == '') {
                    $('.cr_comment').addClass('input_error_mark');
                    add_cr_comment_error = true;
                }
                if (add_cr_comment_error){
                    $('.data_area_response_msg').html('<div class="alert alert-danger"><strong>Please fill up required fields</strong></div>');
                    return false;
                }

                var btn = $(this);
                btn.prop('disabled', true);
                $('.spinner-icon').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');

                $.ajax({
                    url: '{{ url('/item/item-new-comment-store') }}',
                    type: "POST",
                    //dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        comment_type: comment_type,
                        comment_date: comment_date,
                        cr_comment: cr_comment,
                        cr_master_id: cr_master_id
                    },
                    success: function (response) {
                        btn.prop('disabled', false);
                        $('.spinner-icon').empty();

                        if (response.responseCode == 1) {
                            $('.data_area_response_msg').html('<div class="alert alert-success">\n' +
                                '                                <strong>Success!</strong> ' + response.message + '\n' +
                                '                            </div>');

                            $('.management_comments_section').html(response.commentList);
                            $('.cr_comment').val('');

                            $('.alert-success').fadeOut(3000);

                        } else {
                            $('.data_area_response_msg').html('<div class="alert alert-danger">\n' +
                                '                                <strong>Error!</strong> ' + response.message + '\n' +
                                '                            </div>');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {

                    }
                });
            });

            $(document).on('click', '.comment_list_btn', function () {

                $('.note_list_btn').css({'background-color':'white','color':'black'});
                $('.comment_list_btn').css({'background-color':'white','color':'black'});
                var comment_id = jQuery(this).data('comment_id');
                $('.loading_brac_img').css({'display':'block'});
                $('.data_area_response_msg').html('');
                $('.notes_data_show_area').html('');
                jQuery(this).css({'background-color':'#009A93','color':'white'});

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ url('/item/get-item-detail-comment') }}",
                    data: {
                        _token: $('input[name="_token"]').val(),
                        comment_id: comment_id
                    },
                    success: function (response) {
                        $('.loading_brac_img').css({'display':'none'});
                        if(response.responseCode == 1){
                            $('.notes_data_show_area').html(response.html);
                        }else{

                        }
                    }
                });

            });

        });

        // $('.datepicker').datetimepicker({
        //     format: 'DD/MM/YYYY HH:mm',
        //     useCurrent: false,
        //     showTodayButton: true,
        //     showClear: true,
        //     toolbarPlacement: 'bottom',
        //     sideBySide: true,
        //     icons: {
        //         time: "fa fa-clock-o",
        //         date: "fa fa-calendar",
        //         up: "fa fa-arrow-up",
        //         down: "fa fa-arrow-down",
        //         previous: "fa fa-chevron-left",
        //         next: "fa fa-chevron-right",
        //         today: "fa fa-clock-o",
        //         clear: "fa fa-trash-o"
        //     }
        // });
    </script>


@endsection
