<input name="update_circular_id" value="{{$circularData->id}}" type="hidden" class="form-control update_circular_id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">Circular Title <b style="color: red">*</b></label>
            <textarea name="update_circular_title" class="form-control update_circular_title">{{$circularData->title}}</textarea>
        </div>

        <div class="form-group">
            <label for="exampleInput">Select circular category <b style="color: red">*</b></label>
            <select class="form-control update_circular_category" name="update_circular_category">
                <option value="">Select circular category</option>
                <option value="insurance" @if($circularData->category == 'insurance') selected @endif>Insurance</option>
                <option value="loan" @if($circularData->category == 'loan') selected @endif>Loan</option>
                <option value="general_savings" @if($circularData->category == 'general_savings') selected @endif>General Savings</option>
                <option value="special_savings"  @if($circularData->category == 'special_savings') selected @endif>Special Savings</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInput">Circular number <b style="color: red">*</b></label>
            <input name="update_circular_number" value="{{$circularData->circular_number}}" type="text" class="form-control update_circular_number" placeholder="circular number">
        </div>

        <div class="form-group">
            <label for="exampleInput">Requester team <b style="color: red">*</b></label>
            <input name="update_requester_team" type="text" value="{{$circularData->requester_team}}" class="form-control update_requester_team" placeholder="requester team">
        </div>

        <div class="form-group">
            <label for="exampleInput">Circular sign date</label>
            <input name="update_sign_date" type="text"
                   @if($circularData->sign_date != '0000-00-00' && $circularData->sign_date != null) value="{{date("d-m-Y", strtotime($circularData->sign_date))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control update_sign_date my_datepicker">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">Circular Details <b style="color: red">*</b></label>
            <textarea name="update_circular_details" class="form-control update_circular_details">{{$circularData->details}}</textarea>
        </div>

        <div class="form-group">
            <label for="exampleInput">Expected timeline</label>
            <input name="update_mf_expect_timeline" type="text"
                   @if($circularData->mf_expect_timeline != '0000-00-00' && $circularData->mf_expect_timeline != null) value="{{date("d-m-Y", strtotime($circularData->mf_expect_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control update_mf_expect_timeline my_datepicker" placeholder="Expected timeline">
        </div>

        <div class="form-group">
            <label for="exampleInput">Circular type</label>
            <select class="form-control update_circular_type" name="update_circular_type">
                <option value="">Select One</option>
                <option value="Core_Business" @if($circularData->circular_type == 'Core_Business') selected @endif>Core Business</option>
                <option value="Support_CR" @if($circularData->circular_type == 'Support_CR') selected @endif>Support CR</option>
                <option value="Configurable" @if($circularData->circular_type == 'Configurable') selected @endif>Configurable Item</option>
                <option value="Integration" @if($circularData->circular_type == 'Integration') selected @endif>Integration</option>
                <option value="Data_Correction" @if($circularData->circular_type == 'Data_Correction') selected @endif>Data Correction</option>
            </select>
        </div>

        <div class="form-group">
            <label for="exampleInput">Effective date</label>
            <input name="update_effective_date" type="text"
                   @if($circularData->effective_date != '0000-00-00' && $circularData->effective_date != null) value="{{date("d-m-Y", strtotime($circularData->effective_date))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control update_effective_date my_datepicker">
        </div>

        <div class="form-group">
            <label for="exampleInput">JIRA Code</label>
            <input name="update_jira_code" type="text" value="{{$circularData->jira_code}}" class="form-control update_jira_code" placeholder="JIRA code">
        </div>

    </div>

    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputFile">Circular file attachment (Allow PDF only)</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input update_circular_doc" name="update_circular_doc " accept="application/pdf" id="update_circular_doc">
                    <label class="custom-file-label label_update_circular_doc" for="exampleInputFile">
                        @if($circularData->circular_doc != "" && $circularData->circular_doc != null)
                            Already uploaded. choose file to change
                        @else
                            Choose file
                        @endif
                    </label>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $('input[type="file"]').change(function(e){
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });

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
    });
</script>
