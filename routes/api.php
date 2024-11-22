<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\NavigationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/loginValidate', [UserController::class, 'loginValidate'])->name('loginValidate');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/registerValidate', [UserController::class, 'registerValidate'])->name('registerValidate');
Route::post('/isNameAvailable', [UserController::class, 'isNameAvailable'])->name('isNameAvailable');
Route::middleware('auth:sanctum')->get('/cart', [UserController::class, 'getCart'])->name('getCart');
Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'getUserInfo'])->name('getUserInfo');
Route::middleware('auth:sanctum')->get('/transactions', [UserController::class, 'GetTransactions'])->name('getTransactions');
Route::middleware('auth:sanctum')->get('/purchases', [UserController::class, 'GetPurchases'])->name('getPurhcases');
Route::middleware('auth:sanctum')->post('/cartPush', [UserController::class, 'CartPush'])->name('cartPush');
Route::middleware('auth:sanctum')->post('/cartPop', [UserController::class, 'CartPop'])->name('cartPop');
Route::middleware('auth:sanctum')->get('/buyCart', [UserController::class, 'BuyCart'])->name('buyCart');
Route::middleware('auth:sanctum')->get('/clearCart', [UserController::class, 'ClearCart'])->name('clearCart');
Route::middleware('auth:sanctum')->post('/tradelink', [UserController::class, 'UpdateTradeLink'])->name('tradelink');
Route::post('/changeAvatar', [UserController::class, 'changeAvatar'])->name('changeAvatar');
Route::middleware('auth:sanctum')->post('/changePassword', [UserController::class, 'ChangePassword'])->name('changePassword');

Route::get('/games', [GameController::class, 'getGames'])->name('games');

Route::get('/navigation/{game}', [NavigationController::class, 'getNavigation'])->name('navigation.game');
Route::get('/navigation', [NavigationController::class, 'getNavigation'])->name('navigation');

Route::get('/filters/{game}', [FilterController::class, 'getFilters'])->name('filters.game');
Route::get('/filters', [FilterController::class, 'getFilters'])->name('filters');
Route::get('/categories/{game}', [FilterController::class, 'getCategories'])->name('categories.game');
Route::get('/categories', [FilterController::class, 'getCategories'])->name('categories');

Route::get('/listings/{game}', [ListingController::class, 'getListings'])->name('listings.game');
Route::get('/listings', [ListingController::class, 'getListings'])->name('listings');
Route::post('/listingFilters/{game}', [ListingController::class, 'getListingFilters'])->name('listingFilters');
Route::post('/listingFilters', [ListingController::class, 'getListingFilters'])->name('listingFilters');
