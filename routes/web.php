<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login', ['title' => 'Login']);
});



Route::get('/register', function () {
    return view('register', ['title' => 'Sign Up']);
});



Route::get('/dashboard', function () {
    return view('dashboard', ['title' => 'Dashboard']);
});