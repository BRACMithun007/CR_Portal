<input name="update_user_id" value="{{$userData->id}}" type="hidden" class="form-control update_user_id">

<div class="form-group">
    <label for="exampleInput">Name</label>
    <input name="user_name_update" value="{{$userData->name}}" type="text" class="form-control user_name_update" placeholder="Enter Name">
</div>
<div class="form-group">
    <label for="exampleInput">Email</label>
    <input name="user_email_update" value="{{$userData->email}}" type="text" class="form-control" placeholder="Enter Email" readonly>
</div>
<div class="form-group">
    <label for="exampleInputEmail1">Account Type</label>
    <select name="user_type_update" class="form-control user_type_update">
        <option value="">Please select</option>
        <option value="Admin" @if($userData->type == 'Admin') selected @endif>Admin</option>
        <option value="Management" @if($userData->type == 'Management') selected @endif>Management</option>
        <option value="General" @if($userData->type == 'General') selected @endif>General</option>
    </select>
</div>
<div class="form-group">
    <label>Assign permission</label>
    <select class="select2 user_permission_update" name="user_permission_update" multiple="multiple" data-placeholder="Select permission" style="width: 100%;">
        <option value="calculators" @if(in_array('calculators',$userPermission)) selected @endif>calculators</option>
        <option value="user_read" @if(in_array('user_read',$userPermission)) selected @endif>user_read</option>
        <option value="user_write" @if(in_array('user_write',$userPermission)) selected @endif>user_write</option>
        <option value="mf_cr_read" @if(in_array('mf_cr_read',$userPermission)) selected @endif>mf_cr_read</option>
        <option value="mf_cr_write" @if(in_array('mf_cr_write',$userPermission)) selected @endif>mf_cr_write</option>
        <option value="circular_read" @if(in_array('circular_read',$userPermission)) selected @endif>circular_read</option>
        <option value="circular_write" @if(in_array('circular_write',$userPermission)) selected @endif>circular_write</option>
        <option value="req_cr_read" @if(in_array('req_cr_read',$userPermission)) selected @endif>req_cr_read</option>
        <option value="req_cr_write" @if(in_array('req_cr_write',$userPermission)) selected @endif>req_cr_write</option>
    </select>
</div>
<div class="form-group">
    <label for="exampleInput">Phone</label>
    <input name="user_phone_update" value="{{$userData->phone}}" type="text" class="form-control user_phone_update" placeholder="Enter Phone">
</div>
<div class="form-group">
    <label for="exampleInput">Country</label>
    <input name="user_country_update" value="{{$userData->country}}" type="text" class="form-control user_country_update" placeholder="Enter Country Name">
</div>
<div class="form-group">
    <label for="exampleInput">Designation</label>
    <input name="user_designation_update" type="text" value="{{$userData->designation}}" class="form-control user_designation_update" placeholder="Enter Designation">
</div>

<script>
    $('.select2').select2();
</script>
