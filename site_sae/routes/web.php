<?php

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
});


require __DIR__.'/auth.php';

/**
 * Route ajoutée par Florian
 *
 * J'ai enlever ces lignes (fichier AuthenticatedLayout.vue, ligne 55) :
 * :href="route('profile.edit')"
 * :active="route().current('profile.edit')"
 */
Route::get('/monCompte', function () {
    return Inertia::render('MonCompte');
})->middleware(['auth', 'verified'])->name('monCompte');

Route::get('/PageMentionsLegales', function () {
    return Inertia::render('PageMentionsLegales');
})->middleware(['auth', 'verified'])->name('PageMentionsLegales');

Route::get('/NousContacter', function () {
    return Inertia::render('NousContacter');
})->middleware(['auth', 'verified'])->name('NousContacter');

Route::get('/AdminGestion', function () {
    return Inertia::render('AdminGestion');
})->middleware(['auth', 'verified'])->name('AdminGestion');
