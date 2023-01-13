<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use App\Models\Loan;
use App\Models\Area;
// use App\Payment;
use Auth;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $clients = Client::paginate(10);
        $clients= Client::all();
            // $clients = Client::all();
        $areas = Area::where('is_active',1)->orderby('category')->orderby('name')->get();
        
        return view('content.clients.index',['clients'=>$clients, 'areas'=>$areas]);
        
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
    
        if( Client::where('account_name',$request['account_name'])->count() > 0)
            return ['success'=>false, 'message'=>'Account name already exist.'];
        else{
            $result = DB::transaction(function() use ($request){
                    $mess = "";
                    $suc = true;
                    $client_id = Client::max('client_id');
                    $year = date('Y');
                    $t_number = '1';
                    if($client_id =="")
                    {
                        $client_id = $year.'-0001';
                    }else{
                        $temp = explode("-", $client_id );
                        $year_n = $temp[0];
                        $number = (int)$temp[1] +1;
                        if($year == $year_n)
                        {
                            $client_id =$year_n.'-'. str_pad($number, 4, '0', STR_PAD_LEFT);
                        }else{
                            $client_id = $year.'-0001';   
                        } 
                    } 

                    $add = ([
                        'client_id' => $client_id,
                        'account_name'=> $request['account_name'],
                        'first_name' => $request['first_name'],
                        'middle_name' => $request['middle_name'],
                        'last_name' => $request['last_name'],
                        'address' => $request['address'],
                        'business' => $request['business'],
                        'area_id' => $request['area_id'],
                        'income' => $request['income'],
                        'contact_number' => $request['contact_number'],
                        'is_active' => '1',
                    ]);

                    $new = Client::create($add);
                    if($new)
                    {
                        $add2 = ([
                            'client_id' => $new->id,
                            'rel_date'=> $request['rel_date'],
                            'beg_date' => date('Y-m-d',strtotime($request['rel_date']. "1 days")),
                            'end_date' => date('Y-m-d',strtotime($request['rel_date']. "101 days")),
                            'principle_amount' => $request['principle_amount'],
                            'balance' => $request['principle_amount'],
                            'cycle' => $request['cycle'],
                            'is_active' => '1',
                            'loans' => '1',
                            'approvals' => '1',
                            'category' => '1',
                            'approval_date' => date('Y-m-d',strtotime($request['rel_date']. "1 days")),
                            'approval_notes' => strtoupper(Auth::user()->name),
                            'user_id' => strtoupper(Auth::user()->id),
                        ]);
                        $addloan = Loan::create($add2);
    
                        //create 0 payment if payment today is already posted
                        // $lpd = Payment::wherehas('clients',function($query) use($request){$query->where('area',$request['area']);})->max('date');
    
                        // if($lpd == $request['rel_date'])
                        // {
                        //     payment::create(['loan_id'=>$addloan->id, 'client_id'=>$id,'amount'=>'0','p_nlid'=> $addloan->id, 'date'=>$lpd, 'user_id'=> Auth::user()->id, 'area'=>$addloan->area, 'acctname'=>$addloan->acctname]);
                        // }   
                        $mess = 'Client '.$new->client_id.' successfully added.';
                    }else{
                        $suc = false;
                        $mess = 'Error saving client. please contact developer.';
                    }
                  return ['success'=> $suc, 'message'=> $mess];
            });
            
            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $areas = Area::where('is_active',1)->orderby('category')->orderby('name')->get();
        return view('content.clients.show',['client'=>$client,'areas'=>$areas]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        
        $name = $request->file('pic')->getClientOriginalName();
 
        $request->file('pic')->store('public/assets/img/avatars');
        

        if( Client::where('account_name',$request['account_name'])->where('id','<>',$client->id)->count() > 0)
            return ['success'=>false, 'message'=>'Account name already exist.'];
        else{
            $clientUpdate = Client::where('id', $client->id)->update([
                'account_name'=> $request->account_name,
                'first_name'=> $request->first_name,
                'middle_name'=> $request->middle_name,
                'last_name'=> $request->last_name,
                'business'=> $request->business,
                'income'=> $request->income,
                'contact_number'=> $request->contact_number,
                'area_id'=> $request->area,
                'address'=> $request->address,
                'pic'=> $name
            ]);
            if($clientUpdate)
            {
                return ['success'=>true, 'message'=>'Client '. $client->account_name. ' successfull updated.'];
            }else{
                return ['success'=>false, 'message'=>'There was an error in updating client: '. $client->account_name. ' please contact developer.'];
            }
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
