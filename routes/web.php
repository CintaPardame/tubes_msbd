<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Public Landing Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Harus Login)
Route::middleware('auth')->group(function () {
    // Role-based Dashboards (Admin, Kasir, Petani, User)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/dashboard/orders/{order}/status', [DashboardController::class, 'updateOrderStatus'])->name('dashboard.order.status');

    // Admin Specific Actions (Level 1)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Fitur 1: Supplies approval & Roasting Batch
        Route::patch('/supplies/{supply}/approve', [AdminController::class, 'approveSupply'])->name('supplies.approve');
        Route::patch('/supplies/{supply}/reject', [AdminController::class, 'rejectSupply'])->name('supplies.reject');
        Route::post('/roasting-batches', [AdminController::class, 'storeRoastingBatch'])->name('roasting.store');

        // Fitur 2: Harga Minimum & Promotions & User Matrix
        Route::patch('/products/{product}/min-price', [AdminController::class, 'updateMinPrice'])->name('products.min_price');
        Route::post('/promotions', [AdminController::class, 'storePromotion'])->name('promotions.store');
        Route::patch('/promotions/{promotion}/toggle', [AdminController::class, 'togglePromotion'])->name('promotions.toggle');
        Route::delete('/promotions/{promotion}', [AdminController::class, 'deletePromotion'])->name('promotions.destroy');
        Route::patch('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    });

    // Order Biji Kopi (Per Paket 1 kg)
    Route::get('/order/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/order', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('orders.show');
});
