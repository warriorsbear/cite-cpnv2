<?php

use App\Http\Controllers\Api\CommentairePostController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ParticipationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API fonctionne correctement']);
})->middleware(['auth', 'verified']);


Route::apiResource('evenements', EvenementController::class);
Route::apiResource('utilisateurs', UserController::class);


Route::get('/participations',[ParticipationController::class, 'index']);
Route::post('/participations', [ParticipationController::class, 'store']);
Route::delete('/participations', [ParticipationController::class, 'destroy']);

Route::post('/evenements', [EvenementController::class, 'store']);
Route::delete('/evenements', [EvenementController::class, 'destroy']);
Route::get('/photos/', [PhotoController::class, 'index']);
Route::post('/photos', [PhotoController::class, 'store']);
Route::get('/photos/{id}', [PhotoController::class, 'getUserPhotos']);


Route::get('/posts', [PostController::class, 'index']);
Route::get('/commentaires', [CommentairePostController::class, 'index']);
