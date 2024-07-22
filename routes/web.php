<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;

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

Route::middleware(['auth'])->group(function () {
    Route::withoutMiddleware(['auth'])->group(function () {
        Route::inertia('/', 'LandingPageSection')->name('/home');
        Route::inertia('/products', 'ProductSection')->name('/products');
        Route::inertia('/detail-product', 'DetailProductSection')->name('/detail-product');
        Route::inertia('/detail-chart', 'DetailShoppingChart')->name('/detail-chart');
        Route::inertia('/checkout', 'CheckoutSection')->name('/checkout');
        Route::inertia('/order', 'OrderStatusSection')->name('/order');
        Route::inertia('/dashboard-home', 'DashboardHomeSection')->name('dashboard-home');
    });
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});


Route::middleware(['guest'])->group(function () {
    Route::resource('/login', LoginController::class);
    Route::resource('/register', RegisterController::class);
});
