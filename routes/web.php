<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Tag;
use Illuminate\Http\Request;

Route::get('/',[ProductController::class, 'index']);

Route::resource('products', ProductController::class);

Route::post('/products/{product}/increase',
    [ProductController::class, 'increaseQuantity'])
    ->name('products.increase');

Route::post('/products/{product}/decrease',
    [ProductController::class, 'decreaseQuantity'])
    ->name('products.decrease');


Route::get('/tags/search', function (Request $request) {
    $search = $request->get('q', '');

    return Tag::where('name', 'like', '%' . $search . '%')
        ->orderBy('name')
        ->limit(10)
        ->get(['id', 'name']);
})->name('tags.search');