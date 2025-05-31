<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});

Route::resource('home', ProductController::class);
Route::get('/login', function () {
    return view('login');
})->name('login');

