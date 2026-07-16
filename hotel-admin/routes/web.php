<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

// Redirect root to dashboard/login
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// Protected Admin Panel Routes
Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
    
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Rooms CRUD
    Route::resource('rooms', RoomController::class, [
        'as' => 'admin',
        'except' => ['show']
    ]);

    // Bookings CRUD
    Route::resource('bookings', BookingController::class, [
        'as' => 'admin'
    ]);
    Route::post('bookings/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.bookings.status');

    // Restaurant Menu (Food Items) CRUD
    Route::resource('foods', FoodController::class, [
        'as' => 'admin',
        'except' => ['show']
    ]);

    // Food Orders Management
    Route::get('orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status');
    Route::post('orders/{order}/payment-status', [OrderController::class, 'updatePaymentStatus'])->name('admin.orders.payment-status');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Reports and Exports
    Route::get('reports', [ReportController::class, 'index'])->name('admin.reports.index');

});
