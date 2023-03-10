<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Collection Report</title>   
    <style>
        .mb-1{
            margin-bottom:1px;
        }
        body{
            font-size:0.8rem;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <table width="100%">
            <tr>
                <td align="center" style="font-size:1rem; font-weight:bold">
                    Daily Collection Report
                </td>
            </tr>
            <tr>
                <td align="center">Payment Date: {{ date('F d, Y',strtotime($date)) }}</td>
            </tr>
        </table>
       <br>
        @foreach ($areas->sortby('category')->sortBy('name') as $area)
            <table width="100%">
                <tr><td><b>Area: </b>{{$area->name}}</td> <td align="right">Report Generated: {{date('Y-m-d')}}</td>
            </table>
            </b><br><br><br>
            @php $count = 0; $total = 0; @endphp
            <table border='0.5' padding='0' width="100%" cellspacing='0'>
                <thead>
                    <tr class="table-danger">
                        <th width="30"><b>No.</b></th>
                        <th width="100"><b>Account Number</b></th>
                        <th width="150"><b>Name of Client</b></th>
                        <th width="30"><b>Cycle</b></th>
                        <th width="30"><b>OR No.</b></th>
                        <th width="100"><b>Amount</b></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments ?? ''  as $key=>$payment)
                        @if($payment->loan->client->area_id == $area->id)
                            @php $count++; $total+=$payment->amount; @endphp
                            <tr>
                                <td align="center">{{$count}}</td>
                                <td align="center">{{$payment->loan->client->client_id}}</td>
                                <td >{{$payment->loan->client->account_name}}</td>
                                <td align="center" >{{$payment->loan->cycle}}</td>
                                <td >{{$payment->or}}</td>
                                <td  align='right'>P {{number_format($payment->amount,2)}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @if($count == 0)  
                        <tr><td colspan='6' align='center'>No payments recorded.</td></tr>
                    @else
                        <tr><th colspan='5' align='right'>Total: </th><td align='right'>P {{number_format($total,2)}}</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="page_break"></div>
        @endforeach

        <b>Collection Summary Report</b><br><br>
        <table border='0.5' width="50%" padding='0' cellspacing='0'>
            <thead>
                <tr>
                    <th>Area</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $summaryTotal = 0; @endphp
                @foreach ($summary as $data) 
                    <tr>
                        <td>{{$data['area']}}</td>
                        <td align="right">P {{number_format($data['amount'],2)}}</td>
                        @php $summaryTotal += $data['amount']; @endphp
                    </tr>

                @endforeach
                <tr>
                    <th>Total: </th><td align="right">P {{number_format($summaryTotal,2)}}</td>
                </tr>
            </tbody>
        </table>
        <br><br>

        <p>Report Generated by:</p>

        <br>
        <p><u>{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}</u></p>
        {{Auth::user()->role->name}} 
    </div>
</body>
</html>