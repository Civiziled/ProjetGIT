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
    // Dashboard général (redirection selon le rôle)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes spécifiques par rôle
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/export', [DashboardController::class, 'exportInterventions'])->name('admin.export');
    });
    
    Route::middleware(['role:technicien'])->group(function () {
        Route::get('/technicien', [DashboardController::class, 'technicianDashboard'])->name('technician.dashboard');
    });

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
    //Pour soumettre le formulaire depuis la page principale
    Route::post('/contact',[PublicController::class,'store'])->name('public.store');
require __DIR__.'/auth.php';
