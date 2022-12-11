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
                    <div style="display:flex; justify-content: space-between;" class="mb-3">
                        Payment Details
                    </div>

                    @if($errors != "")
                        <div style="display:flex; justify-content: space-between;">
                            <span class="text-danger">{{$errors}}</span>
                        </div>
                   @endif

                </h5>
                <form method="post" action="\payments\pay">
                    @csrf   
                    <div class="card-body">
                            <div class="row mb-2">
                                <label for="lpd" class="col-sm-2 col-form-label">Last Payment Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-company2" class="input-group-text"><i class='bx bx-calendar-check' ></i></span>
                                        <input type="text" id="lpd" disabled required name="lpd" class="form-control" value = "{{ $lpd ? date('Y-m-d', strtotime($lpd)) : '' }}">
                                    </div>
                                </div>
                            </div>
                                <div class="row mb-2">
                                    <label for="payday" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="date" value="{{date('Y-m-d')}}" id="payday" name="payday">
                                    </div>
                                </div>
                                <div class="row mb-2">                   
                                    <label class="col-sm-2 col-form-label" for="area">Area</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" id="area" name="area" required>
                                            <option selected value="">Choose...</option>
                                            @foreach($areas as $area)
                                                <option value="{{$area['id']}}">{{$area['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" value="submit"><i class='bx bx-calendar-edit'></i> Post</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 order-1">
            <div class="card">
                <h5 class="card-header">
                    <div style="display:flex; justify-content: space-between;">
                        Collectibles
                    </div>
                </h5>

                <div class="card-body">
                    <table>
                      
                    </table>
                </div>
            
            </div>
        </div>
    </div>
@endsection
