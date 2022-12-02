<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function login(Request $request)
  {
    $errors= '';
      if($request['email-username']=="testing"){
        return view('content.dashboard.dashboards-analytics');
      }else{
        $errors = "Incorrect Username or Password";
        return view('content.authentications.auth-login-basic',['error'=>$errors]);
      }
      

  }
}
