<?php

use App\Http\Controllers\Api\CommentairePostController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EvenementController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\ParticipationController;
use App\Http\Controllers\Api\PhotoController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VisionnageController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
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
})->name('bienvenue');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/evenement', function () {
    return Inertia::render('Evenement');
})->middleware(['auth', 'verified'])->name('evenement');

Route::get('/messagerie', function () {
    return Inertia::render('Messagerie');
})->middleware(['auth', 'verified'])->name('messagerie');

Route::get('/doc', function () {
    return Inertia::render('Documents');
})->middleware(['auth', 'verified'])->name('documents');

Route::get('/contact', function () {
    return Inertia::render('NousContacter');
})->name('contact');

Route::get('/email/verify', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


Route::middleware(['auth','verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/evenement', [EvenementController::class, 'store'])->name('evenement.create');
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenement.index');
    Route::post('participation', [ParticipationController::class, 'store'])->name('participation.create');
    Route::post('/photo', [PhotoController::class, 'store'])->name('photo.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.create');
    Route::get('/commentairespost', [CommentairePostController::class, 'index'])->name('commentairespost.index');
    Route::post('/commentairespost', [CommentairePostController::class, 'store'])->name('commentairespost.create');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/documents/upload', [DocumentController::class, 'upload'])->name('documents.upload');
    Route::get('/documents/download/{id}', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{id}', [DocumentController::class, 'delete'])->name('documents.destroy');

    Route::get('/api/visionnage/start/{id_visionnage}', [VisionnageController::class, 'startVisionnage']);
    Route::get('/api/visionnage/status/{id_visionnage}', [VisionnageController::class, 'getVisionnageStatus']);

    Route::get('/events/list', [EvenementController::class, 'index'])->name('events.list');


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
})->name('MentionsLegales');

Route::get('/NousContacter', function () {
    return Inertia::render('NousContacter');
})->name('NousContacter');


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

Route::get('/ProfileModification/{id}', [ProfileController::class, 'show'])->middleware(['auth', 'verified'])->name('profile.show');
Route::post('/ProfileModification/{id}', [ProfileController::class, 'updateModif'])->middleware(['auth', 'verified'])->name('profile.updateModif');
Route::patch('/ProfileModification/{id}', [ProfileController::class, 'updateModif'])->middleware(['auth', 'verified'])->name('profile.updateModif');

//ajout de la route pour la page monCompte avec un paramètre
Route::get('/monCompte/{id}', function ($id) {
    return Inertia::render('MonCompte', ['id' => $id]);
})->middleware(['auth', 'verified'])->name('monCompte.show');
