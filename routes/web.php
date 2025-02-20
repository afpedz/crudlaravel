<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/',  function() {
    return view('login', [
        "title" => "Login",
    ]);
})->name("login");

Route::post('/login', [AuthController::class,'login']);
Route::get('/register', function() {
    return view('register', [
        "title" => "Register",
    ]);
})->name("register");

Route::post('/register', [UserController::class,'store']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::put('/dashboard/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/dashboard/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
});
