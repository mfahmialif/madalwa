<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\UnitSekolahController;

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
        Route::prefix('jurusan')->group(function () {
            Route::get('/', [JurusanController::class, 'index'])->name('admin.jurusan.index');
            Route::get('/data', [JurusanController::class, 'data'])->name('admin.jurusan.data');
            Route::get('/add', [JurusanController::class, 'add'])->name('admin.jurusan.add');
            Route::post('/', [JurusanController::class, 'store'])->name('admin.jurusan.store');
            Route::get('/{jurusan}/edit', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
            Route::put('/{jurusan}/update', [JurusanController::class, 'update'])->name('admin.jurusan.update');
            Route::delete('/{jurusan}/destroy', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');
        });
        Route::prefix('unit-sekolah')->group(function () {
            Route::get('/', [UnitSekolahController::class, 'index'])->name('admin.unit-sekolah.index');
            Route::get('/data', [UnitSekolahController::class, 'data'])->name('admin.unit-sekolah.data');
            Route::get('/add', [UnitSekolahController::class, 'add'])->name('admin.unit-sekolah.add');
            Route::post('/', [UnitSekolahController::class, 'store'])->name('admin.unit-sekolah.store');
            Route::get('/{unitSekolah}/edit', [UnitSekolahController::class, 'edit'])->name('admin.unit-sekolah.edit');
            Route::put('/{unitSekolah}/update', [UnitSekolahController::class, 'update'])->name('admin.unit-sekolah.update');
            Route::delete('/{unitSekolah}/destroy', [UnitSekolahController::class, 'destroy'])->name('admin.unit-sekolah.destroy');
        });

    });

});
