<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login',['title' => 'Login']);
    }
    public function store(Request $request){
        $this->validate($request,[
            'email' =>['required','email'],
            'password' =>['required']
        ]);
        
        if(!Auth::attempt($request->only('email','password'))){
            return back()->with('status','Invalid login credentials');
        }

        return redirect()->route('dashboard');
    }
}
