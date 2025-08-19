<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\ProductController;
use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function() {
    return response()->json([
        'hello' => 'world',
        'users' => User::all(),
        'categories' => Category::all(),
        'products' => Product::search('')->get(),
        'orders' => Order::search('')->get(),
        'orderItems' => OrderItem::search('')->get(),
        'wishlists' => Wishlist::search('')->get(),
        'reviews' => Review::search('')->get(),
        'addresses' => Address::search('')->get(),
    ]);
});


Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
// Route::post('/forgot-password', [PasswordResetController::class, 'forgot'])->name('api.forgot_password');
// Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('api.reset_password');