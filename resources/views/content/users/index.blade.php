@extends('layouts/contentNavbarLayout')

@section('title', 'Loans')

@section('page-style')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}"/>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
  <script src="{{asset('assets/js/swal.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
  <script>
    $(document).ready( function () {
      $('#tblUser').DataTable();
    });
  </script>
@endsection

@section('content')
    <h4 class="fw-bold mb-2">
        <span class="text-muted fw-light">Loans </span>
    </h4>
    @if($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <span>{{$message}}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
          </button>
        </div>
    @endif
    <div class="card">
        <h5 class="card-header">
            <div style="display:flex; justify-content: space-between;">
                Users
                <button type="button" class="btn rounded-pill btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">
                <span class="tf-icons bx bx-user-plus"></span>&nbsp; Add new user
              </button>
            </div>
        </h5>
        <div class="table-responsive" style="margin:15px">
            <table class="table table-hover" id="tblUser">
            <thead>
                <tr>
                    <th >Username</th>
                    <th >Nick name</th>
                    <th >Full Name</th>                
                    <th >Role</th>
                    <th >Status</th>
                    <th >Control</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($users as $user)
                    <tr>
                        <td>{{$user->username}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->first_name}} {{$user->middle_name}} {{$user->last_name}}</td>
                        <td>{{$user->role->name}}</td>
                        <td>
                            @if($user->is_active == 1)
                                <span class="text-info">Active</span>
                            @else
                                <span class="text-danger">Deactivated</span>
                            @endif
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                    {{--LOAN EXTENSION PROGRAM <a class="dropdown-item" href="{{ url('/loans/'.$loan->id) }}"><i class="bx bx-id-card me-1"></i>Profile</a> --}}
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="resetPW({{$user->id}})""><i class="bx bxs-edit me-1"></i>Reset Password</a>
                                    @if(Auth::user()->role_id ==1)
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="status({{$user->id}})">
                                            @if($user->is_active == 0)
                                                <span class="text-info"><i class='bx bx-caret-up-circle'></i>Activate</span>
                                            @else
                                                <span class="text-danger"><i class="bx bxs-trash-alt me-1"></i>Deactivate</span>
                                            @endif  
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
            <div class="card-footer text-muted">
               
            </div>
        </div>
    </div>

     <!--/ Hoverable Table rows -->

    <div class="modal fade" id="addUser" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              @include('content.users.create');
            </div>
    </div>

   <script>
        function status(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change the status of the user",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url : "{{url('users/status_change/')}}"+"/"+ id,
                    type : "GET",
                    success : function(msg){
                        console.log(msg['message']);
                        if(msg['success']){
                            success(msg['message']);
                            setTimeout(function(){window.location.reload();},1500);
                        }else{
                            error(msg['message']);
                        }
                    }
                })
            }})       
            return false;

        }
        function resetPW(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to change the PASSWORD of the user",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes!'
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                    url : "{{url('users/resetPW/')}}"+"/"+ id,
                    type : "GET",
                    success : function(msg){
                        console.log(msg['message']);
                        if(msg['success']){
                            success(msg['message']);
                            setTimeout(function(){window.location.reload();},1500);
                        }else{
                            error(msg['message']);
                        }
                    }
                })
            }})       
            return false;

        }
   </script>
@endsection
