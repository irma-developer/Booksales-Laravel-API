<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/books',   [BookController::class, 'index'])->name('books.index');
