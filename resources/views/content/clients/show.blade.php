@extends('layouts/contentNavbarLayout')

@section('title', 'Client Profile - '.$client->client_id)

@section('page-script')
    <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/swal.js')}}"></script>
@endsection

@section('content')
<h4 class="fw-bold py-3 mb-4">
  <span class="text-muted fw-light">Client No: </span> {{$client->client_id}}
</h4>

<div class="row" style="display:flex; justify-content:space-between">
    <div class="card mb-4 col-md-6" >
      <h5 class="card-header">Profile Details</h5>
      <!-- Account -->
      <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4">
          <img src="{{asset('assets/img/avatars/default.png')}}" alt="user-avatar" class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
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
        <div class="row mb-2" >
                <input hidden tabindex="-1"  class="form-control" id="account_name" name="account_name" value="{{$client->account_name}}" required>
            </div>
            <div class="row mb-2">
                <label for="first_name" class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" onchange="acctname()" id="first_name" name="first_name" class="form-control" value="{{$client->first_name}}" required autofocus>
                    </div>
                    <span class="text-danger">{{$errors->first('first_name')}}</span>
                </div>
            </div>
            <div class="row mb-2">
                <label for="middle_name" class="col-sm-2 col-form-label">Middle Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="middle_name" onchange="acctname()" name="middle_name" value="{{$client->middle_name}}" class="form-control" placeholder="Enter Middle Name">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="last_name" class="col-sm-2 col-form-label">Last Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" onchange="acctname()" id="last_name" name="last_name" value="{{$client->last_name}}" class="form-control" placeholder="Enter SurName" required>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="business" class="col-sm-2 col-form-label">Business</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-buildings"></i></span>
                        <input type="text" id="business" value="{{$client->business}}" required name="business" class="form-control" placeholder="Business">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="contact_number" class="col-sm-2 col-form-label">Mobile #</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-phone"></i></span>
                        <input type="number" value="{{$client->contact_number}}" id="contact_number" name="contact_number" required class="form-control" placeholder="09XXXXXXXX">
                    </div>
                </div>
            </div>
            <div class="row mb-2">                   
                <label class="col-sm-2 col-form-label" for="area">Area</label>
                <div class="col-sm-10">
                    <select class="form-select" id="area" name="area" required>
                        <option selected value="">Choose...</option>
                        @foreach($areas as $area)
                            <option value="{{$area['id']}}" {{ ($area['id'] == $client->area_id)? "selected" : "" }} >{{$area['name']}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mb-4">
                <label for="address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-home"></i></span>
                        <input type="text" id="address" value= "{{$client->address}}" required name="address" class="form-control" placeholder="Complete address">
                    </div>
                </div>
            </div>
            <div class="divider">
                <div class="divider-text">
                    Co-Maker
                </div>
            </div>
            <div class="row mb-2">
                <label for="co_maker" class="col-sm-2 col-form-label">Full Name</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-user"></i></span>
                        <input type="text" id="co_maker" name="co_maker" class="form-control" value= "{{$client->co_maker}}"  placeholder="Name of Co-Maker">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="co_number" class="col-sm-2 col-form-label">Number</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                         <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-phone"></i></span>
                        <input type="text" id="co_number" name="co_number"  value= "{{$client->co_number}}" class="form-control" placeholder="Contact number of Co-Maker">
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <label for="co_address" class="col-sm-2 col-form-label">Address</label>
                <div class="col-sm-10">
                    <div class="input-group input-group-merge">
                        <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-home"></i></span>
                        <input type="text" id="co_address" name="co_address" value= "{{$client->co_address}}" class="form-control" placeholder="Address of Co-Maker">
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
                    Loan Details
                    <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addLoan"><i class='bx bx-message-square-add' ></i> New Loan</button>
            </h5>
            <div class="card-body">
                @if(!$client->loans->isEmpty())
                        <div class="divider">
                            <div class="divider-text">
                                    Active loan
                            </div>
                        </div>
                        @if($client->loans->where('close_date',NULL)->first())
                            <table class="table table-bordered" width='100%'>
                                <tr>
                                    <td><b>Principal Amount: </b></td>
                                    <td>&#8369; {{number_format($client->loans->where('close_date',NULL)->first()->principle_amount)}}</td>
                                </tr>
                                <tr>
                                    <td><b>Cycle:</b></td>
                                    <td>{{$client->loans->where('close_date',NULL)->first()->cycle}}</td>
                                </tr>
                                <tr>
                                    <td><b>Balance:</b></td>
                                    <td>&#8369; {{number_format($client->loans->where('close_date',NULL)->pluck('balance')->first())}}</td>
                                </tr>
                            </table>
                        @else
                            <div class="divider-text text-primary">
                                    No active loan
                            </div>
                        @endif
                        
                        <div class="divider">
                            <div class="divider-text">
                                    Previous loan
                            </div>
                        </div>
                        <table class="table table-bordered" width='100%'>
                            @foreach($client->loans->where('close_date','<>',NULL)->take(3) as $loan)
                            <tr>
                                <td><b>Principal Amount: </b></td>
                                <td>&#8369; {{number_format($loan->principle_amount)}}</td>
                            </tr>
                            <tr>
                                <td><b>Cycle:</b></td>
                                <td>{{$loan->cycle}}</td>
                            </tr>
                            <tr>
                                <td><b>Date Close:</b></td>
                                <td>{{$loan->close_date}}</td>
                            </tr>
                            <tr height="1px">
                                <td  colspan="2" style="background-color:--var('primary')"></td>
                            </tr>
                            @endforeach
                        </table>
                @else
                    <p>No Active loan</p>

                @endif
                @include('content.loans.create');
            </div>
        </div>
</div>
<script>
    function acctname(){
 	 	var name = document.getElementById("first_name").value;
 	 	var last = document.getElementById("last_name").value;
        var mid = document.getElementById("middle_name").value;
        if(mid!= "")
 	 	    document.getElementById("account_name").value = last+", "+name+" "+mid[0]+".";
        else
            document.getElementById("account_name").value = last+", "+name;
    }
    function updateForm(){
        var form = $('#editProfile').serialize();
         $.ajax({
	         url : "{{route('clients.update',$client->id)}}",
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
</script>
@endsection
