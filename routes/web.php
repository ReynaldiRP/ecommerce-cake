<?php

use App\Http\Controllers\AdminDashboard\OrderStatus\EditOrderStatus;
use App\Http\Controllers\AdminDashboard\OrderStatus\UpdateOrderStatus;
use App\Http\Controllers\AdminDashboard\ShowAllPaymentController;
use App\Http\Controllers\AdminDashboard\ShowDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CakeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\FlavourController;
use App\Http\Controllers\PaymentController;
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

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    // Routes accessible without additional 'auth' middleware
    Route::withoutMiddleware(['auth'])->group(function () {
        // Frontend controller routes
        Route::controller(FrontEndController::class)->group(function () {
            Route::redirect('/', '/home'); // Redirect root to home
            Route::get('/home', 'index')->name('home'); // Home page
            Route::get('/home/products', 'products')->name('products'); // Products page
            Route::inertia('/home/order-history', 'OrderHistorySection')->name('order.history');
        });

        // Inertia route for order status section
        Route::inertia('/order', 'OrderStatusSection')->name('order.status'); // Order status
    });

    // Admin-specific routes
    Route::middleware(['admin'])->group(function () {
        Route::prefix('admin/dashboard')->group(function () {
            // Admin dashboard home
            Route::get('/home', ShowDashboardController::class)->name('dashboard-home');

            // Resource routes for managing cakes
            Route::resource('/cake', CakeController::class)
                ->parameter('cake', 'dashboard_cake')
                ->except('show'); // Cake management (excluding show)

            // Resource routes for managing categories
            Route::resource('/category', CategoryController::class)
                ->parameter('category', 'dashboard_category')
                ->except(['create', 'show']); // Category management (excluding show, create)

            // Resources for managing discounts
            Route::resource('/discount', DiscountController::class)
                ->parameter('discount', 'dashboard_discount')
                ->except('show'); // Discount management (excluding show)

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


            // Routes for managing orders
            Route::controller(OrderController::class)->group(function () {
                Route::get('/orders', 'index')->name('orders.index');
                Route::get('/order/{orderId}', 'show')->name('order.show');
                Route::patch('/order/{orderId}', 'update')->name('order.update');
            });

            // Routes for showing all payments
            Route::get('/payments', ShowAllPaymentController::class)->name('payments.index');

            // Route for edit and update order status
            Route::get('/orders/edit-status/{order}', EditOrderStatus::class)->name('order.edit-status');
            Route::patch('/orders/edit-status/{orderId}', UpdateOrderStatus::class)->name('order.update-status');
        });
    });

    // Additional frontend controller routes
    Route::controller(FrontEndController::class)->group(function () {
        Route::get('/home/{cakeId}/detail-product', 'detailProduct')->name('detail-product'); // Cake detail product
        Route::match(['GET', 'POST'], '/home/detail-chart/checkout', 'checkout')->name('checkout'); // Checkout page
    });

    // Inertia route for detail shopping chart
    Route::inertia('/home/detail-chart', 'DetailShoppingChart')->name('detail-chart'); // Shopping cart detail

    // Logout route
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout'); // Logout

    // Shopping chart controller routes
    Route::controller(ShoppingChartController::class)->group(function () {
        Route::post('/add-chart-item', 'addChartItem')->name('add-chart-item'); // Add item to chart
        Route::delete('/shopping-chart-item', 'deleteShoppingChartItem')->name('delete-cart-item'); // Delete shopping chart item
    });

    // Order controller routes
    Route::controller(OrderController::class)->group(function () {
        Route::post('/add-order', 'createOrderItem')->name('add-order');
        Route::post('/payments', 'redirectPaymentMidtrans')->name('payments');
    });

    // Payment controller routes
    Route::controller(PaymentController::class)->group(function () {
        // History transaction route
        Route::get('home/transaction-history', 'transactionHistory')->name('transaction-history');
        // Detail transaction route
        Route::get('home/transaction-history/{orderCode}',  'detailTransaction')->name('detail-transaction');
        // Buy again cake order route
        Route::post('home/transaction-history/{orderItem}/buy-again', 'buyAgainCakeOrder')->name('buy-again');
        // Cancel cake order route
        Route::post('home/transaction-history/{orderId}/cancel', 'cancelOrder')->name('cancel-order');
    });
});

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::resource('/login', LoginController::class); // Login routes
    Route::resource('/register', RegisterController::class); // Registration routes
});
