@extends('layouts/contentNavbarLayout')

@section('title', 'Reports - Index')

@section('page-script')
    <script src="{{asset('assets/js/pages-account-settings-account.js')}}"></script>
    <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('assets/js/swal.js')}}"></script>
@endsection

@section('content')
  <h4 class="fw-bold py-3 mb-4">
    <span class="text-muted fw-light">Reports </span> 
  </h4>

  <div style="display:flex; justify-content:space-between" id="main">
          <div class="card mb-4 col-md-5" >
              <h5 style="display:flex; justify-content:space-between" class="card-header">
                      REPORT LIST
              </h5>
              <div class="card-body">
              <a class="dropdown-item" href="javascript:void(0);" onclick="dcr()">Daily Collection Report</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="soa({{$clients}})">Statement of Account</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="newAcct()">New Accounts</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="npcr({{$areas}})">Non Paying</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="ncr({{$areas}})">Notes Collection Report (NCR)</a>
              <a class="dropdown-item" href="javascript:void(0);" onclick="targetP()">Target Performance</a>
              </div>
          </div>
        
        
  </div>
<script>
    function dcr()
    {
      $('#appending').remove();
      $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>Daily Collection Report</h5><div id='apbody' class='card-body'></div></div>");
      $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/daily'></form>");
      $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'><div class='row mb-2'><label for='date' class='col-sm-2 col-form-label'>Date</label><div class='col-sm-10'><input value='{{date('Y-m-d')}}' class='form-control' required type='date' name='date' id='date'/></div></div>");
      $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }

    function soa(clients)
    {
      $('#appending').remove();
      $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>Statement of Account</h5><div id='apbody' class='card-body'></div></div>");
      $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/SOA'></form>");
      $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'>");
      $('#apForm').append("<div class='row mb-2'><label for='client' class='col-sm-2 col-form-label'>Client Name: </label><div class='col-sm-10'><select class='form-control'required name='client' id='client'><option value=''>Select Client</option></select></div></div>");

      for(i=0; i<clients.length; i++)
      {
          $('#client').append('<option value='+ clients[i]['id'] +'>'+ clients[i]['account_name'] +'</option>');
      }
      $('#apForm').append("<div class='row mb-2'><label for='cycle' class='col-sm-2 col-form-label'>Cycle: </label><div class='col-sm-10'><input class='form-control' required name='cycle' id='cycle' type='number' min='1'></div></div>");
      $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }

    function newAcct()
    {
      $('#appending').remove();
      $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>New Accounts</h5><div id='apbody' class='card-body'></div></div>");
      $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/newAccount'></form>");
      $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'>");
      $('#apForm').append("<div class='row mb-2'><label for='from' class='col-sm-2 col-form-label'>From</label><div class='col-sm-10'><input value='{{date('Y-m-d')}}' class='form-control' required type='date' name='from' id='from'/></div></div>");
      $('#apForm').append("<div class='row mb-2'><label for='to' class='col-sm-2 col-form-label'>To</label><div class='col-sm-10'><input class='form-control' required type='date' name='to' id='to'/></div></div>");
    
      $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }

    function npcr(areas)
    {
      $('#appending').remove();
      $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>Non paying Accounts</h5><div id='apbody' class='card-body'></div></div>");
      $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/dailyNo'></form>");
      $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'>");
      $('#apForm').append("<div class='row mb-2'><label for='from' class='col-sm-2 col-form-label'>From</label><div class='col-sm-10'><input value='{{date('Y-m-d')}}' class='form-control' required type='date' name='from' id='from'/></div></div>");
      $('#apForm').append("<div class='row mb-2'><label for='area' class='col-sm-2 col-form-label'>Area: </label><div class='col-sm-10'><select class='form-control'required name='area' id='area'><option value=''>Select Area</option></select></div></div>");

      for(i=0; i<areas.length; i++)
      {
          $('#area').append('<option value='+ areas[i]['id'] +'>'+ areas[i]['name'] +'</option>');
      }
      $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }

    function ncr(areas)
    {
        $('#appending').remove();
        $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>Notes Collection Report</h5><div id='apbody' class='card-body'></div></div>");
        $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/ncr'></form>");
        $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'>");
        $('#apForm').append("<div class='row mb-2'><label for='from' class='col-sm-2 col-form-label'>From</label><div class='col-sm-10'><input value='{{date('Y-m-d',strtotime($newdate))}}' {{Auth::user()->role->id > 1 ? 'disabled' : ''}} class='form-control' required type='date' name='from' id='from'/></div></div>");
        $('#apForm').append("<div class='row mb-2'><label for='to' class='col-sm-2 col-form-label'>To</label><div class='col-sm-10'><input class='form-control' required type='date' name='to' {{Auth::user()->role->id > 1 ? 'disabled' : ''}} value='{{date('Y-m-d',strtotime($enddate))}}' id='to'/></div></div>");
        $('#apForm').append("<div class='row mb-2'><label for='area' class='col-sm-2 col-form-label'>Area: </label><div class='col-sm-10'><select class='form-control'required name='area' id='area'><option value=''>Select Area</option></select></div></div>");

          for(i=0; i<areas.length; i++)
          {
              $('#area').append('<option value='+ areas[i]['id'] +'>'+ areas[i]['name'] +'</option>');
          }

        $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }

    function ncr(areas)
    {
        $('#appending').remove();
        $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>Notes Collection Report</h5><div id='apbody' class='card-body'></div></div>");
        $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/ncr'></form>");
        $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'>");
        $('#apForm').append("<div class='row mb-2'><label for='from' class='col-sm-2 col-form-label'>From</label><div class='col-sm-10'><input value='{{date('Y-m-d',strtotime($newdate))}}' {{Auth::user()->role->id > 1 ? 'disabled' : ''}} class='form-control' required type='date' name='from' id='from'/></div></div>");
        $('#apForm').append("<div class='row mb-2'><label for='to' class='col-sm-2 col-form-label'>To</label><div class='col-sm-10'><input class='form-control' required type='date' name='to' {{Auth::user()->role->id > 1 ? 'disabled' : ''}} value='{{date('Y-m-d',strtotime($enddate))}}' id='to'/></div></div>");
        $('#apForm').append("<div class='row mb-2'><label for='area' class='col-sm-2 col-form-label'>Area: </label><div class='col-sm-10'><select class='form-control'required name='area' id='area'><option value=''>Select Area</option></select></div></div>");

          for(i=0; i<areas.length; i++)
          {
              $('#area').append('<option value='+ areas[i]['id'] +'>'+ areas[i]['name'] +'</option>');
          }

        $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }

    function targetP()
    {
        $('#appending').remove();
        $('#main').append("<div id='appending' class='card mb-4 col-md-6' ><h5 style='display:flex; justify-content:space-between' class='card-header'>Target Performance</h5><div id='apbody' class='card-body'></div></div>");
        $('#apbody').append("<form target='_blank' id='apForm' method='POST' action='/report/targetPerformance'></form>");
        $('#apForm').append("<input type='hidden' name='_token' value='{{ csrf_token() }}'>");
        $('#apForm').append("<div class='row mb-2'><label for='from' class='col-sm-2 col-form-label'>From</label><div class='col-sm-10'><input value='{{date('Y-m-d',strtotime($newdate))}}' {{Auth::user()->role->id > 1 ? 'disabled' : ''}} class='form-control' required type='date' name='from' id='from'/></div></div>");
        $('#apForm').append("<div class='row mb-2'><label for='to' class='col-sm-2 col-form-label'>To</label><div class='col-sm-10'><input class='form-control' required type='date' name='to' {{Auth::user()->role->id > 1 ? 'disabled' : ''}} value='{{date('Y-m-d',strtotime($enddate))}}' id='to'/></div></div>");
        $('#apForm').append("<div class='modal-footer'><button class='btn btn-primary' type='submit'>Generate</button></div>");
    }



</script>
@endsection