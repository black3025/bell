<form class="modal-content needs-validation" onsubmit="return inform();">
    @csrf   
    <div class="modal-header">
        <h5 class="modal-title" id="backDropModalTitle"><i class='bx bx-user-plus' ></i> Create New User</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
    </div>
    <div class="modal-body">
            <div class="row mb-2">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text"  id="username" name="username" value="" class="form-control" placeholder="Input your Username" required autofocus>
                    </div>
                    <span class="text-danger">{{$errors->first('username')}}</span>
                </div>
            </div>   
            <div class="row mb-2">
                <label for="name" class="col-sm-2 col-form-label">Display Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text"  id="name" name="name" value="" class="form-control" placeholder="Input your desired display name" required autofocus>
                    </div>
                    <span class="text-danger">{{$errors->first('username')}}</span>
                </div>
            </div>   
            <div class="row mb-2">                   
                <label class="col-sm-2 col-form-label" for="role">Role</label>
                <div class="col-sm-10">
                    <select class="form-select" id="role" name="role" required>
                        <option selected value="">Choose...</option>
                        @foreach($roles as $role)
                            <option value="{{$role['id']}}">{{$role['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="divider">
                <div class="divider-text">
                    Personal Details
                </div>
            </div>
            <div class="row mb-2">
                <label for="first_name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text"  id="first_name" name="first_name" value="" class="form-control" placeholder="Enter Given Name">
                    </div>
                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                </div>
            </div>
            <div class="row mb-2">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="middle_name"   name="middle_name" value="" class="form-control" placeholder="Enter Middle Name">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text"  id="last_name" name="last_name" value="" class="form-control" placeholder="Enter SurName">
                    </div>
                </div>
            </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" id="mdCloseUser">Close</button>
        <button type="submit" class="btn btn-primary" value="submit">Save</button>
    </div>
</form>

<script>
    function inform(){
        $('#mdCloseUser').click();
         var form = {
            _token: $('input[name=_token]').val(),
            username: $('#username').val(),
            name: $('#name').val(),
            first_name : $('#first_name').val(),
            middle_name : $('#middle_name').val(),
            last_name : $('#last_name').val(),
            role_id : $('#role').val(),
            ajax: 1
         }

         $.ajax({
	         url : "{{route('users.store')}}",
	         data :  form,
	         type : "POST",
	         success : function(msg){
                //console.log(msg['message']);
                if(msg['success']){
                    success(msg['message']);
                    setTimeout(function(){window.location.reload();},1500);
                }else{
                    error(msg['message']);
                }
             }
        })
        return false;
    }
</script>


