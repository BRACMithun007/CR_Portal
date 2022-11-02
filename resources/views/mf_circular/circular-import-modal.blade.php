<input name="circular_id" value="{{$circularData->id}}" type="hidden" class="form-control circular_id">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">CR Title</label>
            <textarea name="cr_title" class="form-control cr_title">{{$circularData->title}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInput">jira ID</label>
            <input name="import_jira_code" type="text" value="{{$circularData->jira_code}}" class="form-control import_jira_code" placeholder="jira ID">
        </div>
        <div class="form-group">
            <label for="exampleInput">jira created</label>
            <input name="jira_created" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control jira_created my_datepicker" placeholder="jira creating date">
        </div>
        <div class="form-group">
            <label for="exampleInput">Approved billable effort</label>
            <input name="approved_billable_effort" type="text" value="" class="form-control approved_billable_effort" placeholder="Approved billable effort">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR category</label>
            <select class="form-control category" name="category">
                <option value="">Select One</option>
                <option value="Insurance">Insurance</option>
                <option value="Loan">Loan</option>
                <option value="Savings">Savings</option>
                <option value="EA_B2B">EA_B2B</option>
                <option value="EA_B2C">EA_B2C</option>
                <option value="EA_Server">EA_Server</option>
                <option value="Others">Others</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Vendor Name</label>
            <input name="vendor_name" type="text" value="" class="form-control vendor_name" placeholder="Approved billable effort">
        </div>
        <div class="form-group">
            <label for="exampleInput">Vendor proposed timeline</label>
            <input name="vendor_proposed_timeline" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control vendor_proposed_timeline my_datepicker" placeholder="Vendor proposed timeline">
        </div>
        <div class="form-group">
            <label for="exampleInput">Priority</label>
            <select class="form-control priority" name="priority">
                <option value="99">N/A</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">CR Status</label>
            <select class="form-control cr_status" name="cr_status">
                <option value="Backlog">Backlog</option>
                <option value="Ongoing">Ongoing</option>
                <option value="PendingDeployment">Pending Deployment</option>
                <option value="Deployed">Deployed in live</option>
                <option value="TBD">To Be Decide</option>
                <option value="Halt">ON Halt</option>
                <option value="Abandoned">Abandoned</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Business analyst</label>
            <input name="business_analyst" type="text" value="" class="form-control business_analyst" placeholder="Business analyst">
        </div>
        <div class="form-group">
            <label for="exampleInput">UAT instance</label>
            <input name="uat_instance" type="text" value="" class="form-control uat_instance" placeholder="UAT instance">
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group">
            <label for="exampleInput">CR Details</label>
            <textarea name="cr_details" class="form-control cr_details">{{$circularData->details}}</textarea>
        </div>
        <div class="form-group">
            <label for="exampleInput">Initial requirement shared by MF</label>
            <input name="initial_requirement_shared_from_mf"
                   @if($circularData->request_on != '0000-00-00' && $circularData->request_on != null) value="{{date("d-m-Y", strtotime($circularData->request_on))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                   type="text" class="form-control initial_requirement_shared_from_mf my_datepicker" placeholder="Initial requirement shared by MF">
        </div>
        <div class="form-group">
            <label for="exampleInput">Team Name</label>
            <select class="form-control team_name" name="team_name">
                <option value="">Select One</option>
                <option value="FAP">FAP</option>
                <option value="FAO">FAO</option>
                <option value="EA">EA</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">CR locked by vendor</label>
            <input name="cr_locked_by_vendor" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control cr_locked_by_vendor my_datepicker" placeholder="CR locked by vendor">
        </div>
        <div class="form-group">
            <label for="exampleInput">MF expect timeline</label>
            <input name="importable_mf_expect_timeline" type="text"
                   @if($circularData->mf_expect_timeline != '0000-00-00' && $circularData->mf_expect_timeline != null) value="{{date("d-m-Y", strtotime($circularData->mf_expect_timeline))}}" @endif
                   oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" class="form-control importable_mf_expect_timeline my_datepicker" placeholder="MF expect timeline">
        </div>
        <div class="form-group">
            <label for="exampleInput">Requester team</label>
            <input name="import_requester_team" type="text" value="{{$circularData->requester_team}}" class="form-control import_requester_team" placeholder="Requester team">
        </div>
        <div class="form-group">
            <label for="exampleInput">CR Type</label>
            <select class="form-control cr_type" name="cr_type">
                <option value="">Select One</option>
                <option value="Core_Business" @if($circularData->circular_type == 'Core_Business') selected @endif>Core Business</option>
                <option value="Support_CR" @if($circularData->circular_type == 'Support_CR') selected @endif>Support CR</option>
                <option value="Configurable_Item" @if($circularData->circular_type == 'Configurable_Item') selected @endif>Configurable Item</option>
                <option value="Integration" @if($circularData->circular_type == 'Integration') selected @endif>Integration</option>
                <option value="Data_Correction" @if($circularData->circular_type == 'Data_Correction') selected @endif>Data Correction</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">Completed on</label>
            <input name="completed_on" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="form-control completed_on my_datepicker" placeholder="Completed on">
        </div>
        <div class="form-group">
            <label for="exampleInput">Assigned from BRAC tech</label>
            <select class="form-control assigned_from_brac" name="assigned_from_brac">
                <option value="">Select one</option>
                <option value="Pramit" >Pramit</option>
                <option value="Shafiqul" >Shafiqul</option>
                <option value="Lamia" >Lamia</option>
                <option value="Tanvir" >Tanvir</option>
                <option value="Rakebul" >Rakebul</option>
                <option value="Mithun" >Mithun</option>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInput">UAT credential</label>
            <input name="uat_credential" value="" type="text" class="form-control uat_credential" placeholder="UAT credential">
        </div>
        <div class="form-group">
            <label for="exampleInput">Satisfactory level</label>
            <select class="form-control satisfactory_level" name="satisfactory_level">
                <option value="">Select one</option>
                <option value="Good" >Good</option>
                <option value="Average">Average</option>
                <option value="Substandard" >Substandard</option>
            </select>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputFile">Final CR Document (Allowed PDF only)</label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input cr_doc" name="cr_doc " accept="application/pdf" id="cr_doc">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
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
