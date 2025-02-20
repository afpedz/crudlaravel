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
        $this->validate($request, [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
    
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }
    
        return response()->json(['redirect' => route('dashboard')]);
    }
}
