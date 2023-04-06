<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Buyer\BuyerController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Transaction\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
Buyers
*/
Route::apiResource('buyers', BuyerController::class)->only(['index', 'show']);
/*
Categories
Laravel 5.3 Route::resource('categories', 'Buyer\CategoryController');
*/
Route::apiResource('categories', CategoryController::class); 
/*
Products
Laravel 5.3 Route::resource('buyers', 'Buyer\BuyerController', ['only' => ['index', 'show']]);
*/
Route::apiResource('products', ProductController::class)->only(['index', 'show']); 
/*
Transactions
*/
Route::apiResource('transactions', TransactionController::class)->only(['index', 'show']);
/*
Sellers
*/
Route::apiResource('sellers', SellerController::class)->only(['index', 'show']); 
/*
Users
*/
Route::apiResource('users', UserController::class);
