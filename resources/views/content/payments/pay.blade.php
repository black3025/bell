@extends('layouts/contentNavbarLayout')

@section('title', 'Payments')

@section('page-style')
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}"/>
@endsection

@section('page-script')
  <script src="{{asset('assets/js/sweetalert2.all.min.js')}}"></script>
  <script src="{{asset('assets/js/swal.js')}}"></script>
  <script type="text/javascript" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
@endsection

@section('content')
    <h4 class="fw-bold mb-2">
        <span class="text-muted fw-light">Payments </span>
    </h4>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <h5 class="card-header">
                    <div style="display:flex; justify-content: space-between;">
                        Payment Details
                    </div>
                </h5>
                <div>Tables here</div>
            </div>
        </div>
    </div>
@endsection
