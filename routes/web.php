<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\TgrController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Skp2kController;
use App\Http\Controllers\SktjmController;
use App\Http\Controllers\Skp2ksController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TemuanController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuratdpController;
use App\Http\Controllers\PenyediaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\JenisTemuanController;
use Symfony\Component\HttpKernel\Profiler\Profile;
use App\Http\Controllers\PembayaranTemuanController;


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware(['auth', 'role:Payment Validator'])->group(function () {
    // Route::resource('user', UserController::class);
    Route::get('/validate-pembayaran', [PembayaranTemuanController::class, 'validateList'])->name('pembayaran.validate.list');
    Route::patch('/validate-pembayaran/{pembayaran}', [PembayaranTemuanController::class, 'validatePayment'])->name('pembayaran.validate');
});

// dashboard

Route::group(['middleware' => ['auth', 'check.opd.access']], function () {

    Route::resource('dashboard', DashboardController::class);
    Route::get('/dashboard/get-temuan-data', [DashboardController::class, 'getTemuanData'])->name('dashboard.getTemuanData');
    Route::get('/temuan-per-bulan', [DashboardController::class, 'getTemuanPerBulan'])->name('temuan.perbulan');

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
    // jenis temuan
    Route::resource('jenistemuan', JenisTemuanController::class);
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
    // sktjm
    Route::resource('sktjm', SktjmController::class);
    Route::resource('skp2k', Skp2kController::class);
    Route::resource('skp2ks', Skp2ksController::class);
    Route::resource('surat-dipersamakan', SuratdpController::class);
    Route::get('surat-yang-dipersamakan', [SuratdpController::class, 'index'])->name('surat-dipersamakan');

    Route::get('temuans/data-sktjm', [TemuanController::class, 'datasktjm'])->name('temuans.datasktjm');
    // Route for handling the AJAX request for data
    Route::get('temuans/get-datasktjm', [TemuanController::class, 'getDatasktjm'])->name('temuans.getDatasktjm');
    Route::get('temuans/data-skp2ks', [TemuanController::class, 'dataskp2ks'])->name('temuans.dataskp2ks');
    Route::get('temuans/get-dataskp2ks', [TemuanController::class, 'getDataskp2ks'])->name('temuans.getDataskp2ks');
    Route::get('temuans/data-skp2k', [TemuanController::class, 'dataskp2k'])->name('temuans.dataskp2k');
    Route::get('temuans/get-dataskp2k', [TemuanController::class, 'getDataskp2k'])->name('temuans.getDataskp2k');
    Route::get('temuans/get-syd', [TemuanController::class, 'getsyd'])->name('temuans.getsyd');
    // Rute khusus untuk download PDF
    Route::get('/temuan/pdf', [TemuanController::class, 'downloadPdf'])->name('temuan.downloadPdf');
    //
    Route::get('/pembayaran-history/pdf', [PembayaranTemuanController::class, 'downloadPdf'])->name('pembayaran-history.pdf');
    // Route::get('/pembayaran/download/{id}', [PembayaranTemuanController::class, 'download'])->name('pembayaran.download');


    // all data mentah
    Route::get('data', [DataController::class, 'index'])->name('data.index');
    Route::resource('data', DataController::class);
    Route::get('/data-keseluruhan', [DataController::class, 'alldata'])->name('data.alldata');
    Route::get('/data-all-test', [DataController::class, 'testall'])->name('data.test');

    // data ekspor
    // routes/web.php
    Route::get('/export-csv', [DataController::class, 'exportCSV'])->name('data.exportCSV');
    Route::get('/export-excel', [DataController::class, 'exportExcel'])->name('data.exportExcel');
    // Route::get('/export-pdf', [DataController::class, 'exportPDF'])->name('data.exportPDF');
    Route::get('/data/exportPDF', [DataController::class, 'exportPDF'])->name('data.exportPDF');

    // Route::get('/data/{id}', [DataController::class, 'show'])->name('data.show');
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user', UserController::class);
    Route::get('/my-profile', [ProfileController::class, 'index'])->name('user.myprofile');
    Route::resource('profile', ProfileController::class);
    Route::resource('role', RoleController::class);

    // input
    Route::get('/pegawai/byopd', [DataController::class, 'getPegawaiByOpd'])->name('pegawai.byopd');
});
// Route::get('data', [DataController::class,'data'])->name('laporan.data');
// Route::get('data-mentah', [DataController::class,'getDataMentah'])->name('laporan.data-mentah');

// validator pembayaran
// Route::middleware(['auth', 'role:Payment Validator'])->group(function () {
//     Route::resource('user', UserController::class);
//     Route::get('/validate-pembayaran', [PembayaranTemuanController::class, 'validateList'])->name('pembayaran.validate.list');
//     Route::patch('/validate-pembayaran/{pembayaran}', [PembayaranTemuanController::class, 'validatePayment'])->name('pembayaran.validate');
// });


Auth::routes();


// profile
// Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
