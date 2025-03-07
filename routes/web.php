<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/',  function() {
    return view('login', [
        "title" => "Login",
    ]);
})->name("login");

Route::post('/', [AuthController::class,'login']);
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
    Route::get('/category', function() {
        return view('category');
    });
    Route::get('/products', function() {
        return view('products');
    });
    Route::get('/units', function() {
        return view('units');
    });
    Route::resource('units', UnitController::class);
    // Route::get('/units', [UnitController::class, 'index'])->name('units.index');
    Route::get('/dashboard/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/category', [CategoriesController::class, 'index'])->name('categories.index');
    Route::resource('categories', CategoriesController::class);
    Route::get('/products',[ProductsController::class,'index'])->name('products.index');
    Route::resource('products', ProductsController::class);
    Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
});




