<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/',[ProductsController::class,'index'])->name('home');
Route::get('/products/{product}', [Products::class, 'show'])->name('products.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [Category::class, 'show'])->name('categories.show');


// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout / Orders
Route::post('/checkout', [OrderController::class, 'store'])->middleware('auth')->name('checkout');
Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('auth')->name('orders.show');

// Admin routes
Route::middleware(['auth','can:admin'])->group(function () {
    Route::resource('admin/categories', Category::class);
    Route::resource('admin/products', Product::class);
    Route::resource('admin/orders', Order::class);
 
});

