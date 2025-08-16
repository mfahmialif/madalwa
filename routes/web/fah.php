<?php

use App\Http\Controllers\Admin\JurusanController;
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
        Route::prefix('jurusan')->group(function () {
            Route::get('/', [JurusanController::class, 'index'])->name('admin.jurusan.index');
            Route::get('/data', [JurusanController::class, 'data'])->name('admin.jurusan.data');
            Route::get('/add', [JurusanController::class, 'add'])->name('admin.jurusan.add');
            Route::post('/', [JurusanController::class, 'store'])->name('admin.jurusan.store');
            Route::get('/{jurusan}/edit', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
            Route::put('/{jurusan}/update', [JurusanController::class, 'update'])->name('admin.jurusan.update');
            Route::delete('/{jurusan}/destroy', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');

        });

    });

});
