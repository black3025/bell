@extends('layouts/contentNavbarLayout')

@section('title', 'User Profile - '.Auth::user()->name)

@section('page-script')
    <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/swal.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">User Profile </span> {{$user->client_id}}
</h4>

<div class="row" style="display:flex; justify-content:space-between">
    <div class="card mb-4 col-md-6" >
      <h5 class="card-header">Profile Details - {{$user->username}}</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{asset('assets/img/avatars/1.png')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
          <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
              <span class="d-none d-sm-block">Upload new photo</span>
              <i class="bx bx-upload d-block d-sm-none"></i>
              <input type="file" id="upload" class="account-file-input" hidden accept="image/png, image/jpeg" />
            </label>
            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
              <i class="bx bx-reset d-block d-sm-none"></i>
              <span class="d-none d-sm-block">Reset</span>
            </button>

            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
          </div>
        </div>
      </div>
      <hr class="my-0">
      <div class="card-body">
        <form id="editProfile" onsubmit="return updateForm();">
        @csrf
            <div class="row mb-2">
                <label for="first_name" class="col-sm-2 col-form-label">Display Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="name" name="name" class="form-control" value="{{$user->name}}" required autofocus>
                    </div>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
            </div>
            <div class="row mb-2">
                <label for="first_name" class="col-sm-2 col-form-label">First Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" onchange="acctname()" id="first_name" name="first_name" class="form-control" value="{{$user->first_name}}"  placeholder="Enter First Name" required>
                    </div>
                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                </div>
            </div>
            <div class="row mb-2">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="middle_name" onchange="acctname()" name="middle_name" value="{{$user->middle_name}}" class="form-control" placeholder="Enter Middle Name">
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" onchange="acctname()" id="last_name" name="last_name" value="{{$user->last_name}}" class="form-control" placeholder="Enter SurName" required>
                    </div>
                </div>
            </div>

          <div class="mt-2" style="display:flex;">
            <button style="margin-left:auto; margin-right:0" type="submit" class="btn btn-primary me-2">Save changes</button>
          </div>
        </form>
      </div>
      <!-- /Account -->
    </div>

        <div class="card mb-4 col-md-5" >
            <h5 style="display:flex; justify-content:space-between" class="card-header">
                    Security Details
            </h5>
            <form id="updatePass" onsubmit="return updatePass();">
            @csrf
                    
            <div class="card-body">
                <div class="row mb-2">
                    <label for="old" class="col-sm-4 col-form-label">Old Password</label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-merge">
                            <span id="old-label" class="input-group-text"><i class='bx bxs-lock-alt' ></i></span>
                            <input type="password" id="old" name="old" class="form-control" placeholder="Enter Old Name">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <label for="password" class="col-sm-4 col-form-label">New Password</label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-merge">
                            <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-lock' ></i></span>
                            <input type="password" id="password"  name="password"  class="form-control" placeholder="Enter New Password">
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <label for="confirm" class="col-sm-4 col-form-label">Confirm Password</label>
                    <div class="col-sm-7">
                        <div class="input-group input-group-merge">
                            <span id="confirm-label" class="input-group-text"><i class='bx bx-lock' ></i></span>
                            <input type="password" id="confirm"  name="confirm"  class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                </div>
                <div class="mt-2" style="display:flex;">
                    <button style="margin-left:auto; margin-right:0" type="submit" class="btn btn-primary me-2"><i class='bx bx-lock-open' ></i> Change Password</button>
                </div>
            </div>
            </form>
        </div>
</div>
<script>
    function updateForm(){
        var form = $('#editProfile').serialize();
         $.ajax({
	         url : "{{route('users.update',$user->id)}}",
	         data :  form,
	         type : "PATCH",
	         success : function(msg){
                console.log(msg);
                if(msg['success']){
                    success(msg['message']);
                    setTimeout(function(){window.location.reload();},1500);
                }else{
                    error(msg['message']);
                }
             }
        });
        return false;
    }

    function updatePass(){
        var form = {
            _token: $('input[name=_token]').val(),
            id: {{Auth::user()->id}},
            old: $('#old').val(),
            password: $('#password').val(),
            confirm: $('#confirm').val(),
            ajax: 1
        }
        //check if confirm password is the same
        if($('#password').val() != $('#confirm').val()){
            console.log(form);
            warning('Password does not match.');
        }else{
            if($('#password').val() == $('#old').val())
                warning('Password cannot be the same as your old password');
            else{
                $.ajax({
                    url : "{{url('/users/updatePass')}}",
                    data :  form,
                    type : "POST",
                    success : function(msg){
                        console.log(msg['message']);
                        if(msg['success']){
                            success(msg['message']);
                            //setTimeout(function(){window.location.reload();},1500);
                        }else{
                            warning(msg['message']);
                        }
                    }
                })
            }
        }

        return false;
    }
</script>
@endsection
