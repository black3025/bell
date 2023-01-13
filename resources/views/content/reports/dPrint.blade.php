<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daily Collection Receipt</title>   
    <style>
       @page { margin: 10px; }
        body { margin: 10px; }
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
        <table width="50%">
            <tr>
                <td align="center" style="font-size:1rem; font-weight:bold">
                Daily Collection Receipt
                </td>
            </tr>
            <tr>
                <td align="center">Payment Date: {{ date('F d, Y',strtotime($date)) }}</td>
            </tr>
        </table>
        <br>
        
        <table width="50%">
            <tr><td>Area: <b>{{$area}}</b></td> <td align="right">Collection Date: <b>{{date('Y-m-d')}}</b></td>
        </table>
        <br>
        <table border='0.5' padding='0' width="50%" cellspacing='0'>
            <thead>
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
        <br><br>
    </div>
</body>
</html>