<?php

namespace App\Http\Controllers\authentications;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }

  public function validate_login(Request $request)
  {
      $request->validate([
          'username'=> 'required',
          'password'=> 'required',
      ]);

      $credentials = $request->only('username','password');

      if(Auth::attempt($credentials))
      {
          if(Auth::user()->is_active ==1)
            return redirect('/');
          else
            return redirect('auth/login')->with('success','User is deactivated. Contact Administrator.');
      }

      return redirect('auth/login')->with('success','Login details are not valid');
  }

  public function logout(){
    Session::flush();
    Auth::logout();
    return redirect('/');
  }
  
}
