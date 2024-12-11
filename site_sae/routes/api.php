<?php

use App\Http\Controllers\Api\EvenementController;
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


Route::get('participations', [ParticipationController::class, 'index']);
Route::post('participations', [ParticipationController::class, 'store']);
Route::apiResource('evenements', EvenementController::class);
Route::apiResource('utilisateurs', UserController::class);

Route::post('/evenements', [EvenementController::class, 'store']);
