<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('product', function () {
    return view('product');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Shop page
Route::get('/shop', function () {
    return view('shop'); // loads resources/views/shop.blade.php
})->name('shop'); // this defines the route name "shop"

// Seller dashboard page
Route::get('/seller', function () {
    return view('seller'); // loads resources/views/seller.blade.php
})->name('seller');

// Route::get('/discover', function () {
//     return view('display-product');
// })->name('discover');

// Show the add product form
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Handle form submission
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

Route::get('/dashboard', function (){
    return view('components.seller.dashboard');
})->name('dashboard');


Route::get('/discover', [ProductController::class, 'show'])->name('discover');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::get('dashboard', [ProductController::class, 'sellerProducts'])
    ->middleware('auth')
    ->name('dashboard');



require __DIR__.'/auth.php';
