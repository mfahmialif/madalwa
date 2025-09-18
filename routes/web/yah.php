<?php

use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\ImportController;
use App\Http\Controllers\Admin\LembagaController;
use App\Http\Controllers\Admin\MutasiKeluarController;
use App\Http\Controllers\Admin\MutasiMasukController;
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

    });
});
