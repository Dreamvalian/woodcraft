<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    })->name('api.v1.user');

    Route::get('/search', [App\Http\Controllers\ShopController::class, 'search'])->name('api.v1.search');
});

Route::get('/search', [App\Http\Controllers\ShopController::class, 'search'])->name('api.search');
