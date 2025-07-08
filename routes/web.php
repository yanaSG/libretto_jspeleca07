<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ReviewController;

Route::get('/', function () {
    return redirect('books');
});

// Show login/register forms
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Handle form submissions
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('reviews', ReviewController::class);
});