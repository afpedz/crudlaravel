<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard',['title' => 'Dashboard']);
    }
    //uncomment when going to use this controller for data handling
    /*
    public function store(Request $request){
    }
    */
}
