<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Area;
use App\Models\Loan;
use App\Models\Prevbal;
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


 //New Collection Reports
 public function NCR(Request $request)
 {
    //New Collection Reports
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

    $loans = Loan::where(function($query) use ($nd){
                $query->where('close_date','>=',$nd)->orwhere('balance','>','0');
        })
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
                
    //getting the new account
    $newacct = Loan::whereHas('client',function($query) use($request)
                            { $query->where('area_id',$request->area); })
                ->whereBetween('rel_date', array($bd,$ed))->sum('principle_amount');
    $newacctCount = Loan::whereHas('client',function($query) use($request)
                { $query->where('area_id',$request->area); })
    ->whereBetween('rel_date', array($bd,$ed))->count();

    $Tpayments = $payments->sum('amount');    
    
    $grandbalance = $loans->sum('principle_amount') - $Tpayments;



    //getting the previous balance
    $grandprev =  Prevbal::where('date',$nd)->where('area',$request->area)->pluck('amount')->first();
    $prevdate = 0;
    $qprevtemp = Prevbal::where('date',$ed)->where('area',$request->area)->pluck('id')->first();
    if($qprevtemp != 0){
        Prevbal::where('id',$qprevtemp)
            ->update([
                'amount' => $grandbalance,
            ]);
    }
    else{
        Prevbal::create([
            'area' => $request->area,
            'date' => $ed,
            'amount' => $grandbalance,
            ]);
    }

    $begbalance = $newacct + $grandprev;
    
    //end of getting the previous balance	
    
    $pdf = PDF::loadView('content.reports.ncr',compact('area','begindate','enddate','loans','payments','newacct','newacctCount','nd','grandprev','begbalance','grandbalance'))->setPaper('legal', 'landscape')->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->stream('New Collection Report.pdf',array("Attachment"=>false));
}

