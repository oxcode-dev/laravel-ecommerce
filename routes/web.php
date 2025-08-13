<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    Route::prefix('categories')->group(function() {
        Route::get('/', [CategoryController::class, 'index'])->name('categories');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::delete('/{category}/delete', [CategoryController::class, 'delete'])->name('categories.delete');
        Route::get('/{category}', [CategoryController::class, 'view'])->name('categories.view');
    });

    Route::prefix('products')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('products');
        Route::get('/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::delete('/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');
        Route::get('/{product}', [ProductController::class, 'view'])->name('products.view');
    });

    Route::prefix('orders')->group(function() {
        Route::get('/', [OrderController::class, 'index'])->name('orders');
        Route::delete('/{order}/delete', [OrderController::class, 'delete'])->name('orders.delete');
        Route::get('/{order}', [OrderController::class, 'view'])->name('orders.view');
    });

    Route::middleware(['admin'])->prefix('users')->group(function() {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/vendors', [UserController::class, 'vendors'])->name('users.vendors');
        Route::get('/customers', [UserController::class, 'customers'])->name('users.customers');
        Route::delete('/{order}/delete', [UserController::class, 'delete'])->name('users.delete');
        Route::get('/{user}', [UserController::class, 'view'])->name('users.view');
    });
});


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
