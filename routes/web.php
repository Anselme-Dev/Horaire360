<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\PosteController;
use App\Http\Controllers\PlanningController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Routes d'authentification (générées par Laravel UI)
Auth::routes();

// Groupe de routes protégées par l'authentification
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des employés
    Route::resource('employes', EmployeController::class);
    Route::post('/employes/import', [EmployeController::class, 'import'])->name('employes.import');
    Route::get('/employes/export/template', [EmployeController::class, 'exportTemplate'])->name('employes.export-template');
    Route::get('/employes/export', [EmployeController::class, 'export'])->name('employes.export');
    
    // Gestion des postes
    Route::resource('postes', PosteController::class);
    
    // Création d'un compte utilisateur pour un employé
    Route::post('/users/create-from-employee/{employe}', [UserController::class, 'createFromEmployee'])->name('users.create-from-employee');
    
    // Routes pour les plannings (itération 2)
    Route::resource('plannings', PlanningController::class);
    Route::post('/plannings/import', [PlanningController::class, 'import'])->name('plannings.import');
    Route::get('/plannings/export/template', [PlanningController::class, 'exportTemplate'])->name('plannings.export-template');
    Route::get('/plannings/export', [PlanningController::class, 'export'])->name('plannings.export');
    Route::get('/plannings/calendrier', [PlanningController::class, 'calendrier'])->name('plannings.calendrier');
    
    // Routes pour les présences (itération 3)
    Route::resource('presences', PresenceController::class)->middleware(['auth']);
    Route::post('/presences/import', [PresenceController::class, 'import'])->name('presences.import');
    Route::get('/presences/export/template', [PresenceController::class, 'exportTemplate'])->name('presences.export-template');
    Route::get('/presences/import', [PresenceController::class, 'importForm'])->name('presences.importForm');
    Route::post('/presences/import', [App\Http\Controllers\PresenceController::class, 'import'])->name('presences.import');
    Route::get('/presences/template', [PresenceController::class, 'template'])->name('presences.template');
    Route::get('/presences/export', [PresenceController::class, 'export'])->name('presences.export');
    Route::get('/presences/export/excel', [PresenceController::class, 'exportExcel'])->name('presences.export-excel');
    Route::get('/presences/export/pdf', [PresenceController::class, 'exportPdf'])->name('presences.export-pdf');
    Route::get('/presences/export/template', [PresenceController::class, 'exportTemplate'])->name('presences.export-template');
    Route::post('presences/import', [PresenceController::class, 'import'])->name('presences.import');
    
    
    // Routes pour les rapports (itération 4)
    Route::get('/rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('/rapports/presences', [RapportController::class, 'presences'])->name('rapports.presences');
    Route::get('/rapports/absences', [RapportController::class, 'absences'])->name('rapports.absences');
    Route::get('/rapports/retards', [RapportController::class, 'retards'])->name('rapports.retards');
    Route::get('/rapports/export/pdf', [RapportController::class, 'exportPdf'])->name('rapports.export-pdf');
    Route::get('/rapports/export/excel', [RapportController::class, 'exportExcel'])->name('rapports.export-excel');
});