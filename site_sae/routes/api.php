<?php

use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\UserController;
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
Route::apiResource('photos', PhotoController::class);

Route::post('/evenements', [EvenementController::class, 'store']);
Route::post('/photos', [PhotoController::class, 'store']);
