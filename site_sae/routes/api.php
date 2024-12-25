<?php

use App\Http\Controllers\Api\CommentairePostController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne correctement']);
})->middleware(['auth', 'verified']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/test', function () {
        return response()->json(['message' => 'API fonctionne correctement']);
    });

    Route::get('/photos', [PhotoController::class, 'index']);
    Route::post('/photos', [PhotoController::class, 'store']);
    Route::get('/photos/{id}', [PhotoController::class, 'getUserPhotos']);

Route::get('utilisateurs/{id}', [UserController::class, 'show']);

    Route::apiResource('evenements', EvenementController::class);
    Route::apiResource('utilisateurs', UserController::class);

    Route::post('/evenements', [EvenementController::class, 'store']);
    Route::get('/photos/', [PhotoController::class, 'index']);
    Route::post('/photos', [PhotoController::class, 'store']);
    Route::get('/photos/{id}', [PhotoController::class, 'getUserPhotos']);

});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/commentaires', [CommentairePostController::class, 'index']);
