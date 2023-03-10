<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Target Performance</title>   
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
                    Target Performance
                </td>
            </tr>
            <tr>
                <td align="center">
                    Date: {{ date('F d, Y',strtotime($begindate)) }} to {{ date('F d, Y',strtotime($enddate)) }}
                    <br>
                    Report Generated1: {{ date('F d, Y') }} 
                </td>
            </tr>
        </table>
       <br>
            <table width="100%">
                
            </table>
            </b><br>
            <table border='0.5'  width="100%" cellspacing='0'>
                <thead>
                    <th width="55"><b>Area</b></th>
                    <th width="100"><b>Due</b></th>
                    <th width="100"><b>Overdue</b></th>
                    <th width="100"><b>DUE+OD</b></th>
                    <th width="100"><b>Payment for DUE+OD</b></th>
                    <th width="100"><b>Payment for ADVANCE</b></th>
                    <th width="100"><b>( % )</b></th>
                    <th width="100"><b>Total Collection</b></th>
                </thead>
                <tbody>
                    @foreach($areas as $key=>$area)
                        <tr align = "right">
                            <td align="left">{{$area->name}}</td>
                            <td>P {{number_format($output[$key]['due'])}}</td>
                            <td>P {{number_format($output[$key]['overdue'])}}</td>
                            <td>P {{number_format($output[$key]['dueplusod'])}}</td>
                            <td>P {{number_format($output[$key]['payment'])}}</td>
                            <td>P {{number_format($output[$key]['Apayment'])}}</td>
                            <td>{{number_format($output[$key]['percent'],3)}}%</td>
                            <td>P {{number_format($output[$key]['total'])}}</td>
                        </tr>
                    @endforeach
                    <tr align = "right">
                            <td>Reg.Area Total</td>
                            <td>P {{number_format($t_output[0]['due'])}}</td>
                            <td>P {{number_format($t_output[0]['overdue'])}}</td>
                            <td>P {{number_format($t_output[0]['dueplusod'])}}</td>
                            <td>P {{number_format($t_output[0]['payment'])}}</td>
                            <td>P {{number_format($t_output[0]['Apayment'])}}</td>
                            <td>{{number_format($t_output[0]['percent'],3)}}%</td>
                            <td>P {{number_format($t_output[0]['total'])}}</td>
                    </tr>
                     <tr align = "right" style="font-weight:bold;">
                            <td>Grand Total</td>
                            <td>P {{number_format($g_output[0]['due'])}}</td>
                            <td>P {{number_format($g_output[0]['overdue'])}}</td>
                            <td>P {{number_format($g_output[0]['dueplusod'])}}</td>
                            <td>P {{number_format($g_output[0]['payment'])}}</td>
                            <td>P {{number_format($g_output[0]['Apayment'])}}</td>
                            <td>{{number_format($g_output[0]['percent'],3)}} %</td>
                            <td>P {{number_format($g_output[0]['total'])}}</td>
                    </tr>
                </tbody>
            </table>


    <br>
    <br>
            <p>Report Generated by:</p>

            <br>
            <p><u>{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}</u></p>
            {{Auth::user()->role->name}} 
        </div>
  </body>
</html>
