<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
      return view('auth.login');
    }
    
    public function login(Request $request){
      $request->validate([
        'email' => 'required|email',
        'password' => 'required'
      ]);
      
      if (Auth::attempt([
                         'email'    => $request->email, 
                         'password' => $request->password,
                         'verified' => 1
                        ], $request->remember)) {
        return redirect()->route('home');
      }
      else{
        return redirect()->route('login.index')->with('login_fail', 'Invalid Login');
      }
    }
    
    public function logout(){
      Auth::logout();
      return redirect()->route('login.index');
    }
}