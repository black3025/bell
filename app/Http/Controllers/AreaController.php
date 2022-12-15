<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = Area::all();
        return view('content.areas.index',compact('areas'));
    }

    public function updateR(Request $request, $id)
    {
        $Area = Area::where('id', $id)->first();

        $Area->update([
            'name'=> $request->name,
            'category' =>$request->category
        ]);

        if($Area)
            return ['success'=>true,'message'=> 'Area updated.'];
        else
            return ['success'=>false,'message'=> 'Something went wrong please contact the administrator.'];
    }



    public function status($id)
    {
        if( Area::where('id',$id)->pluck('is_active')->first() == 1 )
        {
            $update = Area::where('id',$id)->update(['is_active'=>0]);
            if($update)
                return ['success'=>true,'message'=> 'Area deactivated.'];
            else
                return ['success'=>false,'message'=> 'Something went wrong please contact the administrator.'];
        }else{
            $update = Area::where('id',$id)->update(['is_active'=>1]);
            if($update)
                return ['success'=>true,'message'=> 'Area reactivated.'];
            else
               return ['success'=>false,'message'=> 'Something went wrong please contact the administrator.'];
        }

        return ['success'=>false,'message'=>  $id];
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
        $add= Area::create($request->all());
        if($add)
            return ['success'=>true,'message'=> 'Area added.'];
        else
            return ['success'=>false, 'message'=> 'Something went wrong please contact the administrator.'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function show(Area $area)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Area $area)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Area  $area
     * @return \Illuminate\Http\Response
     */
    public function destroy(Area $area)
    {
        //
    }
}
