<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Statement of Account</title>   
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
        <table width="100%">
            <tr>
                <td align="center" style="font-size:1rem; font-weight:bold">
                    Statement of Account
                </td>
            </tr>
        </table>
       <br>

       @if($loan)
                <table width="100%">
                    <tr><td> </td> <td align="right">Report Generated: <b>{{date('F d, Y')}}</b><br><br><br><br><br><br></td>
                    <tr>
                        <td><b>Account no:</b> {{$loan->client->client_id}}</td>
                        <td><b>Principal Amount: </b> P {{number_format($loan->principle_amount,2)}}</td>
                    </tr>
                    <tr>
                        <td><b>Account name: </b> {{Str::upper($loan->client->account_name)}}</td>
                        <td><b>Release Date: </b> {{date('F d, Y',strtotime($loan->rel_date,2))}}</td>
                    </tr>
                    <tr>
                        <td><b>Area:</b> {{Str::upper($loan->client->area->name)}} </td>
                        <td><b>Maturity Date: </b> {{date('F d, Y',strtotime($loan->end_date))}}</td>
                    </tr>
                    <tr>
                        <td><b>Loan Cycle:</b> {{Str::upper($loan->cycle)}}</td>
                        <td><b>Close Date: </b> 
                            @if($loan->close_date=="")
                               
                            @else
                                {{date('F d, Y',strtotime($loan->close_date))}}
                            @endif
                        </td>
                    </tr>
                </table>
                <br>
                <table border='0.5' padding='0' width="100%" cellspacing='0'>
                        <tr>
                            <th width="30"><b>No</b></th>
                            <th width="180"><b>Date of Payment</b></th>
                            <th width="70"><b>OR #</b></th>
                            <th width="70"><b>Amount</b></th>
                        </tr>
                        
                        @if( count($loan->payments) > 0)
                            @foreach ($loan->payments as $key=>$payment)
                            <tr>
                                <td>{{$key +1}}</td>
                                <td>{{date('F d, Y', strtotime($payment->date))}}</td>
                                <td>{{$payment->or_number}}</td>
                                <td align="right">P {{number_format($payment->amount,2)}}</td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" align="center">---- No payments made ----</td>
                            </tr>
                        @endif
                        <tr>
                            <td colspan="3"><b>Total Payment:</b></td>
                            <td align="right">P {{number_format($loan->payments->sum('amount'),2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="3"><b>Balance:</b></td>
                            <td align="right">P {{number_format($loan->principle_amount - $loan->payments->sum('amount'),2)}}</td>
                        </tr>
                </table>
                <br><br>
        @else
            <h3 align="center">Client has no loan with that cycle.</h3>
        @endif
        <p>Report Generated by:</p>

        <br>
        <p><u>{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}</u></p>
        {{Auth::user()->role->name}} 
</body>
</html>
