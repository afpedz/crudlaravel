<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/',  [LoginController::class,'index']);



Route::get('/login', [LoginController::class,'index']);


Route::get('/dashboard', [DashboardController::class,'index']);

Route::get('/register', [RegisterController::class,'index']);