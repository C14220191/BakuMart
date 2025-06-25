<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Order;

Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products/list', [ProductController::class, 'ajaxList'])->name('products.ajaxList');

Route::get('/login', fn() => view('login'))->name('login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login');
Route::get('/register', fn() => view('register'))->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/payment', [OrderItemController::class, 'index'])->name('payment.index');
    Route::post('/payment/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/api/products/{id}', [ProductController::class, 'apiShow']);
    Route::delete('/order/destroy/{id}', [OrderController::class, 'destroy'])->name('order.cancel');
    Route::get('/payment/success/', [PaymentController::class, 'store'])->name('payment.store');



    Route::middleware(['role:admin'])->group(function () {
        Route::get('/form', [ProductController::class, 'create'])->name('products.create');
        Route::post('/form', [ProductController::class, 'store'])->name('products.store');
        Route::resource('/products/manage', ProductController::class)->except(['create', 'store']);
        Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
    });
});
