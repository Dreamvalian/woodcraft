<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Legal\UnsubscribeController;

// Legal and Information Pages
Route::view('/about', 'legal.about')->name('about');
Route::view('/contact', 'legal.contact')->name('contact');
Route::view('/faq', 'legal.faq')->name('faq');
Route::view('/privacy', 'legal.privacy')->name('privacy');
Route::view('/terms', 'legal.terms')->name('terms');

// Email Preferences
Route::get('/unsubscribe', [UnsubscribeController::class, 'show'])->name('unsubscribe');
Route::post('/unsubscribe/update', [UnsubscribeController::class, 'update'])->name('unsubscribe.update');
Route::post('/unsubscribe/all', [UnsubscribeController::class, 'unsubscribeAll'])->name('unsubscribe.all'); 