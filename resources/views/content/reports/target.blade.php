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
                <td align="center">Date: {{ date('F d, Y',strtotime($begindate)) }} to {{ date('F d, Y',strtotime($enddate)) }}</td>
            </tr>
        </table>
       <br>
            <table width="100%">
                
            </table>
            </b><br>
            <table border='0.5' padding='0.2' width="100%" cellspacing='0'>
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
                    @foreach($areas as $area)
                        <tr>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                            <td>{{$area->name}}</td>
                        </tr>
                    @endforeach
                    <tr>
                            <td>Total</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                    </tr>
                </tbody>
            </table>
    </div>
  </body>
</html>
