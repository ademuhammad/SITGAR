<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PembayaranTemuanController;
use App\Http\Controllers\PenyediaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\TgrController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::get('/pegawai', function () {
    return view('Master.pegawai');
});
Route::get('/opd', function () {
    return view('Master.opd');
});
Route::get('/penyedia', function () {
    return view('Master.penyedia');
});
Route::get('/data-temuan', function () {
    return view('Laporan.data-temuan');
});
Route::get('/informasi', function () {
    return view('Master.informasi');
});
Route::get('/status', function () {
    return view('Master.status');
});
Route::get('/tgr', function () {
    return view('Master.tgr');
});

// OPD
Route::get('/data_opd', [OpdController::class, 'index'])->name('opds.index');
Route::get('opds/create', [OpdController::class, 'create'])->name('opds.create');
Route::post('opds/save', [OpdController::class, 'store'])->name('opds.store');
Route::resource('opds', OpdController::class);

// Informasi
Route::resource('informasi', InformasiController::class);
Route::get('/informasi',[InformasiController::class, 'index'])->name('informasi.index');
// pegawai
Route::resource('pegawai', PegawaiController::class);
Route::get('/pegawai',[PegawaiController::class, 'index'])->name('pegawai.index');
// status
Route::resource('status', StatusController::class);
// status
Route::resource('tgr', TgrController::class);
// penyedia
Route::resource('penyedia', PenyediaController::class);
// pembayaran temuan
Route::resource('pembayaran', PembayaranTemuanController::class);
Route::get('temuan/{temuan}/pembayaran/create', [PembayaranTemuanController::class, 'create'])->name('pembayaran.create');
Route::post('temuan/{temuan}/pembayaran', [PembayaranTemuanController::class, 'store'])->name('pembayaran.store');
Route::get('temuan/{temuan}/pembayaran', [PembayaranTemuanController::class, 'index'])->name('pembayaran.index');
// laporan
Route::resource('temuan', TemuanController::class);
//
Route::get('/pembayaran-history/pdf', [PembayaranTemuanController::class, 'downloadPdf'])->name('pembayaran-history.pdf');
// dashboard
Route::resource('dashboard', DashboardController::class);
