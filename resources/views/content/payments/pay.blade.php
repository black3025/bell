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
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">
                    <div style="display:flex; justify-content:space-between">
                        <div>
                            <p>Payment for: <span class="text-primary">{{date('F d, Y', strtotime($date))}}</span></p>
                            <p> Area: {{$area}} </p>
                        </div>
                        <div>
                            <p>Total Amount: <input style="border-style: none; background-color:white; color: black" type="text" disabled class="text-primary" id="total" value="0"></p>
                    <form onsubmit = "return postPay();" id="postForm">
                            <button type="submit" id="btn_post" class="btn btn-primary" value="submit">Post</button>
                        </div>
                    </div>
                </h5>
                <div class="card-body">
                    
                        @csrf
                        <table class="table table-bordered">
                            <thead>
                                <th>Account #</th>
                                <th>Account Name</th>
                                <th>Cycle</th>
                                <th>Due/Day</th>
                                <th>OR number</th>
                                <th>Payment</th>
						    </thead>
                            <tbody>
                                @foreach($loans as $loan)
                                    <tr>
                                        <td>
                                            <input type="text" tabindex="-1" hidden autocomplete="off" id="loan_id" name="loan_id[]" value="{{$loan->id}}">
                                            {{$loan->client->client_id}}
                                        </td>
                                        <td>
                                            {{$loan->client->account_name}}
                                        </td>
                                        <td>
                                            {{$loan->cycle}}
                                        </td>
                                        <td>
                                            {{$loan->principle_amount/100}}
                                        </td>
                                        <td>
                                            <input class="form-control" type="text" id="or" name="or[]"/>
                                        </td>
                                        <td>
                                            <input  class="form-control" required type="text" onkeyup="add()" id="amount" name="amount[]"
                                             value='{{count($loan->payments) >0  ? $loan->payments->pluck('amount')->first() : 0 }}'
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbodY>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function postPay(){
            $('#btn_post').prop('disabled', true);
            var form = {
                _token: $('input[name=_token]').val(),
                loan_id: $("input[name='loan_id[]']").serializeArray(),
                or: $("input[name='or[]']").serializeArray(),
                amount: $("input[name='amount[]']").serializeArray(),
                date: "{{ date('Y-m-d', strtotime($date)) }}",
                ajax: 1
            }
            console.log(form);
            $.ajax({
                url : "{{route('payments.store')}}",
                data :  form,
                type : "POST",
                success : function(msg){
                    console.log(msg['message']);
                    if(msg['success']){
                        success(msg['message']);
                        setTimeout(function(){window.location.href = "{{url('/payments')}}";},1500);
                    }else{
                        error(msg['message']);
                    }
                }
            })
            return false;
        }

        function add(){
            var names = document.getElementsByName('amount[]');
            var x = 0;
			for (var i = 0, iLen = names.length; i < iLen; i++) {
				if(names[i].value!="")
	    			x = x + parseFloat(names[i].value);
	  		}
	  		document.getElementById('total').value = x;
        }
    </script>
@endsection
