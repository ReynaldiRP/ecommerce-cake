<?php

use App\Models\User;
use Inertia\Inertia;
use App\Models\CakeSize;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\FlavourController;
use App\Http\Controllers\CakeSizeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ShoppingChartController;
use App\Http\Controllers\ToppingController;

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
        Route::controller(FrontEndController::class)->group(function () {
            Route::redirect('/', '/home');
            Route::get('/home', 'index')->name('home');
            Route::get('/home/products', 'products')->name('products');

            Route::get('/search',  'search')->name('search');
        });

        Route::inertia('/checkout', 'CheckoutSection')->name('/checkout');
        Route::inertia('/order', 'OrderStatusSection')->name('/order');


        Route::inertia('/dashboard-home', 'AdminDashboard/HomeSection')->name('dashboard-home');
        Route::resource('/dashboard-cake', CakeController::class)
            ->name('index', 'dashboard-cake')->except('show');
        Route::resource('/dashboard-flavour', FlavourController::class)
            ->name('index', 'dashboard-flavour')->except('show');
        Route::resource('/dashboard-size', CakeSizeController::class)
            ->name('index', 'dashboard-size')->except('show');
        Route::resource('/dashboard-topping', ToppingController::class)
            ->name('index', 'dashboard-topping')->except('show');
    });

    Route::get('/home/{cakeId}/detail-product', [FrontEndController::class, 'detailProduct'])->name('detail-product');
    Route::controller(ShoppingChartController::class)->group(function () {
        Route::post('/add-chart-item', 'addChartItem')->name('add-chart-item');
        Route::get('/shopping-chart-item', 'getShoppingChartItems')->name('get-cart-item');
    });
    Route::inertia('/detail-chart', 'DetailShoppingChart')->name('/detail-chart');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});


Route::middleware(['guest'])->group(function () {
    Route::resource('/login', LoginController::class);
    Route::resource('/register', RegisterController::class);
});
