<?php

use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CartPageController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\MarketPageController;
use App\Http\Controllers\ProfilePageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/login', [AuthPageController::class, 'loginPage'])->name('login');
Route::get('/register', [AuthPageController::class, 'registerPage'])->name('register');
Route::post('/performLogin', [AuthPageController::class, 'performLogin'])->name('performLogin');
Route::post('/performRegister', [AuthPageController::class, 'performRegister'])->name('performRegister');
Route::middleware('auth:sanctum')->get('/profile', [ProfilePageController::class, 'index'])->name('profile');
Route::get('/logout', [ProfilePageController::class, 'logout'])->name('logout');
Route::get('/market', [MarketPageController::class, 'index'])->name('market');
Route::post('/updateTradeLink', [ProfilePageController::class, 'updateTradeLink'])->name('updateTradeLink');
Route::get('/cart', [CartPageController::class, 'index'])->name('cart');

Route::middleware('auth:sanctum')->post('/addToCart', [CardController::class, 'addToCart'])->name('addToCart');
Route::middleware('auth:sanctum')->post('/removeFromCart', [CardController::class, 'removeFromCart'])->name('removeFromCart');

Route::middleware('auth:sanctum')->get('/clearCart', [CartPageController::class, 'clearCart'])->name('clearCart');
Route::middleware('auth:sanctum')->get('/buyCart', [CartPageController::class, 'buyCart'])->name('buyCart');
