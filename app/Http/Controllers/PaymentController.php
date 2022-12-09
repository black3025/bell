<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Area;
use App\Models\Loan;
use Illuminate\Http\Request;
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
        $payments = Loan::all();
        $area = Area::where('is_active',1)->get();
        return view('content.payments.index',["payments"=>$payments,"areas"=>$area]);
    }



    public function pay(Request $request)
    {
        if(Auth::user()->role->id > 1){
            if($request->date < date('Y-m-d'))
                return ['success'=>false, 'message'=>'Cannot Back date'];
        }
        
        return route('/payments/post', ['date'=>$request->date, 'area'=>$request->area]) ;
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
        //
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
