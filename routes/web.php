<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;


Route::get('/',  [LoginController::class,'index']);

Route::get('/login', [LoginController::class,'index'])->name('login');
Route::post('/login', [LoginController::class,'store']);

Route::post('/logout', [LogoutController::class,'store'])->name('logout');

Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
//uncomment when need to post to dashboard, make sure to make "store" class in DashboardController
//Route::post('/dashboard', [DashboardController::class,'store']);

Route::get('/register', [RegisterController::class,'index'])->name('register');
Route::post('/register', [RegisterController::class,'store']);