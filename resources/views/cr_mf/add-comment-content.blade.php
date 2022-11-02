<div class="row" style="margin-top: 10px;margin-bottom: 10px;">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="exampleInput">Comment type</label>
                <select class="form-control comment_type" name="comment_type">
                    <option value="Management">Management</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="exampleInput">Comment date</label>
                <input name="comment_date" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control comment_date my_datepicker" placeholder="comment date">
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInput">Comment</label>
            <textarea name="cr_comment" class="form-control cr_comment" rows="4"></textarea>
        </div>
        <div style="float: right;">
            <button type="button" class="btn add_comment_btn" style="background-color:#009A93;color:white;"> <span class="spinner-icon"></span> Add comment </button>
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
