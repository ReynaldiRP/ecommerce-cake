<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FlavourController;
use App\Models\User;
use Inertia\Inertia;

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
        Route::inertia('/dashboard-home', 'AdminDashboard/HomeSection')->name('dashboard-home');
        Route::resource('/dashboard-cake', CakeController::class);
        Route::resource('/dashboard-flavour', FlavourController::class)->except('show');
        Route::resource('/dashboard-category', CategoryController::class);
    });
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});


Route::middleware(['guest'])->group(function () {
    Route::resource('/login', LoginController::class);
    Route::resource('/register', RegisterController::class);
});
