<?php

use App\Http\Controllers\ConfirmAccountController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::get('/confirm-account', [ConfirmAccountController::class, 'index'])->name('confirm_account');
Route::post('/confirm-account', [ConfirmAccountController::class, 'confirm'])->name('confirm_account');

require __DIR__.'/settings.php';
require __DIR__.'/app.php';
require __DIR__.'/auth.php';

