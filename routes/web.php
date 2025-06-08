<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});

Route::resource('home', ProductController::class);
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('/login', [UserController::class, 'authenticate'])->name('login');
Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UserController::class, 'store'])->name('register');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');
