<?php

use App\Http\Controllers\AuthentificationController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

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

Route::inertia('/', 'App');
Route::inertia('/about', 'About');
Route::inertia('/home', 'App');

Route::get('/login', [AuthentificationController::class, 'login'])->name('authentication.login');
