<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
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
Route::get('login',  [LoginController::class, 'viewLogin'])->name('login');
Route::get('products', [AdminController::class, 'productsView'])->name('products');
Route::get('addProduct', [AdminController::class, 'addProductView'])->name('addProduct');
Route::get('editProductView/{id}', [AdminController::class, 'editProductView'])->name('editProductView');

Route::post('addToCart/{id}', [ProductController::class, 'store'])->name('addToCart');
Route::post('deleteProductFromCart/{id}', [ProductController::class, 'deleteProductFromCart'])->name('deleteProductFromCart');
Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('validateLogin', [LoginController::class, 'validateLogin'])->name('validateLogin');
Route::post('logoutAdmin', [AdminController::class, 'logoutAdmin'])->name('logoutAdmin');
Route::post('deleteProduct/{id}', [AdminController::class, 'deleteProductFromDB'])->name('deleteProduct');
Route::post('addProduct', [AdminController::class, 'store'])->name('addProduct');
Route::patch('editProduct/{id}', [AdminController::class, 'update'])->name('update');