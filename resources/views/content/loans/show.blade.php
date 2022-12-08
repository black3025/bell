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
      $('#tblLoans').DataTable();
    });
  </script>
@endsection

@section('content')
    <h4 class="fw-bold mb-2">
        <span class="text-muted fw-light">Statement of Account</span>
    </h4>
    <div class="row" style="display:flex; justify-content:space-between">
        <div class="card mb-4 col-md-12" >
            <h5 style="display:flex; justify-content:space-between" class="card-header">
                <span> </span>
                <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#addLoan"><i class='bx bx-printer' ></i> Print</button>
            </h5>
            <!-- Account -->
            <div class="card-body">
                @include('content.loans.statement')
            </div>
        </div>
    </div>
   
@endsection
