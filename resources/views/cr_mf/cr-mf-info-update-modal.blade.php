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
            <label for="exampleInput">Approved billable effort</label>
            <input name="edit_approved_billable_effort" type="text" value="{{$crData->approved_billable_effort}}" class="form-control edit_approved_billable_effort" placeholder="Approved billable effort">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR category</label>
            <select class="form-control edit_category" name="edit_category">
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
            <input name="edit_vendor_name" type="text" value="{{$crData->vendor_name}}" class="form-control edit_vendor_name" placeholder="Approved billable effort">
        </div>
        <div class="form-group">
            <label for="exampleInput">Vendor proposed timeline</label>
            <input name="edit_vendor_proposed_timeline"
                   @if($crData->vendor_proposed_timeline != '0000-00-00' && $crData->vendor_proposed_timeline != null) value="{{date("d-m-Y", strtotime($crData->vendor_proposed_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control edit_vendor_proposed_timeline my_datepicker" placeholder="Vendor proposed timeline">
        </div>
        <div class="form-group">
            <label for="exampleInput">Priority</label>
            <select class="form-control edit_priority" name="edit_priority">
                <option value="0" @if($crData->priority == "99")SELECTED @endif>N/A</option>
                <option value="1" @if($crData->priority == "1")SELECTED @endif>1</option>
                <option value="2" @if($crData->priority == "2")SELECTED @endif>2</option>
                <option value="3" @if($crData->priority == "3")SELECTED @endif>3</option>
                <option value="4" @if($crData->priority == "4")SELECTED @endif>4</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">CR Status</label>
            <select class="form-control edit_cr_status" name="edit_cr_status">
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
            <input name="edit_business_analyst" type="text" value="{{$crData->business_analyst}}" class="form-control edit_business_analyst" placeholder="Business analyst">
        </div>
        <div class="form-group">
            <label for="exampleInput">UAT instance</label>
            <input name="edit_uat_instance" type="text" value="{{$crData->uat_instance}}" class="form-control edit_uat_instance" placeholder="UAT instance">
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
            <label for="exampleInput">Team Name</label>
            <select class="form-control edit_team_name" name="edit_team_name">
                <option value="">Select One</option>
                <option value="FAP" @if($crData->team_name == "FAP")SELECTED @endif>FAP</option>
                <option value="FAO" @if($crData->team_name == "FAO")SELECTED @endif>FAO</option>
                <option value="EA" @if($crData->team_name == "EA")SELECTED @endif>EA</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">CR locked by vendor</label>
            <input name="edit_cr_locked_by_vendor"
                   @if($crData->cr_locked_by_vendor != '0000-00-00' && $crData->cr_locked_by_vendor != null) value="{{date("d-m-Y", strtotime($crData->cr_locked_by_vendor))}}" @endif
                   type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control edit_cr_locked_by_vendor my_datepicker" placeholder="CR locked by vendor">
        </div>
        <div class="form-group">
            <label for="exampleInput">MF expect timeline</label>
            <input name="edit_mf_expect_timeline" type="text"
                   @if($crData->mf_expect_timeline != '0000-00-00' && $crData->mf_expect_timeline != null) value="{{date("d-m-Y", strtotime($crData->mf_expect_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control edit_mf_expect_timeline my_datepicker" placeholder="MF expect timeline">
        </div>
        <div class="form-group">
            <label for="exampleInput">Requester team</label>
            <input name="edit_requester_team" type="text" value="{{$crData->requester_team}}" class="form-control edit_requester_team" placeholder="Requester team">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR Type</label>
            <select class="form-control edit_cr_type" name="edit_cr_type">
                <option value="">Select One</option>
                <option value="CR" @if($crData->cr_type == "CR")SELECTED @endif>CR</option>
                <option value="CR_Addition" @if($crData->cr_type == "CR_Addition")SELECTED @endif>CR (Addition)</option>
                <option value="CR_One_Time" @if($crData->cr_type == "CR_One_Time")SELECTED @endif>CR (One Time)</option>
                <option value="CR_Change" @if($crData->cr_type == "CR_Change")SELECTED @endif>CR (Change)</option>
                <option value="Non_CR" @if($crData->cr_type == "Non_CR")SELECTED @endif>Non-CR</option>
                <option value="Data_Correction" @if($crData->cr_type == "Data_Correction")SELECTED @endif>Data Correction</option>
                <option value="Support_CR" @if($crData->cr_type == "Support_CR")SELECTED @endif>Support CR</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Completed on</label>
            <input name="edit_completed_on"
                   @if($crData->completed_on != '0000-00-00' && $crData->completed_on != null) value="{{date("d-m-Y", strtotime($crData->completed_on))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control edit_completed_on my_datepicker" placeholder="Completed on">
        </div>
        <div class="form-group">
            <label for="exampleInput">Assigned from BRAC tech</label>
            <select class="form-control edit_assigned_from_brac" name="edit_assigned_from_brac">
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
            <input name="edit_uat_credential" value="{{$crData->uat_credential}}" type="text" class="form-control edit_uat_credential" placeholder="UAT credential">
        </div>
        <div class="form-group">
            <label for="exampleInput">Satisfactory level</label>
            <select class="form-control edit_satisfactory_level" name="edit_satisfactory_level">
                <option value="">Select one</option>
                <option value="Good" @if($crData->satisfactory_level == "Good")SELECTED @endif>Good</option>
                <option value="Average" @if($crData->satisfactory_level == "Average")SELECTED @endif>Average</option>
                <option value="Substandard" @if($crData->satisfactory_level == "Substandard")SELECTED @endif>Substandard</option>
            </select>
        </div>
    </div>
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
    });
</script>
