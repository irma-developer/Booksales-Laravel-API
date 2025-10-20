<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);
Route::post('logout',   [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::apiResource('books',  BookController::class)->only(['index','show']);
Route::apiResource('genres', GenreController::class)->only(['index','show']);
Route::apiResource('authors', AuthorController::class)->only(['index','show']);


Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::apiResource('books',  BookController::class)->only(['store','update','destroy']);
    Route::apiResource('genres', GenreController::class)->only(['store','update','destroy']);
    Route::apiResource('authors', AuthorController::class)->only(['store','update','destroy']);
});
