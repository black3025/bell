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
                <form onsubmit="return postPay()">
                    <div class="card-body">
                            <div class="row mb-2">
                                <label for="lpd" class="col-sm-2 col-form-label">Last Payment Date</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span class="form-control" style="border:none;">{{$payments->max('date')}}</span>
                                        <span id="basic-icon-default-company2" style="border:none;" class="input-group-text text-primary"><i class='bx bx-calendar-check text-primary'></i></span>
                                    </div>
                                </div>
                            </div>
                             @csrf   
                                <div class="row mb-2">
                                    <label for="date" class="col-sm-2 col-form-label">Date</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="date" value="{{date('Y-m-d')}}" id="date">
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
    <<script>
        function postPay() {
            var form = {
                _token: $('input[name=_token]').val(),
                date: $('#date').val(),
                area: $('#area').val(),
                ajax:1
            }
            $.ajax({
	         url : "{{url('payments/pay')}}",
	         data :  form,
	         type : "POST",
	         success : function(msg){
                //console.log(msg['success']);
                // if(msg['success']){
                //     // success(msg['message']);
                //     //console.log(msg['message']);
                //     window.location.replace(msg['message'])
                // }else{
                //     error(msg['message']);
                // }
                window.location.replace(msg);
             }
            })
            return false;
        }
    </script>
@endsection
