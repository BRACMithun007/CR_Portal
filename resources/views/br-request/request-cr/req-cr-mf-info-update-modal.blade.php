<input name="update_cr_id" value="{{$crData->id}}" type="hidden" class="form-control update_cr_id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">CR Title</label>
            <textarea name="edit_cr_title" class="form-control edit_cr_title">{{$crData->cr_title}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInput">jira ID</label>
            <input name="edit_jira_code" type="text" value="{{$crData->jira_code}}" class="form-control edit_jira_code" placeholder="jira ID">
        </div>
        <div class="form-group">
            <label for="exampleInput">jira created</label>
            <input name="edit_jira_created"
                   @if($crData->jira_created != '0000-00-00' && $crData->jira_created != null) value="{{date("d-m-Y", strtotime($crData->jira_created))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control edit_jira_created my_datepicker" placeholder="jira creating date">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR category</label>
            <select class="form-control edit_category" name="edit_category">
                <option value="">Select One</option>
                <option value="Loan" @if($crData->category == "Loan")SELECTED @endif>Loan</option>
                <option value="Insurance" @if($crData->category == "Insurance")SELECTED @endif>Insurance</option>
                <option value="Savings" @if($crData->category == "Savings")SELECTED @endif>Savings</option>
                <option value="EA_B2B" @if($crData->category == "EA_B2B")SELECTED @endif>Integration</option>
                <option value="Others" @if($crData->category == "Others")SELECTED @endif>Others</option>
            </select>
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">CR Details</label>
            <textarea name="edit_cr_details" class="form-control edit_cr_details">{{$crData->cr_details}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInput">Initial requirement shared by MF</label>
            <input name="edit_initial_requirement_shared_from_mf"
                   @if($crData->initial_requirement_shared_from_mf != '0000-00-00' && $crData->initial_requirement_shared_from_mf != null) value="{{date("d-m-Y", strtotime($crData->initial_requirement_shared_from_mf))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                   type="text" class="form-control edit_initial_requirement_shared_from_mf my_datepicker" placeholder="Initial requirement shared by MF">
        </div>
        <div class="form-group">
            <label for="exampleInput">Requester Team</label>
            <select class="form-control edit_team_name" name="edit_team_name">
                <option value="">Select One</option>
                <option value="Product Team" @if($crData->team_name == "Product Team")SELECTED @endif>Product Team</option>
                <option value="Insurance Team" @if($crData->team_name == "Insurance Team")SELECTED @endif>Insurance Team</option>
                <option value="Digital Cluster Team" @if($crData->team_name == "Digital Cluster Team")SELECTED @endif>Digital Cluster Team</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Expected Timeline</label>
            <input name="edit_mf_expect_timeline" type="text"
                   @if($crData->mf_expect_timeline != '0000-00-00' && $crData->mf_expect_timeline != null) value="{{date("d-m-Y", strtotime($crData->mf_expect_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control edit_mf_expect_timeline my_datepicker" placeholder="MF expect timeline">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputFile">Final CR Document (Allowed PDF only)</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input edit_cr_doc" name="edit_cr_doc " accept="application/pdf" id="edit_cr_doc">
                    <label class="custom-file-label" for="exampleInputFile">
                        @if($crData->cr_doc_link != "" && $crData->cr_doc_link != null)
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
