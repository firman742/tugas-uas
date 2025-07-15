<?php

use App\Http\Controllers\BukuSetoranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\BukuSetoran;

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

    // Route::resource('setorans', SetoranController::class);  // for ranking setoran
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::resource('sales', PenjualanController::class);


    // for Buku Setoran
    Route::get('/setoran', [BukuSetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/create', [BukuSetoranController::class, 'create'])->name('setoran.create');
    Route::post('/setoran', [BukuSetoranController::class, 'store'])->name('setoran.store');
    Route::get('/setoran/{id}/edit', [BukuSetoranController::class, 'edit'])->name('setoran.edit');
    Route::put('/setoran/{id}', [BukuSetoranController::class, 'update'])->name('setoran.update');
    Route::delete('/setoran/{id}', [BukuSetoranController::class, 'destroy'])->name('setoran.destroy');
    Route::put('/setoran/{id}/status', [BukuSetoranController::class, 'updateStatus'])->name('setoran.updateStatus');
    Route::get('/setoran', [BukuSetoranController::class, 'index'])->name('setoran.index');
    Route::get('/setoran/export/pdf', [BukuSetoranController::class, 'exportPdf'])->name('setoran.export.pdf');

    Route::get('/ranking-setoran', [BukuSetoranController::class, 'ranking'])->name('setoran.ranking');
    // Route::get('/setoran/export/excel', [BukuSetoranController::class, 'exportExcel'])->name('setoran.export.excel');

    // for Laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/create', [LaporanController::class, 'create'])->name('laporan.create');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('/laporan/harian', [LaporanController::class, 'laporanHarian'])->name('laporan.harian');
    Route::get('/laporan/bulanan', [LaporanController::class, 'laporanBulanan'])->name('laporan.bulanan');

});


/**
 * Routing for artisan
 */
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/artisan-optimize', function () {
    Artisan::call('optimize');
    return "Platform is optimize";
});

Route::get('/migrate-fresh-seed', function () {
    Artisan::call('migrate:fresh --seed');
    return Response::make('<pre>' . Artisan::output() . '</pre>');
});

Route::get('/migrate', function () {
    Artisan::call('migrate');
    return Response::make('<pre>' . Artisan::output() . '</pre>');
});

Route::get('/storage-link', function () {
    Artisan::call('storage:link');
    return Response::make('<pre>' . Artisan::output() . '</pre>');
});

require __DIR__ . '/auth.php';
