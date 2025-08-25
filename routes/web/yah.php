<?php

use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\LembagaController;
use App\Http\Controllers\Admin\MutasiKeluarController;
use App\Http\Controllers\Admin\MutasiMasukController;
use App\Models\Lembaga;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::prefix('/lembaga')->group(function () {
            Route::get('/', [LembagaController::class, 'index'])->name('admin.lembaga.index');
            Route::post('/save', [LembagaController::class, 'store'])->name('admin.lembaga.store');
        });
        
        Route::prefix('/alumni')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('admin.alumni.index');
            Route::get('/data', [AlumniController::class, 'data'])->name('admin.alumni.data');
            Route::prefix('/show')->group(function () {
                Route::get('/{id}', [AlumniController::class, 'show'])->name('admin.alumni.show');
                Route::get('/{id}/pertahun', [AlumniController::class, 'alumniPerTahun'])->name('admin.alumni.pertahun');
            });
        });

        Route::prefix('mutasi-masuk')->group(function () {
            Route::get('/', [MutasiMasukController::class, 'index'])->name('admin.mutasi-masuk.index');
            Route::get('/data', [MutasiMasukController::class, 'data'])->name('admin.mutasi-masuk.data');
            Route::get('/add', [MutasiMasukController::class, 'add'])->name('admin.mutasi-masuk.add');
            Route::post('/', [MutasiMasukController::class, 'store'])->name('admin.mutasi-masuk.store');
            Route::get('/{mutasi}/edit', [MutasiMasukController::class, 'edit'])->name('admin.mutasi-masuk.edit');
            Route::put('/{mutasi}/update', [MutasiMasukController::class, 'update'])->name('admin.mutasi-masuk.update');
            Route::delete('/{mutasi}/destroy', [MutasiMasukController::class, 'destroy'])->name('admin.mutasi-masuk.destroy');
        });

        Route::prefix('mutasi-keluar')->group(function () {
            Route::get('/', [MutasiKeluarController::class, 'index'])->name('admin.mutasi-keluar.index');
            Route::get('/data', [MutasiKeluarController::class, 'data'])->name('admin.mutasi-keluar.data');
            Route::get('/add', [MutasiKeluarController::class, 'add'])->name('admin.mutasi-keluar.add');
            Route::post('/', [MutasiKeluarController::class, 'store'])->name('admin.mutasi-keluar.store');
            Route::get('/{mutasi}/edit', [MutasiKeluarController::class, 'edit'])->name('admin.mutasi-keluar.edit');
            Route::put('/{mutasi}/update', [MutasiKeluarController::class, 'update'])->name('admin.mutasi-keluar.update');
            Route::delete('/{mutasi}/destroy', [MutasiKeluarController::class, 'destroy'])->name('admin.mutasi-keluar.destroy');
        });
    });
});
