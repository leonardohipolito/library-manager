<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::middleware([
    'auth',
])->group(function () {
    Route::resource('category', \App\Http\Controllers\CategoryController::class);
    Route::resource('author', \App\Http\Controllers\AuthorController::class);
    Route::resource('book', \App\Http\Controllers\BookController::class);
    Route::resource('loan', \App\Http\Controllers\LoanController::class);
    Route::resource('user', \App\Http\Controllers\UserController::class);
});
