<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function login(Request $request){
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
