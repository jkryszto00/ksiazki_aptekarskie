<?php declare(strict_types=1);

use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::apiResource('books', BookController::class)->except('store');
Route::post('books', [BookController::class, 'store'])->middleware('auth:sanctum')->name('books.store');
