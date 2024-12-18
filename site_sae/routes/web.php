<?php

use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('PageBienvenue', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/evenement', function () {
    return Inertia::render('Evenement');
})->middleware(['auth', 'verified'])->name('evenement');

Route::get('/messagerie', function () {
    return Inertia::render('Messagerie');
})->middleware(['auth', 'verified'])->name('messagerie');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/evenement', [EvenementController::class, 'store'])->name('evenement.create');
    Route::post('/photo', [PhotoController::class, 'store'])->name('photo.create');
    Route::delete('/users/{id}', [UserController::class, 'suprimerUser'])->name('users.suprimerUser');
});


require __DIR__.'/auth.php';

/**
 * Route ajoutée par flo
 */
Route::get('/monCompte', function () {
    return Inertia::render('MonCompte');
})->middleware(['auth', 'verified'])->name('monCompte');

Route::get('/MentionsLegales', function () {
    return Inertia::render('MentionsLegales');
})->middleware(['auth', 'verified'])->name('MentionsLegales');

Route::get('/NousContacter', function () {
    return Inertia::render('NousContacter');
})->middleware(['auth', 'verified'])->name('NousContacter');


Route::get('/user/photos', [PhotoController::class, 'getUserPhotos'])
    ->middleware(['auth', 'verified'])
    ->name('user.photos');

Route::get('/AdminGestion', function () {
    return Inertia::render('AdminGestion');
})->middleware(['auth', 'verified'])->name('AdminGestion');

//déclaration de la route en post pour que les paramètres ne soient pas visibles dans l'url
Route::post('/ProfileModification/{id}', function ($id) {
    return Inertia::render('ProfileModification', ['id' => $id]);
})->middleware(['auth', 'verified'])->name('ProfileModification');


