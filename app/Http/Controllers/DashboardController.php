<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(){

        $users = User::all();
        return view('dashboard',['title' => 'Dashboard', 'users' => $users]);
    }
    //uncomment when going to use this controller for data handling
    /*
    public function store(Request $request){
    }
    */
}
