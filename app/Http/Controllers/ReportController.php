<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Area;
use App\Models\Loan;
use PDF;
use Auth;

class ReportController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    


    public function index()
    {   
        function getbegin($y, $m, $d)
        {
            if($d >= 1 && $d <= 7)
            {
                return ($y ."-". $m ."-". "1");
            }
            else if($d >= 8 && $d <= 15)
            {
                return ($y ."-". $m ."-". "8");
            }
            else if($d >= 16 && $d <= 23)
            {
                return ($y ."-". $m ."-". "16");
            }
            else if($d >= 24)
            {
                $c = date('t',strtotime($y ."-". $m ."-". "1"));
                return ($y ."-". $m ."-". "24");
            }
            else
            {
                return "0000-00-00";
            }
        }

        function getend($y, $m, $d)
        {
            if($d >= 1 && $d <= 7)
            {
                return ($y ."-". $m ."-". "7");
                
            }
            else if($d >= 8 && $d <= 15)
            {
                return ($y ."-". $m ."-". "15");
            }
            else if($d >= 16 && $d <= 23)
            {
                return ($y ."-". $m ."-". "23");
            }
            else if($d >= 24)
            {
                $bd = date('Y-m-d', strtotime($y ."-". $m ."-". "1"));
                $c = date('t',strtotime($y ."-". $m ."-". "1"));
                return ($y ."-". $m ."-". $c);
            }
            else
            {
                return "";
            }
        }
        $lpd = Payment::max('date');
        $d = date('d',strtotime($lpd));
		$y = date('Y',strtotime($lpd));
		$m = date('m',strtotime($lpd));
		$newdate =getbegin($y,$m, $d);
		$enddate = getend(date('Y',strtotime($newdate)),date('m',strtotime($newdate)),date('d',strtotime($newdate)));
          
        $clients = Client::all(); 
        $areas = Area::all();
        return view('content.reports.index',compact('clients','areas','newdate','enddate'));
    }


 //Note Collection Reports
 public function NCR(Request $request)
 {
    //Note Collection Reports
    function getWeek($y, $m, $d)
    {
        if($d >= 1 && $d <= 7)
        {
            if($m == 1)
            {
                $y = $y - 1;
                $m = 13;
            }
            $m = $m - 1;
            $c = date('t',strtotime($y ."-". $m ."-". "1"));
            return ($y ."-". $m ."-". $c);
        }
        else if($d >= 8 && $d <= 15)
        {
            return ($y ."-". $m ."-". "7");
        }
        else if($d >= 16 && $d <= 23)
        {
            return ($y ."-". $m ."-". "15");
        }
        else if($d >= 24)
        {		
            return ($y ."-". $m ."-". "23");
        }
        else
        {
            return "";
        }
    }
    $begindate = $request->from;
    $enddate = $request->to;

    $ctr = abs(strtotime($begindate) - strtotime($enddate))/86400 + 1;
    $tempdate = $begindate;
    
    $d = date('d',strtotime($begindate));
    $y = date('Y',strtotime($begindate));
    $m = date('m',strtotime($begindate));
    $newdate = getWeek($y,$m, $d);
    $newdate = date('Y-m-d', strtotime($newdate));
    $bd = date('Y-m-d', strtotime($begindate));
    $nd = date('Y-m-d', strtotime($newdate));
    $ed = date('Y-m-d', strtotime($enddate));

    $area = Area::where('id',$request->area)->first();

    $loans = Loan::where('close_date','<=',$nd)
        ->orwhere('balance','>','0')
        ->where('rel_date','<=', $ed)
        ->wherehas('client', function($query) use ($request)
        {
            $query->where('area_id', $request->area);
        })
        ->orderBy(
            Client::select('account_name')
            ->whereColumn('clients.id', 'loans.client_id')
        )->with('payments')
        ->get();
    $payments = Payment::with('loan')->whereBetween('date', array($begindate, $enddate))
                ->wherehas('loan' , function($query) use ($request)
                {
                    $query->wherehas('client', function($query) use ($request)
                    {
                        $query->where('area_id', $request->area);
                    });
                })
                ->get();

    $pdf = PDF::loadView('content.reports.ncr',compact('area','begindate','enddate','loans','payments'))->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->stream('Notes Collection Report',array("Attachment"=>false));
}









    //STATEMENT OF ACCOUNT
    public function soa(Request $request)
    {   
        $loan = Loan::where('client_id',$request->client)->where('cycle',$request->cycle)->first();
        $pdf = PDF:: loadView('content.reports.statement',compact('loan'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('Statement of Account',array("Attachment"=>false));
    }

    //NEW ACCOUNT
    public function newAccount(Request $request)
    {   
        $from =$request->from;
        $to =$request->to;
        $areas = Area::where('is_active',1)->get();
        $loans = Loan::whereBetween('rel_date', array($request->from, $request->to))->get();
        $summary =[];
        //get sum of loans
        foreach($areas as $area)
        {
            $sum = Loan::whereBetween('rel_date', array($request->from, $request->to))
                        ->wherehas('client', function($query) use ($area){
                                $query->where('area_id', $area->id);
                        })->sum('principle_amount');

            array_push($summary , ['area' => $area->name, 'amount'=>$sum, 'rel' => $sum - ($sum * 0.19)]);
        }
        $pdf = PDF:: loadView('content.reports.newaccount',compact('loans','summary','from','to','areas'))->setOptions(['defaultFont' => 'sans-serif']);;
        return $pdf->stream('New Accounts',array("Attachment"=>false));
    }

    
    //NO COLLECTION REPORT
    public function dailyNo(Request $request)
    {   
        $area = Area::find($request->area);
        $loans = Loan::where('rel_date','<=',date('Y-m-d', strtotime($request->from)))
                ->where('balance','>','0')
                ->wherehas('client', function($query) use ($request)
                    {
                        $query->where('area_id', $request->area);
                    })
                ->orderBy(
                    Client::select('account_name')
                            ->whereColumn('clients.id', 'loans.client_id')
                )->wheredoesntHave('payments', function($query) use($request)
                    {
                        $query->where('date',date('Y-m-d', strtotime($request->from)));
                    }
                )
                ->get();

        $date = $request->from;
      
    
        $pdf = PDF:: loadView('content.reports.noPay',compact('area','loans','date',))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('Non Paying Accounts.pdf',array("Attachment"=>false));

    }
    
    //DAILY COLLECTION REPORT
    public function dcrAll(Request $request)
    {   
        $areas = Area::where('is_active',1)->get();
        $payments = Payment::with('loan')->where('date', $request->date)->with('loan')->get();
        $date = $request->date;
        $summary = [];
        // foreach($areas as $area)
        // {
        //     $payments = Payment::where('date', $date)->wherehas('loan', function($query) use ($area)
        //                 {
        //                     $query->wherehas('client', function($query) use ($area){
        //                         $query->where('area_id', $area->id);
        //                     });
        //                 })->get();

        //     array_push($data, array('area'=>$area->name, 'payments'=> array($payments));

        // }
        foreach($areas as $area)
        {
            $sum = Payment::where('date', $date)->wherehas('loan', function($query) use ($area)
                        {
                            $query->wherehas('client', function($query) use ($area){
                                $query->where('area_id', $area->id);
                            });
                        })->sum('amount');
            array_push($summary , ['area' => $area->name, 'amount'=>$sum]);
        }



        $pdf = PDF:: loadView('content.reports.dcr',compact('areas','payments','date', 'summary'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('Daily Collection Reports.pdf',array("Attachment"=>false));

    }


}
