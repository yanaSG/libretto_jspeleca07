<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('books');
});

Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);