<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Non- Paying Account</title>   
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
                    Non- Paying Account
                </td>
            </tr>
            <tr>
                <td align="center">Payment Date: {{ date('F d, Y',strtotime($date)) }}</td>
            </tr>
        </table>
       <br>
       
        <table width="100%">
            <tr><td><b>Area: </b>{{$area->name}}</td> <td align="right">Report Generated: {{date('Y-m-d')}}</td>
        </table>
        </b><br><br><br>
        @php $count = 0; $total = 0; @endphp
        <table border='0.5' padding='0' width="100%" cellspacing='0'>
            <thead>
                <tr class="table-danger">
                    <th width="30"><b>No.</b></th>
                        <th width="60"><b>Account No</b></th>
                        <th width="150"><b>Name of Client</b></th>
                        <th width="30"><b>Cycle</b></th>
                        <th width="70"><b>Last Payment Date</b></th>
                        <th width="70"><b>Daily Due</b></th>
                </tr>
            </thead>
            <tbody>
                @foreach($loans ?? ''  as $key=>$loan)
                    <tr>
                        <td align="center">{{$count}}</td>
                        <td align="center">{{$loan->client->client_id}}</td>
                        <td >{{$loan->client->account_name}}</td>
                        <td align="center" >{{$loan->cycle}}</td>
                        <td> {{date('M. d, Y', strtotime($loan->payments->max('date')))}}
                        <td align='right'>P {{number_format($loan->principle_amount*0.01,2)}}</td>
                    </tr>
                @endforeach

                <tr><th colspan='5' align='right'>Total: </th><td align='right'>P {{number_format($loans->sum('principle_amount')*0.01,2)}}</td></tr>

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