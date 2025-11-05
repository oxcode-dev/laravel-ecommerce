<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::delete('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
Route::post('/forgot-password', [PasswordResetController::class, 'forgot'])->name('api.forgot_password');
Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('api.reset_password');
Route::post('/reset-password/generate-otp', [PasswordResetController::class, 'generateOtp'])->name('api.generate_otp');

Route::middleware(['throttle:api'])->prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('api.categories');
    Route::get('/{category}', [CategoryController::class, 'show'])->name('api.categories_show');
    Route::get('/{slug}/products', [CategoryController::class, 'products'])->name('api.categories_products');
});

Route::middleware(['throttle:api'])->prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('api.products');
    Route::get('/cart', [ProductController::class, 'cartProducts'])->name('api.products_cart');
    Route::get('/{product}', [ProductController::class, 'show'])->name('api.products_show');
});

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('/profile-update', [ProfileController::class, 'update'])->name('api.update_profile');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('api.change_password');
    Route::post('/delete-account', [ProfileController::class, 'deleteAccount'])->name('api.delete_account');
    
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('api.orders');
        Route::get('/{order}', [OrderController::class, 'show'])->name('api.orders_show');
        Route::post('', [OrderController::class, 'store'])->name('api.orders_store');
    });

    Route::prefix('wishlists')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('api.wishlists');
        Route::get('/{wishlist}', [WishlistController::class, 'show'])->name('api.wishlists_show');
        Route::post('/', [WishlistController::class, 'store'])->name('api.wishlists_add');
        Route::delete('/{wishlist}', [WishlistController::class, 'destroy'])->name('api.wishlists_delete');
    });

    Route::prefix('reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('api.reviews');
        Route::post('/', [ReviewController::class, 'store'])->name('api.reviews_store');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('api.reviews_destroy');
        Route::get('/{review}', [ReviewController::class, 'show'])->name('api.reviews_show');
    })->middleware('auth:sanctum');

    Route::prefix('addresses')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('api.addresses');
        Route::post('/', [AddressController::class, 'store'])->name('api.addresses_add');
        Route::get('/{address}', [AddressController::class, 'show'])->name('api.addresses_show');
        Route::put('/{address}', [AddressController::class, 'update'])->name('api.addresses_destroy');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('api.addresses_delete');
    });
});


