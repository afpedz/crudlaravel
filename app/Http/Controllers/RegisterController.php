<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Email;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index(){
        return view('register',['title' => 'Register']);
    }
    public function store(Request $request){
        //validate
        $this->validate($request,[
            'name'=>['required','max:255'],
            'email' =>['required','max:255','email','unique:users,email'],
            'password' =>['required','confirmed'],
            'password_confirmation' =>['required']
        ]);
        //store
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        //sign in user
        Auth::attempt($request->only('email', 'password'));
        //redirect
        return redirect()->route('dashboard');
    }
}