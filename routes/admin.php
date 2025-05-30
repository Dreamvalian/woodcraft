<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Shop\ReviewController;
use App\Http\Controllers\User\DiscountController;
use App\Http\Controllers\User\NotificationController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
    
    // Product Management
    Route::resource('products', ProductController::class);
    Route::post('/products/bulk-action', [ProductController::class, 'bulkAction'])->name('products.bulk-action');
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');

    // Review Management
    Route::patch('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');

    // Discount Management
    Route::post('/products/{product}/discounts', [DiscountController::class, 'apply'])->name('discounts.apply');
    Route::patch('/discounts/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::delete('/discounts/{discount}', [DiscountController::class, 'remove'])->name('discounts.remove');

    // Admin Notification Routes
    Route::post('/orders/{order}/notify', [NotificationController::class, 'notifyOrderStatus'])->name('notifications.order-status');
    Route::post('/products/{product}/notify-back-in-stock', [NotificationController::class, 'notifyBackInStock'])->name('notifications.back-in-stock');
    Route::post('/products/{product}/notify-price-drop', [NotificationController::class, 'notifyPriceDrop'])->name('notifications.price-drop');
}); 