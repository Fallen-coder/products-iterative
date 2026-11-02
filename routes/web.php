<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/',[ProductController::class, 'index']);

Route::resource('products', ProductController::class);

Route::post('/products/{product}/increase',
    [ProductController::class, 'increaseQuantity'])
    ->name('products.increase');

Route::post('/products/{product}/decrease',
    [ProductController::class, 'decreaseQuantity'])
    ->name('products.decrease');
