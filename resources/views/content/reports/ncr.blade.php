<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Collection Report</title>   
    <style>
        .mb-1{
            margin-bottom:1px;
        }
        body{
            font-size:0.8rem;
        }
        table{
            font-size:0.6rem;
        }
        .page_break { page-break-before: always; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <table width="100%">
            <tr>
                <td align="center" style="font-size:1rem; font-weight:bold">
                    New Collection Report
                </td>
            </tr>
            <tr>
                <td align="center">Date: {{ date('F d, Y',strtotime($begindate)) }} to {{ date('F d, Y',strtotime($enddate)) }}</td>
            </tr>
        </table>
       <br>
            <table width="100%">
                <tr><td><b>Area: </b>{{$area->name}}</td> <td align="right">Report Generated: {{date('F d, Y')}}</td>
            </table>
            </b><br>
            <table border='0.5' cellpadding='1' width="100%" cellspacing='0'>
                <thead>
                    <tr class="table-danger">
                        <th width="35"><b>Acct#</b></th>
                        <th width="90"><b>Account Name</b></th>
                        <th width="10"><b>#</b></th>
                        @for($day = $begindate; $day <= $enddate; $day++ )
                            <th width="35"><b>{{date('d',strtotime($day))}}</b></th>
                        @endfor
                        <th width="35"><b>Total</b></th>
                        <th width="40"><b>D</b></th>
                         <th width="40"><b>CD</b></th>
                        <th width="32"><b>O</b></th>
                        <th width="40"><b>D+O</b></th>
                        <th width="35"><b>CB</b></th>
                        <th width="32"><b>DAILY</b></th>
                        <th width="32"><b>MD</b></th>
                        <th width="32"><b>LPD</b></th>
                        <th width="15"><b>RD</b></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandadvance=0;
                        $granddue = 0;
                        $grandoverdue = 0;
                        $grandcoll = 0;
                        $grandbalance = 0;
                        $grandAM = 0;
                    @endphp

                    @foreach($loans as $loan )
                        {{-- Computaions and setting of vairables --}}
                        @php
                             $daily = $loan->principle_amount * 0.01;
                            //total for every payments before the enddate
                             $tpay = $loan->payments->where('date','<=',$enddate)->sum('amount');
                    

                            //days
                            $daycount = 100 - round((strtotime($enddate) - strtotime($loan->rel_date))/86400);
                            
                            //total for all the NCR inclusive dates
                             $total = $loan->payments->whereBetween('date',array($begindate,$enddate))->sum('amount');

                            if($daycount > 100)
                                $daycount = 100;

                            $count = round(abs(strtotime($nd) - strtotime($loan->rel_date))/86400);
                            
                            //computing of due
                            if($loan->rel_date >= $begindate && $loan->rel_date <= $enddate)
                                $due = round(abs(strtotime($loan->rel_date) - strtotime($enddate))/86400) * $daily;
                            elseif($loan->end_date <= $enddate && $loan->end_date >= $begindate)
                                $due = round(abs(strtotime($loan->end_date) - strtotime($begindate))/86400) * $daily;
                            else
                                $due = round(abs(strtotime($begindate) - strtotime($enddate))/86400 +1) * $daily;
                            
                            if($loan->end_date < $begindate || $loan->rel_date > $enddate)
                                $due = 0;


                            // begin computing the overdue
                            $totalpayment=$loan->payments->where('date','<',$begindate)->sum('amount');
                            if($count >= 100)
                                $count = 100;
                            
                            if($loan->rel_date >= $begindate || ($loan->rel_date >= $begindate && $loan->rel_date <= $enddate))
                                $overdue = 0;
                            else	
                                $overdue = ($daily * $count) - $totalpayment;
                            
                            if($overdue <= 0)
                            {
                                $due = $due + $overdue;
                                if($due <= 0)
                                    $due = 0;
                                $overdue = 0;
                            }

                            //computing the current balance
                            //$tpay = $loan->payments->where('date','<=',$enddate)->sum('amount');	
                            $balance = $loan->principle_amount - $tpay;

                            //collectibles
			                $collectibles = $due + $overdue - $total;
                            if($collectibles < 0)
                                $collectibles = 0;

                            $advance = $total - $overdue - $due;

                            if($advance <= 0)
                                $advance = 0; 

                            if($balance < 0)
                                  $balance = 0;

                            $grandadvance += $advance;
                            $grandoverdue += $overdue;
                            $granddue += $due;  
                            $grandbalance += $balance;
                            $grandcoll += $collectibles; 
                            $grandAM += $daily;  
                        @endphp
                        <tr>
                            <td>{{$loan->client->client_id}}</td>
                            <td>{{$loan->client->account_name}}</td>
                            <td align="center">{{$loan->cycle}}</td>
                            @for($day = $begindate; $day <= $enddate; $day++ )
                            
                                <td align="right">
                                    @php $data = $loan->payments->where('date',$day)->pluck('amount')->first();  $sum = 0;@endphp
                                    @if($data)
                                        {{ number_format( $data )}}
                                    @else
                                        0                                     
                                    @endif
                                </td>
                            @endfor
                            <td align="right">
                                {{number_format($total)}}
                            </td>
                            <td align="right">
                                {{number_format($due)}}
                            </td>
                             <td align="right">
                                @if($due-$total < 0)
                                    0
                                @else
                                    {{number_format($due-$total)}}
                                @endif
                            </td>
                            <td align="right">{{number_format($overdue)}}</td>
                            <td align="right">{{number_format($due + $overdue)}}</td>
                            <td align="right">{{number_format($balance)}}</td>
                            <td width="32" align="right">{{number_format($daily)}}</td>
                            <td align="right">
                                {{date('m-d-y', strtotime($loan->end_date)) }}
                            </td>
                            <td align="right">
                                @if($loan->payments->max('date'))
                                    {{date('m-d-y',strtotime($loan->payments->max('date'))) }}
                      
                                @endif
                            </td>
                            <td align="right">{{$daycount}}</td>
                        </tr>
                    @endforeach
                        <tr style="font-weight:bold">
                            <td>Count: {{$loans->count() }}</td>
                            <td align="center" colspan="2">Total: </td>
                            @for($day = $begindate; $day <= $enddate; $day++)
                                <td align="right">
                                   {{$payments->where('date', $day)->sum('amount')}}
                                </td>
                            @endfor
                            <td align="right">{{number_format($payments->sum('amount'))}}</td>
                            <td align="right">{{number_format($granddue)}}</td>
                            <td align="right">
                                @if($granddue - $payments->sum('amount') < 0)
                                    0
                                @else
                                    {{number_format($granddue - $payments->sum('amount'))}}
                                @endif
                            </td>
                            <td align="right">{{number_format($grandoverdue)}}</td>
                            <td align="right">{{number_format($granddue + $grandoverdue)}}</td>
                            <td align="right">{{number_format($grandbalance)}}</td>
                            <td align="right">{{number_format($grandAM)}}</td>
                            <td align="right" colspan="3"> </td>
                        </tr>                
                </tbody>
            </table>
            
            <br><br>PREVIOUS BALANCE: P {{number_format($grandprev,2,'.',',')}}
            <br>BEGINNING BALANCE: P {{number_format($begbalance,2)}}
            <br>NEW ACCOUNT: P {{number_format($newacct,2,'.',',')}}
            <br>NO. OF NEW ACCOUNT: {{$newacctCount}}
            <br><br>COLLECTION PERFORMANCE: 
                            @if( ( $granddue + $grandoverdue)!=0 ){{($payments->sum('amount') / ($granddue + $grandoverdue)) *100}} %
                            @else
                                N/A
                            @endif
            <br>(1%) : P {{number_format($grandcoll * 0.01, 2,'.',',')}}

            <br><br>

        <p>Report Generated by:</p>

        <br>
        <p><u>{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}</u></p>
        {{Auth::user()->role->name}} 
    </div>
</body>
</html>