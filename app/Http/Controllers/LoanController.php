<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Client;
use Illuminate\Http\Request;
use Auth;
class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loans = Loan::orderby(Client::select('account_name')->whereColumn('clients.id','loans.client_id'))->where('close_date',null)->get();
        return view('content.loans.index',['loans'=>$loans]);
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
        //check if there is an active loan
        if(Loan::where('client_id', $request['client_id'])->where('close_date',NULL)->count() > 0)
        {
            return ["success"=>false, "message"=>"Client has an outstanding balance.. Please settle the existing balance."];
        }else{
            $add2 = ([
                'client_id' => $request['client_id'],
                'rel_date'=> $request['rel_date'],
                'beg_date' => date('Y-m-d',strtotime($request['rel_date']. "1 days")),
                'end_date' => date('Y-m-d',strtotime($request['rel_date']. "101 days")),
                'principle_amount' => $request['principle_amount'],
                'balance' => $request['principle_amount'],
                'cycle' => $request['cycle'],
                'is_active' => '1',
                'approvals' => '1',
                'category' => '1',
                'approval_date' => date('Y-m-d',strtotime($request['rel_date']. "1 days")),
                'approval_notes' => strtoupper(Auth::user()->name),
                'user_id' =>Auth::user()->id
            ]);

            $addloan = Loan::create($add2);
            if($addloan){
                return ["success"=>true, "message"=>"Successfully added new loan."];
            }else{
                return ["success"=>false, "message"=>"There were a problem in saving your data. Please concatct your developer."];
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function show(Loan $loan)
    {
        return view('content.loans.show',['loan'=>$loan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Loan  $loan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Loan $loan)
    {
        //
    }
}
