<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UnsubscribeController;

// ========== Auth Routes ==========
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// ========== Public Routes ==========
Route::get('/', function () {
    return redirect('/home');
})->name('root');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

// Legal and Information Pages
Route::view('/faq', 'faq')->name('faq');
Route::view('/privacy', 'privacy')->name('privacy');
Route::view('/terms', 'terms')->name('terms');

// Email Preferences
Route::get('/unsubscribe', [UnsubscribeController::class, 'show'])->name('unsubscribe');
Route::post('/unsubscribe/update', [UnsubscribeController::class, 'update'])->name('unsubscribe.update');
Route::post('/unsubscribe/all', [UnsubscribeController::class, 'unsubscribeAll'])->name('unsubscribe.all');

// Search Route
Route::get('/search', [SearchController::class, 'index'])->name('search');

// Product Routes
Route::get('/shop', [ProductController::class, 'index'])->name('products.index');
Route::get('/shop/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/api/products/{product}/quick-view', [ProductController::class, 'quickView'])->name('products.quick-view');

// Category Routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category');

// Review Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::patch('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// Cart Routes
Route::middleware(['web'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{itemId}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/summary', [CartController::class, 'summary'])->name('cart.summary');
});

// Checkout Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// ========== After Login ==========
Route::middleware('auth')->group(function () {
    Route::view('/home', 'home')->name('home');
    Route::view('/profile', 'profile')->name('profile');
});

// ========== Admin Routes ==========
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [App\Http\Controllers\Admin\DashboardController::class, 'export'])->name('dashboard.export');
    
    // Product Management
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class);
    Route::post('/products/bulk-action', [App\Http\Controllers\Admin\ProductController::class, 'bulkAction'])->name('products.bulk-action');
    
    // Order Management
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');

    // Review Management
    Route::patch('/reviews/{review}/approve', [ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [ReviewController::class, 'reject'])->name('reviews.reject');

    // Discount Management
    Route::post('/products/{product}/discounts', [DiscountController::class, 'apply'])->name('discounts.apply');
    Route::patch('/discounts/{discount}', [DiscountController::class, 'update'])->name('discounts.update');
    Route::delete('/discounts/{discount}', [DiscountController::class, 'remove'])->name('discounts.remove');
});

// Order Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Wishlist Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/add/{product}', [WishlistController::class, 'add'])->name('wishlist.add');
    Route::delete('/wishlist/remove/{wishlist}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::post('/wishlist/move-to-cart/{wishlist}', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
    Route::delete('/wishlist/clear', [WishlistController::class, 'clear'])->name('wishlist.clear');
});

// Discount Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/discounts', [DiscountController::class, 'index'])->name('discounts.index');
});

// Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
    Route::delete('/notifications', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
    Route::get('/notifications/preferences', [NotificationController::class, 'preferences'])->name('notifications.preferences');
    Route::patch('/notifications/preferences', [NotificationController::class, 'updatePreferences'])->name('notifications.update-preferences');
});

// Admin Notification Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('/orders/{order}/notify', [NotificationController::class, 'notifyOrderStatus'])->name('notifications.order-status');
    Route::post('/products/{product}/notify-back-in-stock', [NotificationController::class, 'notifyBackInStock'])->name('notifications.back-in-stock');
    Route::post('/products/{product}/notify-price-drop', [NotificationController::class, 'notifyPriceDrop'])->name('notifications.price-drop');
});

// Include Modular Route Files
require __DIR__.'/auth.php';
require __DIR__.'/shop.php';
require __DIR__.'/user.php';
require __DIR__.'/admin.php';
require __DIR__.'/legal.php';
require __DIR__.'/cart.php';
