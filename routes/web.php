<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PembayaranTemuanController;
use App\Http\Controllers\PenyediaController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\TgrController;
use Illuminate\Support\Facades\Route;

// dashboard

Route::resource('dashboard', DashboardController::class);
Route::get('/', [DashboardController::class, 'index']);
// OPD
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
// Route::get('pembayaran/{temuan}/pembayaran/create', [PembayaranTemuanController::class, 'create'])->name('pembayaran.create');
// Route::post('pembayaran/{temuan}/pembayaran', [PembayaranTemuanController::class, 'store'])->name('pembayaran.store');
// Route::get('pembayaran/{temuan}/pembayaran', [PembayaranTemuanController::class, 'index'])->name('pembayaran.index');
// laporan
// Rute resource
Route::resource('temuan', TemuanController::class);
// Rute khusus untuk download PDF
Route::get('/temuan/pdf', [TemuanController::class, 'downloadPdf'])->name('temuan.downloadPdf');
//
Route::get('/pembayaran-history/pdf', [PembayaranTemuanController::class, 'downloadPdf'])->name('pembayaran-history.pdf');

// all data mentah
Route::get('data', [DataController::class, 'index'])->name('data.index');
Route::resource('data', DataController::class);
Route::get('/data/{no_lhp}', [DataController::class, 'show'])->name('data.show');


// Route::get('data', [DataController::class,'data'])->name('laporan.data');
// Route::get('data-mentah', [DataController::class,'getDataMentah'])->name('laporan.data-mentah');
