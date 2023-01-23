<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Collection Receipt</title>   
    <style>
       @page { margin-top: 5px; margin-left: 10px}
        body { margin-top: 5px; margin-left: 10px}
        body{
            font-size:0.6rem;
        }
    </style>
</head>
<body>
    <div class="container">
                <table border='0.5' width="45%" cellspacing='0' style="page-break-inside: avoid;">
                    <thead>
                        <tr border="0">
                            <th colspan='5' style="font-size:1rem; font-weight:bold">
                                 Daily Collection Receipt
                            </th>
                        </tr>
                        <tr>
                             <td colspan='5' align="center">Payment Date: {{ date('F d, Y',strtotime($date)) }}</td>
                        </tr>
                        <tr>
                            <td colspan ='3'>Area: <b>{{$area}}</b></td> 
                            <td colspan='2' align="right">Collection Date: <b>{{date('Y-m-d')}}</b>
                        </td>
                        <tr class="table-danger">
                            <th><b>No.</b></th>
                            <th width="50"><b>Account Number</b></th>
                            <th width="100"><b>Name of Client</b></th>
                            <th width="50"><b>Due</b></th>
                            <th width="50" ><b>Amount Paid</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loans as $key=>$loan)
                            <tr>
                                <td>{{$key + 1}}</td>
                                <td>{{$loan->client->client_id}}</td>
                                <td>{{$loan->client->account_name}}</td>
                                <td align ="right">P {{number_format($loan->principle_amount/100,2,'.',',')}}</td>
                                <td> </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
    </div>
</body>
</html>