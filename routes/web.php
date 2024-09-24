<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\FlavourController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\CakeSizeController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ShoppingChartController;

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
        });

        Route::inertia('/checkout', 'CheckoutSection')->name('/checkout');
        Route::inertia('/order', 'OrderStatusSection')->name('/order');
    });

    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin/dashboard')->group(function () {
            Route::inertia('/home', 'AdminDashboard/HomeSection')->name('dashboard-home');
            Route::resource('/cake', CakeController::class)->parameter('cake', 'dashboard_cake')
                ->except('show');
            Route::resource('/flavour', FlavourController::class)->parameter('flavour', 'dashboard_flavour')
                ->except('show');
            Route::resource('/size', CakeSizeController::class)->parameter('size', 'dashboard_size')
                ->except('show');
            Route::resource('/topping', ToppingController::class)->parameter('topping', 'dashboard_topping')
                ->except('show');
        });
    });

    Route::get('/home/{cakeId}/detail-product', [FrontEndController::class, 'detailProduct'])->name('detail-product');
    Route::inertia('/detail-chart', 'DetailShoppingChart')->name('/detail-chart');
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::controller(ShoppingChartController::class)->group(function () {
        Route::post('/add-chart-item', 'addChartItem')->name('add-chart-item');
        Route::delete('/shopping-chart-item/{shoppingChartItem}',  'deleteShoppingChartItem')->name('delete-cart-item');
    });
});


Route::middleware(['guest'])->group(function () {
    Route::resource('/login', LoginController::class);
    Route::resource('/register', RegisterController::class);
});
