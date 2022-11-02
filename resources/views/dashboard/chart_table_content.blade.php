
{{--<link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/fontawesome-free/css/all.min.css')}}">--}}
<link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
{{--<link rel="stylesheet" type="text/css" href="{{asset('admin_src/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">--}}
{{--<link rel="stylesheet" type="text/css" href="{{asset('admin_src/dist/css/adminlte.min.css')}}">--}}

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
    .dataTables_length{
        display: none;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title">{{$modalHeaderText}}</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">

    <div class="card-body">
        <table id="chart_graph_data_table" class="table table-bordered table-striped table-sm">
            <thead>
            <tr style="background-color: #009A93;color: white;">
                <th style="width: 300px">CR Title</th>
                <th>Type</th>
                <th>Deployed On</th>
                <th>Vendor</th>
                <th style="width: 100px;">Effort (Days)</th>
            </tr>
            </thead>
            <tbody>
            @foreach($crData as $data)
                <tr>
                    <td style="width: 300px">{{$data->cr_title}}</td>
                    <td>{{$data->cr_type}}</td>
                    <td>{{$data->completed_on}}</td>
                    <td>{{$data->vendor_name}}</td>
                    <td>{{$data->approved_billable_effort}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>


<script src="{{asset('admin_src/plugins/datatables/jquery.dataTables.min.js')}}"></script>
{{--<script src="{{asset('admin_src/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/jszip/jszip.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/pdfmake/pdfmake.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/pdfmake/vfs_fonts.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>--}}
{{--<script src="{{asset('admin_src/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>--}}
<script>
    // $(function () {
    //     $("#example1").DataTable({
    //         "responsive": true, "lengthChange": false, "autoWidth": false,
    //         "buttons": ["csv", "excel", "pdf"]
    //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    //     $('#example2').DataTable({
    //         "paging": true,
    //         "lengthChange": false,
    //         "searching": false,
    //         "ordering": true,
    //         "info": true,
    //         "autoWidth": false,
    //         "responsive": true,
    //     });
    // });

    $(document).ready(function () {
        $('#chart_graph_data_table').DataTable();
    });
</script>
