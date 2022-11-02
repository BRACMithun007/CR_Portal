<input name="req_cr_id_for_import" value="{{$crData->id}}" type="hidden" class="form-control req_cr_id_for_import">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">CR Title</label>
            <textarea name="import_cr_title" class="form-control import_cr_title">{{$crData->cr_title}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInput">jira ID</label>
            <input name="import_jira_code" type="text" value="{{$crData->jira_code}}" class="form-control import_jira_code" placeholder="jira ID">
        </div>
        <div class="form-group">
            <label for="exampleInput">jira created</label>
            <input name="import_jira_created"
                   @if($crData->jira_created != '0000-00-00' && $crData->jira_created != null) value="{{date("d-m-Y", strtotime($crData->jira_created))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control import_jira_created my_datepicker" placeholder="jira creating date">
        </div>
        <div class="form-group">
            <label for="exampleInput">Approved billable effort</label>
            <input name="import_approved_billable_effort" type="text" value="{{$crData->approved_billable_effort}}" class="form-control import_approved_billable_effort" placeholder="Approved billable effort">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR category</label>
            <select class="form-control import_category" name="import_category">
                <option value="">Select One</option>
                <option value="Insurance" @if($crData->category == "Insurance")SELECTED @endif>Insurance</option>
                <option value="Loan" @if($crData->category == "Loan")SELECTED @endif>Loan</option>
                <option value="Savings" @if($crData->category == "Savings")SELECTED @endif>Savings</option>
                <option value="EA_B2B" @if($crData->category == "EA_B2B")SELECTED @endif>EA_B2B</option>
                <option value="EA_B2C" @if($crData->category == "EA_B2C")SELECTED @endif>EA_B2C</option>
                <option value="EA_Server" @if($crData->category == "EA_Server")SELECTED @endif>EA_Server</option>
                <option value="Others" @if($crData->category == "Others")SELECTED @endif>Others</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Vendor Name</label>
            <input name="import_vendor_name" type="text" value="{{$crData->vendor_name}}" class="form-control import_vendor_name" placeholder="Approved billable effort">
        </div>
        <div class="form-group">
            <label for="exampleInput">Vendor proposed timeline</label>
            <input name="import_vendor_proposed_timeline"
                   @if($crData->vendor_proposed_timeline != '0000-00-00' && $crData->vendor_proposed_timeline != null) value="{{date("d-m-Y", strtotime($crData->vendor_proposed_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control import_vendor_proposed_timeline my_datepicker" placeholder="Vendor proposed timeline">
        </div>
        <div class="form-group">
            <label for="exampleInput">Priority</label>
            <select class="form-control import_priority" name="import_priority">
                <option value="0" @if($crData->priority == "99")SELECTED @endif>N/A</option>
                <option value="1" @if($crData->priority == "1")SELECTED @endif>1</option>
                <option value="2" @if($crData->priority == "2")SELECTED @endif>2</option>
                <option value="3" @if($crData->priority == "3")SELECTED @endif>3</option>
                <option value="4" @if($crData->priority == "4")SELECTED @endif>4</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">CR Status</label>
            <select class="form-control import_cr_status" name="import_cr_status">
                <option value="">Select One</option>
                <option value="Ongoing" @if($crData->cr_status == "Ongoing")SELECTED @endif>Ongoing</option>
                <option value="PendingDeployment" @if($crData->cr_status == "PendingDeployment")SELECTED @endif>Pending Deployment</option>
                <option value="Deployed" @if($crData->cr_status == "Deployed")SELECTED @endif>Deployed in live</option>
                <option value="TBD" @if($crData->cr_status == "TBD")SELECTED @endif>To Be Decide</option>
                <option value="Halt" @if($crData->cr_status == "Halt")SELECTED @endif>ON Halt</option>
                <option value="Backlog" @if($crData->cr_status == "Backlog")SELECTED @endif>Backlog</option>
                <option value="Abandoned" @if($crData->cr_status == "Abandoned")SELECTED @endif>Abandoned</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Business analyst</label>
            <input name="import_business_analyst" type="text" value="{{$crData->business_analyst}}" class="form-control import_business_analyst" placeholder="Business analyst">
        </div>
        <div class="form-group">
            <label for="exampleInput">UAT instance</label>
            <input name="import_uat_instance" type="text" value="{{$crData->uat_instance}}" class="form-control import_uat_instance" placeholder="UAT instance">
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">CR Details</label>
            <textarea name="import_cr_details" class="form-control import_cr_details">{{$crData->cr_details}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInput">Initial requirement shared by MF</label>
            <input name="import_initial_requirement_shared_from_mf"
                   @if($crData->initial_requirement_shared_from_mf != '0000-00-00' && $crData->initial_requirement_shared_from_mf != null) value="{{date("d-m-Y", strtotime($crData->initial_requirement_shared_from_mf))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                   type="text" class="form-control import_initial_requirement_shared_from_mf my_datepicker" placeholder="Initial requirement shared by MF">
        </div>
        <div class="form-group">
            <label for="exampleInput">Team Name</label>
            <select class="form-control import_team_name" name="import_team_name">
                <option value="">Select One</option>
                <option value="FAP" @if($crData->team_name == "FAP")SELECTED @endif>FAP</option>
                <option value="FAO" @if($crData->team_name == "FAO")SELECTED @endif>FAO</option>
                <option value="EA" @if($crData->team_name == "EA")SELECTED @endif>EA</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">CR locked by vendor</label>
            <input name="import_cr_locked_by_vendor"
                   @if($crData->cr_locked_by_vendor != '0000-00-00' && $crData->cr_locked_by_vendor != null) value="{{date("d-m-Y", strtotime($crData->cr_locked_by_vendor))}}" @endif
                   type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control import_cr_locked_by_vendor my_datepicker" placeholder="CR locked by vendor">
        </div>
        <div class="form-group">
            <label for="exampleInput">MF expect timeline</label>
            <input name="import_mf_expect_timeline" type="text"
                   @if($crData->mf_expect_timeline != '0000-00-00' && $crData->mf_expect_timeline != null) value="{{date("d-m-Y", strtotime($crData->mf_expect_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control import_mf_expect_timeline my_datepicker" placeholder="MF expect timeline">
        </div>
        <div class="form-group">
            <label for="exampleInput">Requester team</label>
            <input name="import_requester_team" type="text" value="{{$crData->requester_team}}" class="form-control import_requester_team" placeholder="Requester team">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR Type</label>
            <select class="form-control import_cr_type" name="import_cr_type">
                <option value="">Select One</option>
                <option value="Core_Business" @if($crData->cr_type == "Core_Business")SELECTED @endif>Core Business</option>
                <option value="Support_CR" @if($crData->cr_type == "Support_CR")SELECTED @endif>Support CR</option>
                <option value="Configurable_Item" @if($crData->cr_type == "Configurable")SELECTED @endif>Configurable Item</option>
                <option value="Integration" @if($crData->cr_type == "Integration")SELECTED @endif>Integration</option>
{{--                <option value="CR_Addition" @if($crData->cr_type == "CR_Addition")SELECTED @endif>CR (Addition)</option>--}}
{{--                <option value="CR_One_Time" @if($crData->cr_type == "CR_One_Time")SELECTED @endif>CR (One Time)</option>--}}
{{--                <option value="CR_Change" @if($crData->cr_type == "CR_Change")SELECTED @endif>CR (Change)</option>--}}
{{--                <option value="Non_CR" @if($crData->cr_type == "Non_CR")SELECTED @endif>Non-CR</option>--}}
{{--                <option value="Data_Correction" @if($crData->cr_type == "Data_Correction")SELECTED @endif>Data Correction</option>--}}
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Completed on</label>
            <input name="import_completed_on"
                   @if($crData->completed_on != '0000-00-00' && $crData->completed_on != null) value="{{date("d-m-Y", strtotime($crData->completed_on))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control import_completed_on my_datepicker" placeholder="Completed on">
        </div>
        <div class="form-group">
            <label for="exampleInput">Assigned from BRAC tech</label>
            <select class="form-control import_assigned_from_brac" name="import_assigned_from_brac">
                <option value="">Select one</option>
                <option value="Pramit" @if($crData->assigned_from_brac == "Pramit")SELECTED @endif>Pramit</option>
                <option value="Shafiqul" @if($crData->assigned_from_brac == "Shafiqul")SELECTED @endif>Shafiqul</option>
                <option value="Lamia" @if($crData->assigned_from_brac == "Lamia")SELECTED @endif>Lamia</option>
                <option value="Tanvir" @if($crData->assigned_from_brac == "Tanvir")SELECTED @endif>Tanvir</option>
                <option value="Rakebul" @if($crData->assigned_from_brac == "Rakebul")SELECTED @endif>Rakebul</option>
                <option value="Mithun" @if($crData->assigned_from_brac == "Mithun")SELECTED @endif>Mithun</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">UAT credential</label>
            <input name="import_uat_credential" value="{{$crData->uat_credential}}" type="text" class="form-control import_uat_credential" placeholder="UAT credential">
        </div>
        <div class="form-group">
            <label for="exampleInput">Satisfactory level</label>
            <select class="form-control import_satisfactory_level" name="import_satisfactory_level">
                <option value="">Select one</option>
                <option value="Good" @if($crData->satisfactory_level == "Good")SELECTED @endif>Good</option>
                <option value="Average" @if($crData->satisfactory_level == "Average")SELECTED @endif>Average</option>
                <option value="Substandard" @if($crData->satisfactory_level == "Substandard")SELECTED @endif>Substandard</option>
            </select>
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
