<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::where('is_active',1)->get();
        $users = User::where('id','<>',2)->where('id','<>',Auth::user()->id)->get();
        return view('content.users.index',compact('roles','users'));
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
        if( User::where('username',$request['username'])->count() > 0)
            return ['success'=>false, 'message'=>'Username already exist.'];
        else{
            $add = ([
               
                'username'=> $request['username'],
                'name'=> $request['name'],
                'first_name' => $request['first_name'],
                'middle_name' => $request['middle_name'],
                'last_name' => $request['last_name'],
                'role_id' => $request['role_id'],
                'password' => Hash::make('123456'),
                'is_active' => '1',
            ]);

            $new = User::create($add);
            return ['success'=>true,'message'=> 'User successfully added.'];
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $roles = Role::where('is_active',1)->orderby('name')->get();
        return view('content.users.show',compact('user','roles'));
    }

    public function status($id)
    {
        if( User::where('id',$id)->pluck('is_active')->first() == 1 )
        {
            $update = User::where('id',$id)->update(['is_active'=>0]);
            if($update)
                return ['success'=>true,'message'=> 'User deactivated.'];
            else
                return ['success'=>false,'message'=> 'Something went wrong.'];
        }else{
            $update = User::where('id',$id)->update(['is_active'=>1]);
            if($update)
                return ['success'=>true,'message'=> 'User reactivated.'];
            else
               return ['success'=>false,'message'=> 'Something went wrong.'];
        }

        return ['success'=>false,'message'=>  $id];
    }

    public function resetPW($id)
    {
        $update = User::where('id',$id)->update(['password'=>Hash::make('123456')]);
        if($update)
            return ['success'=>true,'message'=> 'Password reset to 123456 successfully.'];
        else
            return ['success'=>false,'message'=> 'Something went wrong.'];
       
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
    public function update(Request $request, User $user)
    {
        $userUpdate = $user->update([
            'name' => $request->name,
            'first_name'=> $request->first_name,
            'middle_name'=> $request->middle_name,
            'last_name'=> $request->last_name
        ]);
        if($userUpdate)
        {
            return ['success'=>true, 'message'=>$user->name. ' successfull updated.'];
        }else{
            return ['success'=>false, 'message'=>'There was an error in updating profile. Please contact developer.'];
        }
    }

    public function updatePass(Request $request)
    {
        $user = User::find($request->id);
        $old = Hash::make($request->old);
        $new = Hash::make($request->password);
        if(password_verify($request->old, $user->password))
        {
            $user->update(['password'=>$new]);
            return ['success'=>true, 'message'=>$user];
        }else{
            return ['success'=>false, 'message'=>'Current password is incorrect.'];
        }
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