//daily Print
public function dailyPrint(Request $request)
{
    $date = $request->date;
    $area = Area::where('id',$request->area)->pluck('name')->first();

    $loans = Loan::where('rel_date','<=',date('Y-m-d', strtotime($request->date)))
                ->where('balance','>','0')
                ->wherehas('client', function($query) use ($request)
                    {
                        $query->where('area_id', $request->area);
                    })
                ->orderBy(
                    Client::select('account_name')
                            ->whereColumn('clients.id', 'loans.client_id')
                )->with('payments', function($query) use($request)
                    {
                        $query->where('date',date('Y-m-d', strtotime($request->date)));
                    }
                )
                ->get();
    $pdf = PDF::loadView('content.reports.dPrint',compact('loans','area','date'))->setPaper('Folio')->setOptions(['defaultFont' => 'sans-serif']);
    return $pdf->stream('Collection Printable.pdf',array("Attachment"=>false));
}






    //STATEMENT OF ACCOUNT
    public function soa(Request $request)
    {   
        $loan = Loan::where('client_id',$request->client)->where('cycle',$request->cycle)->first();
        $pdf = PDF:: loadView('content.reports.statement',compact('loan'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('Statement of Account.pdf',array("Attachment"=>false));
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
        return $pdf->stream('New Accounts.pdf',array("Attachment"=>false));
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


     //TARGET PERFORMANCE
    public function targetPerformance(Request $request)
    {
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
        

        $t_due = 0;
        $t_overdue = 0;
        $t_dueplusod = 0;
        $t_payment = 0;
        $t_paymentAdvance = 0;
        $t_percent = 0;
        $t_total = 0;

        $g_due = 0;
        $g_overdue = 0;
        $g_dueplusod = 0;
        $g_payment = 0;
        $g_paymentAdvance = 0;
        $g_percent = 0;
        $g_total = 0;

        $begindate=$request->from;
        $enddate=$request->to;

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
        $output = [];
        $t_output =[];
        $g_output = [];

        $due = 0;
        $overdue = 0;
        $dueplusod = 0;
        $payment = 0;
        $advance = 0;
        $percent = 0;
        $total = 0;

        $areas = Area::where('is_active','1')->orderby('category','asc')->orderby('name','asc')->get();
        
        foreach($areas as $area)
        {
            $grandtotal = 0;
            $granddue = 0;
            $grandoverdue = 0;
            $grandadvance = 0; 
            $grandbalance = 0; 
            $dueplusod = 0;
            $percent = 0;
            
            $loans = Loan::where(function($query) use ($nd){
                            $query->where('close_date','>=',$nd)->orwhere('balance','>','0');
                    })
                    ->where('rel_date','<=', $ed)
                    ->wherehas('client', function($query) use ($area)
                    {
                        $query->where('area_id', $area->id);
                    })
                    ->orderBy(
                        Client::select('account_name')
                        ->whereColumn('clients.id', 'loans.client_id')
                    )->with('payments')
                    ->get();

            foreach($loans as $loan)
            {
                
                $reldate = $loan->rel_date;
                $enddate = $loan->end_date;
                $daily = $loan->principle_amount * 0.01;
                $pamount = $loan->principle_amount;
                $daycount = 100 - round((strtotime($ed) - strtotime($reldate))/86400);
                
                if($daycount > 100)
                    $daycount = 100;
                    
                $count = round(abs(strtotime($nd) - strtotime($reldate))/86400);

                              
                //total for all the TP inclusive dates
                $total=$loan->payments->whereBetween('date',array($bd,$ed))->sum('amount');

                $grandbalance += ($pamount - $loan->payments->sum('amount'));
                
                $grandtotal += $total;
                
                $totalpayment = 0;
                $advance = 0;
                $overdue = 0;
                //computing of due
                if($reldate >= $bd && $reldate <= $ed)
                    $due = (round(abs(strtotime($reldate) - strtotime($ed))/86400) * $daily);    
                elseif($enddate <= $ed && $enddate >= $bd )
                    $due = (round(abs(strtotime($enddate) - strtotime($bd))/86400) * $daily);
                else 
                    $due = (round(abs(strtotime($bd) - strtotime($ed))/86400 + 1) * $daily);
                
                if($loan->end_date < $begindate || $loan->rel_date > $enddate)
                    $due = 0;
                
                //overdue
                $totalpayment = $loan->payments->where('date','<=',$nd)->sum('amount');
                if($count >= 100)
                    $count = 100;
                
                if($reldate >= $begindate || ($reldate >= $begindate && $reldate <= $enddate))
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

                $advance = $total - $overdue - $due;
                if($advance <= 0)
                    $advance = 0;

                $grandadvance += $advance;
                $grandoverdue += $overdue;
                $granddue += $due;
            }
            
            $dueplusod = $grandtotal - $grandadvance;

            if($dueplusod <= 0){
                $dueplusod = 0;
            }
            
            if(($granddue + $grandoverdue) == 0 ){
                $percent = 0;
            }
            else {
                $percent = ($dueplusod) / ($granddue + $grandoverdue) * 100;
            }

            if($area->category == 1)
            {
                $t_due = $t_due + $granddue;
                $t_overdue = $t_overdue + $grandoverdue;
                $t_dueplusod = $t_dueplusod + ($grandoverdue + $granddue);
                $t_payment = $t_payment+ $dueplusod;
                $t_paymentAdvance = $t_paymentAdvance+ $grandadvance;
                $t_total = $t_total + $grandtotal;
            }

            $g_due = $g_due + $granddue;
            $g_overdue = $g_overdue + $grandoverdue;
            $g_dueplusod = $g_dueplusod + ($grandoverdue + $granddue);
            $g_payment = $g_payment + $dueplusod;
            $g_paymentAdvance = $g_paymentAdvance + $grandadvance;
            $g_total = $g_total + $grandtotal;

            array_push($output, [
                        "area"=>$area->name,
                        "due"=>$granddue, 
                        "overdue"=>$grandoverdue, 
                        "dueplusod" =>$grandoverdue + $granddue, 
                        "payment"=>$dueplusod, 
                        "Apayment"=>$grandadvance, 
                        "percent"=>$percent, 
                        "total"=>$grandtotal
            ]);
        }

        //compute percent for Regular Area
        if(($t_due + $t_overdue) == 0 )
            $t_percent = 0;
        else 
            $t_percent = ($t_payment) / ($t_due + $t_overdue) * 100;
        array_push($t_output,[
            "due"=>$t_due, 
            "overdue"=>$t_overdue, 
            "dueplusod" =>$t_dueplusod, 
            "payment"=>$t_payment, 
            "Apayment"=>$t_paymentAdvance, 
            "percent"=>$t_percent, 
            "total"=>$t_total
        ]);

         //compute percent for Regular + Special Area
         if(($g_due + $g_overdue) == 0 )
            $g_percent = 0;
        else 
             $g_percent = ($g_payment) / ($g_due + $g_overdue) * 100;
        array_push($g_output,[
            "due"=>$g_due, 
            "overdue"=>$g_overdue, 
            "dueplusod" =>$g_dueplusod, 
            "payment"=>$g_payment, 
            "Apayment"=>$g_paymentAdvance, 
            "percent"=>$g_percent, 
            "total"=>$g_total
        ]);




        
        $pdf = PDF::loadView('content.reports.target',compact('areas','begindate','enddate','loans','nd','output','t_output','g_output'))->setPaper('a4', 'landscape')->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->stream('Notes Collection Report.pdf',array("Attachment"=>false));
    }


}
