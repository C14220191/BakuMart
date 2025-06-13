<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;


Route::get('/', [ProductController::class, 'index'])->name('home');


Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login');

Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register');



Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/form', [ProductController::class, 'create'])->name('products.create');
        Route::post('/form', [ProductController::class, 'store'])->name('products.store');
    });

    Route::resource('products', ProductController::class)->except(['create', 'store']);
});
