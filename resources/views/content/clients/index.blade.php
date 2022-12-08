@extends('layouts/contentNavbarLayout')

@section('title', 'Clients')

@section('page-style')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}"/>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
  <script src="{{asset('assets/js/swal.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
  <script>
    $(document).ready( function () {
      $('#tblClients').DataTable();
    });

    function acctname(){
 	 	var name = document.getElementById("first_name").value;
 	 	var last = document.getElementById("last_name").value;
        var mid = document.getElementById("middle_name").value;
        if(mid!= "")
 	 	    document.getElementById("account_name").value = last+", "+name+" "+mid[0]+".";
        else
            document.getElementById("account_name").value = last+", "+name;
    }
  </script>
@endsection

@section('content')
    <h4 class="fw-bold mb-2">
        <span class="text-muted fw-light">Clients </span>
    </h4>
    <div class="card">
        <h5 class="card-header">
            <div style="display:flex; justify-content: space-between;">
                Clients
                <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="modal" data-bs-target="#addClient">
                <span class="tf-icons bx bx-user-plus"></span>&nbsp; Add new Client
              </button>
            </div>
        </h5>
        <div class="table-responsive" style="margin:15px">
            <table class="table table-hover" id="tblClients">
            <thead>
                <tr>
                    <th>Account Number</th>
                    <th>Account Name</th>
                    <th>Address</th>
                    <th>Area</th>
                    <th>Contact Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($clients as $client)
                    <tr>
                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$client->client_id}}</strong></td>
                        <td>{{$client->account_name}}</td>
                        <td>{{$client->address}}</td>
                        <td>{{$client->area->name}}</td>
                        <td>{{$client->contact_number}}</td>
                        <td>
                            <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ url('/clients/'.$client->id) }}"><i class="bx bx-id-card me-1"></i>Profile</a>
                                <a class="dropdown-item" href="javascript:void(0);" onclick="setForm({{$client->id}}, {{$client->loans->max('cycle')+1}});" data-bs-toggle="modal" data-bs-target="#addLoan"><i class="bx bx-layer-plus me-1"></i>New Loan</a>
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

    <div class="modal fade" id="addClient" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              @include('content.clients.create');
            </div>
    </div>
    
     @include('content.clients.create-loan');
   
@endsection
