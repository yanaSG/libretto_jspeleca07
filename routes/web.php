<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\AuthorController;
use App\Http\Controllers\Web\BookController;
use App\Http\Controllers\Web\GenreController;
use App\Http\Controllers\Web\ReviewController;

Route::get('/', function () {
    return redirect('books');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('authors', AuthorController::class);
    Route::resource('books', BookController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('reviews', ReviewController::class);
});