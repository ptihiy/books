<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', [BookController::class, 'index']);

Route::post('/', [BookController::class, 'store']);

Route::post('books/{book}', [BookController::class, 'update']);

Route::delete('/books/{book}', [BookController::class, 'destroy']);
