<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\SettingsController as AdminSettings;
use App\Http\Controllers\Admin\TrainingExportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ResumeImportController;
use App\Http\Controllers\TemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect(auth()->check() ? '/resumes' : '/login'));

Route::get('/terms', [LegalController::class, 'terms'])->name('terms');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/resumes', [ResumeController::class, 'index']);
    Route::post('/resumes', [ResumeController::class, 'create']);
    Route::get('/resumes/{resume}/edit', [ResumeController::class, 'edit']);
    Route::put('/resumes/{resume}', [ResumeController::class, 'update']);
    Route::delete('/resumes/{resume}', [ResumeController::class, 'destroy']);
    Route::get('/resumes/{resume}/pdf', [ResumeController::class, 'exportPdf']);
    Route::post('/ai/enhance', [ResumeController::class, 'enhance']);

    Route::get('/resumes/import', [ResumeImportController::class, 'show']);
    Route::post('/resumes/import', [ResumeImportController::class, 'handle']);

    Route::get('/templates', [TemplateController::class, 'index']);
    Route::post('/templates', [TemplateController::class, 'storeCustom']);

    // Admin-only
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/', [AdminDashboard::class, 'index']);
        Route::get('/settings', [AdminSettings::class, 'edit']);
        Route::post('/settings', [AdminSettings::class, 'update']);
        Route::get('/training', [TrainingExportController::class, 'index']);
        Route::post('/training/run', [TrainingExportController::class, 'runBatch']);
        Route::get('/training/download', [TrainingExportController::class, 'downloadJsonl']);
    });
});
