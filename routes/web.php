<?php

use App\Exports\WordExport;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'pemohon', 'as' => 'pemohon.'], function () {
    Route::resource('/formKoneksi', PemohonController::class);
    Route::get('/form/export-excel', [PemohonController::class, 'export'])->name('export.excel');
    Route::get('/pemohon/{id}/export-word', [WordExport::class, 'export'])->name('export.word');


});

Route::group(['prefix' => 'permohonan', 'as' => 'permohonan.'], function () {
    Route::resource('/formEmail', PermohonanController::class);
    Route::get('/form-email/export/{file}', 'PermohonanController@exportWord')->name('permohonan.formEmail.export');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('/dataKoneksi', AdminController::class);
    Route::get('/export-excel', [AdminController::class, 'export'])->name('export.excel');
    Route::get('/dataKoneksi/{id}/export-word', [WordExport::class, 'export'])->name('export.word');
    Route::get('/tableKoneksi', [AdminController::class, 'tableKoneksi'])->name('tableKoneksi');
});

Route::group(['prefix' => 'adminEmail', 'as' => 'adminEmail.'], function () {
    Route::resource('/dataEmail', AdminEmailController::class);
    Route::get('/export-excel', [AdminEmailController::class, 'export'])->name('export.excel');
    Route::delete('/adminEmail/dataEmail/destroy/{id}', [AdminEmailController::class, 'destroy'])->name('admin.dataEmail.destroy');
    // routes/web.php
    // Route::delete('/adminEmail/dataEmail/destroy/{id}', [AdminEmailController::class, 'destroy'])->name('admin.dataEmail.destroy');
    // Route::get('/adminEmail/{id}', ['AdminController@destroy'])->name('adminEmail.dataEmail.destroy');
    // Route::get('/dataEmail/{id}/export-word', [WordExport::class, 'export'])->name('export.word');
    Route::post('/word/{id}', [PermohonanController::class, 'word'])->name('word');
    Route::get('/tableEmail', [AdminEmailController::class, 'tableEmail'])->name('tableEmail');
});

Route::get('dashboardAdmin', [AuthenticatedSessionController::class, 'index'])
    ->name('dashboardAdmin');

Route::get('dashboard', [AuthenticatedSessionController::class, 'indexUser'])
    ->name('dashboard');


require __DIR__ . '/auth.php';