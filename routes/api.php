<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\API\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum')->name('api.logout');
// Route::post('/forgot-password', [PasswordResetController::class, 'forgot'])->name('api.forgot_password');
// Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('api.reset_password');