<?php

use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('laporan', LaporanController::class);
    Route::resource('setorans', SetoranController::class);
    Route::resource('users', UserController::class);
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');

    Route::resource('sales', PenjualanController::class);
});


/**
 * Routing for artisan
 */
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/artisan-optimize', function() {
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

require __DIR__.'/auth.php';
