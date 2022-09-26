<div class="row">
    <div class="col-md-3">
        @if(App\Libraries\aclHandler::hasActionAccess('mf_cr_write') == true)
            <button class="btn btn-primary btn-block mb-3 add_new_note_btn">Add New</button>
        @endif
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All notes</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0 note_list_section" style="max-height: 300px;overflow-y: auto;">
                <ul class="nav nav-pills flex-column">
                    @foreach($crNoteData as $note)
                    <li class="nav-item">
                        <a href="#" class="nav-link note_list_btn" data-note_id="{{$note->id}}">
                            <i class="far fa-envelope"></i> &nbsp; {{\Carbon\Carbon::parse($note->note_date)->format('d M Y')}}
                            <span class="badge bg-primary float-right">{{$note->note_type}}</span>
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>
            <!-- /.card-body -->
        </div>

    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title"><b style="font-weight: bold;">Title: </b> {{$crData->cr_title}}</h3>
                <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <input name="cr_master_id" type="hidden" value="{{$crData->id}}" class="form-control cr_master_id">
                <div class="data_area_response_msg"></div>
                <div class="image loading_brac_img" style="text-align: center;display: none;">
                    <img src="{{url('/admin_src/img/brac_logo.gif')}}" class="img" alt="User Image">
                </div>
                <div class="notes_data_show_area"></div>
                <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer p-0">
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
</div>

<script>
    $('.my_datepicker').datetimepicker({
        //   viewMode: 'years',
        format: 'DD-MM-YYYY',
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
      //  defaultDate:new Date()
    });
</script>
