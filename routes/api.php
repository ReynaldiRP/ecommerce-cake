<?php

use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ShoppingChartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {
    Route::get('/shopping-chart-item', [ShoppingChartController::class, 'getShoppingChartItems'])->name('get-cart-item');
});



Route::get('/search',  [FrontEndController::class, 'search'])->name('search');
