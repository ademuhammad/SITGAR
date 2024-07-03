<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\TgrController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PenyediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\PembayaranTemuanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpKernel\Profiler\Profile;

// dashboard

Route::group(['middleware' => ['auth']], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::get('/dashboard/get-temuan-data', [DashboardController::class, 'getTemuanData'])->name('dashboard.getTemuanData');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    // OPD
    Route::resource('opds', OpdController::class);

    // Informasi
    Route::resource('informasi', InformasiController::class);
    Route::get('/informasi', [InformasiController::class, 'index'])->name('informasi.index');
    // pegawai
    Route::resource('pegawai', PegawaiController::class);
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
    // status
    Route::resource('status', StatusController::class);
    // status
    Route::resource('tgr', TgrController::class);
    // penyedia
    Route::resource('penyedia', PenyediaController::class);
    // pembayaran temuan
    // Route::resource('pembayaran', PembayaranTemuanController::class);
    Route::get('pembayaran/{temuan}/pembayaran/create', [PembayaranTemuanController::class, 'create'])->name('pembayaran.create');
    Route::post('pembayaran/{temuan}/pembayaran', [PembayaranTemuanController::class, 'store'])->name('pembayaran.store');
    Route::get('pembayaran/{temuan}/pembayaran', [PembayaranTemuanController::class, 'index'])->name('pembayaran.index');
    // laporan
    // Rute resource
    Route::resource('temuan', TemuanController::class);
    Route::get('temuans/selesai', [TemuanController::class, 'selesai'])->name('temuans.selesai');
    Route::get('temuans/get-selesai', [TemuanController::class, 'getselesai'])->name('temuans.getselesai');

    Route::get('temuans/data-sktjm', [TemuanController::class, 'datasktjm'])->name('temuans.datasktjm');
    // Route for handling the AJAX request for data
    Route::get('temuans/get-datasktjm', [TemuanController::class, 'getDatasktjm'])->name('temuans.getDatasktjm');
    Route::get('temuans/data-skp2ks', [TemuanController::class, 'dataskp2ks'])->name('temuans.dataskp2ks');
    Route::get('temuans/get-dataskp2ks', [TemuanController::class, 'getDataskp2ks'])->name('temuans.getDataskp2ks');
    Route::get('temuans/data-skp2k', [TemuanController::class, 'dataskp2k'])->name('temuans.dataskp2k');
    Route::get('temuans/get-dataskp2k', [TemuanController::class, 'getDataskp2k'])->name('temuans.getDataskp2k');
    // Rute khusus untuk download PDF
    Route::get('/temuan/pdf', [TemuanController::class, 'downloadPdf'])->name('temuan.downloadPdf');
    //
    Route::get('/pembayaran-history/pdf', [PembayaranTemuanController::class, 'downloadPdf'])->name('pembayaran-history.pdf');

    // all data mentah
    Route::get('data', [DataController::class, 'index'])->name('data.index');
    Route::resource('data', DataController::class);
    // Route::get('/data/{id}', [DataController::class, 'show'])->name('data.show');

});
// Route::get('data', [DataController::class,'data'])->name('laporan.data');
// Route::get('data-mentah', [DataController::class,'getDataMentah'])->name('laporan.data-mentah');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('user', UserController::class);
Route::get('/my-profile', [ProfileController::class, 'index'])->name('user.myprofile');
Route::resource('profile', ProfileController::class);
Route::resource('role', RoleController::class);

// profile
// Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
