<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Client;
use App\Models\Area;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lpd = Payment::max('date');
        $area = Area::where('is_active',1)->get();
        return view('content.payments.index',["lpd"=>$lpd,"areas"=>$area, "errors"=>""]);
    }



    public function pay(Request $request)
    {
        //return $request->all();

        $lpd = Payment::max('date');
        if(Auth::user()->role->id > 1){
            if( date('Y-m-d',strtotime($request->payday)) < date('Y-m-d', strtotime($lpd))){
                $area = Area::where('is_active',1)->get();
                return view(
                    'content.payments.index',
                    [
                        "lpd"=>$lpd,
                        "areas"=>$area,
                        'errors'=>'Cannot procced posting from previous dates. Please Contact the Administrator.'
                    ]
                );
               
            }
        }

       $area = Area::where('id',$request->area)->pluck('name')->first();

       $loans = Loan::where('rel_date','<=',date('Y-m-d', strtotime($request->payday)))
       ->where(function($q) use ($request){
           $q->where('balance','>','0')->orwhere('close_date',$request->payday);
       
       })   
       ->wherehas('client', function($query) use ($request)
           {
               $query->where('area_id', $request->area);
           })
       ->orderBy(
           Client::select('account_name')
                   ->whereColumn('clients.id', 'loans.client_id')
       )->with('payments', function($query) use($request)
           {
               $query->where('date',date('Y-m-d', strtotime($request->payday)));
           }
       )
       ->get();
        return view('content.payments.pay', ['date'=>$request->payday, 'area'=>$area, 'loans'=>$loans]);

        // return $loans->all();
    }

    public function postPay(){
        return view('content.payments.pay');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $result = DB::transaction(function() use ($request){
            $count = count($request->input('loan_id'));
            $success = false;
            for($x = 0; $x<$count; $x++)
            {
                $counts= $request->input('date');
                if($request->input('amount.'.$x.'.value') != 0)
                {
                    
                    
                    $paid = Payment::updateOrCreate(
                            [
                            'loan_id' => $request->input('loan_id.'.$x.'.value'),
                            'p_nlid' => $request->input('loan_id.'.$x.'.value'),
                            'date' => $request->date
                            ],
                            [
                            'amount' => $request->input('amount.'.$x.'.value'),
                            'or_number' => $request->input('or.'.$x.'.value'),
                            'user_id' => Auth::user()->id
                            ]
                        
                    );
                    if($paid)
                        $success = true;
                    
                }else{
                    $delete = Payment::where('loan_id',$request->input('loan_id.'.$x.'.value'))
                                ->where('date', $request->date)->delete();
                    if($delete) $success = true;
                }

                if($success)
                {
                        $loan = Loan::find($request->input('loan_id.'.$x.'.value'));
                        $paid = Payment::where('loan_id', $loan->id)->sum('amount');
                        $loan->balance = $loan->principle_amount - $paid;
                        
                        if($loan->balance <= 0)
                            $loan->close_date = $request->date;
                        $loan->save();
                }  

            }
            return ['success'=>true, 'message'=>"Payments successfully posted."];
        });

      return $result;

        // return ['success'=>false, 'message'=>'something went wrong.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
