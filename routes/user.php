<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\DiscountController;

// User Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::view('/home', 'user.home')->name('home');
    Route::view('/profile', 'user.profile')->name('profile');
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');

    // Wishlist Routes
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{wishlist}', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');

    // Discount Routes
    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');

    // Notification Routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    Route::get('/notifications/preferences', [NotificationController::class, 'preferences'])->name('notifications.preferences');
    Route::patch('/notifications/preferences', [NotificationController::class, 'updatePreferences'])->name('notifications.update-preferences');
}); 