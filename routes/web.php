<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Routes publiques supprimées - redirection vers le dashboard
Route::get('/', function () {
    return view('homepage.index');
})->name('homepage');


// Routes protégées par authentification
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/export', [DashboardController::class, 'exportInterventions'])->name('dashboard.export');

    // Gestion des clients
    Route::resource('clients', ClientController::class);

    // Gestion des interventions
    Route::resource('interventions', InterventionController::class);
    Route::post('/interventions/{intervention}/assign', [InterventionController::class, 'assign'])->name('interventions.assign');
    Route::post('/interventions/{intervention}/status', [InterventionController::class, 'updateStatus'])->name('interventions.status');
    Route::delete('/intervention-images/{image}', [InterventionController::class, 'deleteImage'])->name('intervention-images.delete');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
