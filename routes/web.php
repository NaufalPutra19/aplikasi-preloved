<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/', [HomeController::class,'index'])->name('home');
Auth::routes();

Route::resource('products', ProductController::class)->only(['index','show']);
Route::get('cart', [CartController::class,'index'])->name('cart.index');
Route::post('cart/add', [CartController::class,'add'])->name('cart.add');
Route::post('cart/update', [CartController::class,'update'])->name('cart.update');
Route::post('cart/remove', [CartController::class,'remove'])->name('cart.remove');

Route::middleware('auth')->group(function(){
    Route::get('checkout', [CheckoutController::class,'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class,'store'])->name('checkout.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth','can:admin'])->group(function(){
    Route::get('/', [DashboardController::class,'index'])->name('dashboard');
    Route::resource('items', \App\Http\Controllers\Admin\ItemController::class);
});
