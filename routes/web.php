<?php

use Illuminate\Support\Facades\Route;

// Public controllers
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

// Admin controllers (if you separate admin logic)
// use App\Http\Controllers\Admin\ProductController as AdminProductController;
// use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
// use App\Http\Controllers\Admin\OrderController as AdminOrderController;

// -----------------
// Public Routes
// -----------------

// Home / Product listing
Route::get('/', [ProductsController::class, 'index'])->name('home');

// Single product page
Route::get('/products/{product}', [ProductsController::class, 'show'])->name('products.show');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

// Checkout / Orders (requires auth)
Route::middleware(['auth'])->group(function () {
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// -----------------
// Admin Routes
// -----------------
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Admin CRUD for categories
    Route::resource('admin/categories', CategoryController::class);

    // Admin CRUD for products
    Route::resource('admin/products', ProductsController::class);

    // Admin CRUD for orders
    Route::resource('admin/orders', OrderController::class);

    // Optional: manage users
    // Route::resource('admin/users', UserController::class);
});
