<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DailyMenuController;
use App\Http\Controllers\DeveloperDashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function (): void {
    Route::post('/restaurant/register', [AuthController::class, 'registerRestaurant']);
    Route::post('/client/register', [AuthController::class, 'registerClient']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth'])->group(function (): void {
    Route::get('/restaurant/profile', [RestaurantController::class, 'show']);
    Route::put('/restaurants/{restaurant}', [RestaurantController::class, 'update'])->middleware('role:restaurant');

    Route::post('/subscriptions', [SubscriptionController::class, 'store']);
    Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew']);
    Route::get('/restaurants/{restaurant}/subscriptions/{user}', [SubscriptionController::class, 'active']);

    Route::get('/restaurants/{restaurant}/menus', [DailyMenuController::class, 'index']);
    Route::get('/restaurants/{restaurant}/menus/today', [DailyMenuController::class, 'today']);
    Route::post('/restaurants/{restaurant}/menus', [DailyMenuController::class, 'store'])->middleware('role:restaurant');

    Route::post('/orders', [OrderController::class, 'store']);
    Route::post('/orders/{order}/delivered', [OrderController::class, 'markDelivered'])->middleware('role:restaurant');
    Route::get('/restaurants/{restaurant}/orders/summary', [OrderController::class, 'summary'])->middleware('role:restaurant');

    Route::get('/developer/dashboard', [DeveloperDashboardController::class, 'index'])->middleware('role:developer');
});
