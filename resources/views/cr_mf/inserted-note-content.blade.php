<input type="hidden" name="note_id" value="{{$crNoteData->id}}" class="note_id">
<div class="row" style="margin-top: 5px;margin-bottom: 10px;">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                @if(App\Libraries\aclHandler::hasActionAccess('mf_cr_write') == true)
                    <button class="btn btn-sm btn-info edit_enable_disable" style="float: right;"><i class="fas fa-pen"></i> Edit</button>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInput">Note type</label>
                <select class="form-control edit_note_type" name="edit_note_type" readonly>
                    <option value="General" @if($crNoteData->note_type == 'General')SELECTED @endif>General</option>
                    <option value="UAT" @if($crNoteData->note_type == 'UAT')SELECTED @endif>UAT</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInput">Note date</label>
                <input name="edit_note_date" type="text" value="{{date("d-m-Y", strtotime($crNoteData->note_date))}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control edit_note_date my_datepicker" placeholder="Note date" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInput">Summary</label>
            <textarea name="edit_cr_notes" class="form-control edit_cr_notes" rows="5" readonly>{{$crNoteData->cr_notes}}</textarea>
        </div>
        <div style="float: left;">
            <i>Updated by : {{$crNoteData->name}}</i>
        </div>
        <div class="update_note_btn_section" style="float: right;display: none;">
            <button type="button" class="btn btn-primary update_note_btn"> <span class="spinner-icon"></span> Update note </button>
        </div>
    </div>
</div>

<script>
    $('.my_datepicker').datetimepicker({
        //   viewMode: 'years',
        format: 'DD-MM-YYYY',
        defaultDate:new Date(),
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
</script>
