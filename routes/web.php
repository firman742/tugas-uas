<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/setoran', [SetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/create', [SetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [SetoranController::class, 'store'])->name('setoran.store');

    Route::get('/setoran/{id}/edit', [SetoranController::class, 'edit'])->name('setoran.edit');
    Route::put('/setoran/{id}', [SetoranController::class, 'update'])->name('setoran.update');
    Route::delete('/setoran/{id}', [SetoranController::class, 'destroy'])->name('setoran.destroy');

    Route::put('/setoran/{id}/status', [SetoranController::class, 'updateStatus'])->name('setoran.updateStatus');
});

Route::get('/setoran', [SetoranController::class, 'index'])->name('setoran.index');
Route::get('/setoran/export/pdf', [SetoranController::class, 'exportPdf'])->name('setoran.export.pdf');
// Route::get('/setoran/export/excel', [SetoranController::class, 'exportExcel'])->name('setoran.export.excel');
