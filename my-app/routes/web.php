<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


require __DIR__.'/auth.php';
