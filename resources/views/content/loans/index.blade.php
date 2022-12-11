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
                Loans
                {{-- <button type="button" class="btn rounded-pill btn-warning" data-bs-toggle="modal" data-bs-target="#addClient"> --}}
                {{-- <span class="tf-icons bx bx-user-plus"></span>&nbsp; Add new Client --}}
              </button>
            </div>
        </h5>
        <div class="table-responsive" style="margin:15px">
            <table class="table table-hover" id="tblLoans">
            <thead>
                <tr>
                    <th >Account Name</th>
                    <th >Area</th>
                    <th >Cycle</th>
                    <th >Principle Amount</th>
                    <th >Release Date</th>                    
                    <th >Maturity Date</th>
                    <th >Balance</th>
                    <th >Control</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach($loans as $loan)
                    <tr>
                        <td>{{$loan->client->account_name}}</td>
                        <td>{{$loan->client->area->name}}</td>
                        <td>{{$loan->cycle}}</td>
                        <td>&#8369; {{number_format($loan->principle_amount,2)}}</td>
                        <td>{{date('F d, Y',strtotime($loan->rel_date))}}</td>
                        <td>{{date('F d, Y',strtotime($loan->end_date))}}</td>
                        <td>&#8369; {{number_format($loan->balance,2)}}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                <div class="dropdown-menu">
                                @if(Auth::user()->role_id ==1)
                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editLoan" onclick="editLoan({{$loan}})">
                                                <i class='bx bx-edit'></i>Edit
                                            </a>
                                @endif
                                    {{--LOAN EXTENSION PROGRAM <a class="dropdown-item" href="{{ url('/loans/'.$loan->id) }}"><i class="bx bx-id-card me-1"></i>Profile</a> --}}
                                    <a class="dropdown-item" href="{{ url('/loans/'.$loan->id) }}"><i class="bx bx-receipt me-1"></i>Statement of Account</a>
                                    @if(Auth::user()->role_id ==1)
                                        <a class="dropdown-item" href="javascript:void(0);"><i class="bx bxs-trash-alt me-1"></i>Delete Loan</a>
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

    <div class="modal fade" id="editLoan" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                @include('content.loans.update');
            </div>
    </div>

    <script>
        function editLoan(loan)
        {
            $('#Uid').val(loan['id']);
            $('#Uprinciple_amount').val(loan['principle_amount']);
            $('#Ucycle').val(loan['cycle']);
        }
    </script>
   
@endsection
