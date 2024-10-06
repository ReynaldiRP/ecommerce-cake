<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\FlavourController;
use App\Http\Controllers\ToppingController;
use App\Http\Controllers\CakeSizeController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\OrderController;
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

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Routes accessible without 'auth' middleware
    Route::withoutMiddleware(['auth'])->group(function () {
        // Frontend controller routes
        Route::controller(FrontEndController::class)->group(function () {
            Route::redirect('/', '/home'); // Redirect root to home
            Route::get('/home', 'index')->name('home'); // Home page
            Route::get('/home/products', 'products')->name('products'); // Products page
        });

        // Inertia route for order status section
        Route::inertia('/order', 'OrderStatusSection')->name('order.status'); // Order status
    });

    // Admin-specific routes
    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin/dashboard')->group(function () {
            Route::inertia('/home', 'AdminDashboard/HomeSection')->name('dashboard-home'); // Admin dashboard home

            // Resource routes for managing cakes
            Route::resource('/cake', CakeController::class)
                ->parameter('cake', 'dashboard_cake')
                ->except('show'); // Cake management (excluding show)

            // Resource routes for managing flavours
            Route::resource('/flavour', FlavourController::class)
                ->parameter('flavour', 'dashboard_flavour')
                ->except('show'); // Flavour management (excluding show)

            // Resource routes for managing cake sizes
            Route::resource('/size', CakeSizeController::class)
                ->parameter('size', 'dashboard_size')
                ->except('show'); // Cake size management (excluding show)

            // Resource routes for managing toppings
            Route::resource('/topping', ToppingController::class)
                ->parameter('topping', 'dashboard_topping')
                ->except('show'); // Topping management (excluding show)
        });
    });

    // Additional frontend controller routes
    Route::controller(FrontEndController::class)->group(function () {
        Route::get('/home/{cakeId}/detail-product', 'detailProduct')->name('detail-product'); // Cake detail product
        Route::get('/home/detail-chart/checkout', 'checkout')->name('checkout'); // Checkout page
    });

    // Inertia route for detail shopping chart
    Route::inertia('/detail-chart', 'DetailShoppingChart')->name('detail-chart'); // Shopping cart detail

    // Logout route
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout'); // Logout

    // Shopping chart controller routes
    Route::controller(ShoppingChartController::class)->group(function () {
        Route::post('/add-chart-item', 'addChartItem')->name('add-chart-item'); // Add item to chart
        Route::delete('/shopping-chart-item', 'deleteShoppingChartItem')->name('delete-cart-item'); // Delete shopping chart item
    });

    Route::controller(OrderController::class)->group(function () {
        Route::post('/add-order', 'createOrderItem')->name('add-order');
    });
});

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::resource('/login', LoginController::class); // Login routes
    Route::resource('/register', RegisterController::class); // Registration routes
});
