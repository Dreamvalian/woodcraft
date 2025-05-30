<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\CategoryController;
use App\Http\Controllers\Shop\SearchController;
use App\Http\Controllers\Shop\ReviewController;

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