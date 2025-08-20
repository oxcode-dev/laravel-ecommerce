<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::post('/forgot-password', [PasswordResetController::class, 'forgot'])->name('api.forgot_password');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('api.reset_password');
Route::post('/generate-otp', [PasswordResetController::class, 'generateOtp'])->name('api.generate_otp');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('api.categories');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('api.categories_show');
        Route::get('/{category}/products', [CategoryController::class, 'products'])->name('api.categories_products');
    });

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('api.products');
        Route::get('/{product}', [ProductController::class, 'show'])->name('api.products_show');
    });
    
});