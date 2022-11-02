<input type="hidden" name="comment_id" value="{{$crCommentData->id}}" class="comment_id">
<div class="row" style="margin-top: 5px;margin-bottom: 10px;">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                @if($crCommentData->created_by == Auth::user()->id)
                    <button class="btn btn-sm comment_enable_disable" style="float: right;background-color:#009A93;color:white;"><i class="fas fa-pen"></i> Edit</button>
                @endif
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInput">Comment type</label>
                <select class="form-control edit_comment_type" name="edit_comment_type" readonly>
                    <option value="Management" @if($crCommentData->comment_type == 'Management')SELECTED @endif>Management</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInput">Comment date</label>
                <input name="edit_comment_date" type="text" value="{{date("d-m-Y", strtotime($crCommentData->comment_date))}}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control edit_comment_date my_datepicker" placeholder="Comment date" readonly>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInput">Comment</label>
            <textarea name="edit_cr_comment" class="form-control edit_cr_comment" rows="5" readonly>{{$crCommentData->comment}}</textarea>
        </div>
        <div style="float: left;">
            <i>Commented by : {{$crCommentData->name}}</i>
        </div>
        <div class="update_comment_btn_section" style="float: right;display: none;">
            <button type="button" class="btn update_comment_btn" style="background-color:#009A93;color:white;"> <span class="spinner-icon"></span> Update comment </button>
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
