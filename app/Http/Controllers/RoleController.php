<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('content.roles.index', compact('roles'));
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
        $add= Role::create($request->all());
        if($add)
            return ['success'=>true,'message'=> 'Role added.'];
        else
            return ['success'=>false, 'message'=> 'Something went wrong please contact the administrator.'];
    

    }

    public function updateR(Request $request, $id)
    {
        $role = Role::where('id', $id)->first();

        $role->update([
            'name'=> $request->name,
            'restriction' =>$request->restriction
        ]);

        if($role)
            return ['success'=>true,'message'=> 'Role updated.'];
        else
            return ['success'=>false,'message'=> 'Something went wrong please contact the administrator.'];
    }

    public function status($id)
    {
        if( Role::where('id',$id)->pluck('is_active')->first() == 1 )
        {
            $update = Role::where('id',$id)->update(['is_active'=>0]);
            if($update)
                return ['success'=>true,'message'=> 'Role deactivated.'];
            else
                return ['success'=>false,'message'=> 'Something went wrong please contact the administrator.'];
        }else{
            $update = Role::where('id',$id)->update(['is_active'=>1]);
            if($update)
                return ['success'=>true,'message'=> 'Role reactivated.'];
            else
               return ['success'=>false,'message'=> 'Something went wrong please contact the administrator.'];
        }

        return ['success'=>false,'message'=>  $id];
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
