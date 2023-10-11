<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/cart', [ProductController::class, 'cart'])->name('cart');
Route::get('login',  [LoginController::class, 'viewLogin']);

Route::post('addToCart/{id}', [ProductController::class, 'store'])->name('addToCart');
Route::post('deleteProduct/{id}', [ProductController::class, 'deleteProductFromCart'])->name('deleteProductFromCart');
Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('validateLogin', [LoginController::class, 'validateLogin'])->name('validateLogin');