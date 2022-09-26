<div class="row" style="margin-top: 10px;margin-bottom: 10px;">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInput">Note type</label>
                <select class="form-control note_type" name="note_type">
                    <option value="General">General</option>
                    <option value="UAT">UAT</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInput">Note date</label>
                <input name="note_date" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control note_date my_datepicker" placeholder="Note date">
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInput">Summary</label> <i style="background-color: greenyellow">Here last comment is showing for convenient</i>
            <textarea name="cr_notes" class="form-control cr_notes" rows="4">{{$crDuplicate->cr_notes}}</textarea>
        </div>
        <div style="float: right;">
            <button type="button" class="btn btn-primary add_note_btn"> <span class="spinner-icon"></span> Add note </button>
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
