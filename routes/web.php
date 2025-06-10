<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UnsubscribeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// ========== Auth Routes ==========
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
});

// ========== Public Routes ==========
Route::get('/', function () {
    return view('welcome');
})->name('home');

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

// Shop Routes
Route::get('/shops', [ShopController::class, 'index'])->name('shops.index');
Route::get('/shops/{shop:slug}', [ShopController::class, 'show'])->name('shops.show');
Route::get('/api/shops/{shop}/quick-view', [ShopController::class, 'quickView'])->name('shops.quick-view');

// Cart Routes
Route::middleware(['web'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{shop}', [CartController::class, 'remove'])->name('cart.remove');
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

    // Shop Management
    // Route::resource('shops', App\Http\Controllers\Admin\ShopController::class);
    // Route::post('/shops/bulk-action', [App\Http\Controllers\Admin\ShopController::class, 'bulkAction'])->name('shops.bulk-action');

    // Order Management
    Route::get('/orders', [App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/role', [App\Http\Controllers\Admin\UserController::class, 'updateRole'])->name('users.update-role');
});

// Order Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
});

// Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications', [NotificationController::class, 'clearAll'])->name('notifications.clear-all');
});

// Include Modular Route Files
require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/legal.php';
require __DIR__ . '/cart.php';
