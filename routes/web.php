<?php

use App\Http\Controllers\KontakKamiController;
use App\Http\Controllers\PermohonanInformasiController;
use App\Http\Controllers\ProfilKantorController;
use Illuminate\Support\Facades\Auth;
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


// Home
Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');
Route::post('/kontakkami', [App\Http\Controllers\User\HomeController::class, 'kontakkami'])->name('kontakkami');

// Informasi Publik
Route::get('/daftar-informasi-publik', [App\Http\Controllers\User\InformasiPublikController::class, 'index'])->name('infopub');
Route::get('/daftar-informasi-publik/download/{informasipublik}', [App\Http\Controllers\User\InformasiPublikController::class, 'download'])->name('download.infopub');

Route::get('/pemohon', [PermohonanInformasiController::class, 'index'])->name('pemohon.register');

Route::get('/pemohon/lembaga', [PermohonanInformasiController::class, 'indexlembaga'])->name('lembaga.register');
Route::post('/pemohon/lembaga', [PermohonanInformasiController::class, 'storelembaga'])->name('lembaga.register.store');

Route::get('/pemohon/perorangan', [PermohonanInformasiController::class, 'indexperorangan'])->name('perorangan.register');
Route::post('/pemohon/perorangan', [PermohonanInformasiController::class, 'storeperorangan'])->name('perorangan.register.store');

// Statistik
Route::get('/statistik', [App\Http\Controllers\User\StatisticController::class, 'index'])->name('statistik');



Auth::routes(['register' => false]);

// Route Admin
Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/akun', [App\Http\Controllers\Admin\DashboardController::class, 'akun'])->name('akun');
    Route::put('/akun/update/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'akunupdate'])->name('akun.update');
    Route::get('/akun/password', [App\Http\Controllers\Admin\DashboardController::class, 'akunpassword'])->name('password');
    Route::put('/akun/password/update/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'akunpasswordupdate'])->name('password.update');

    //  Klasifikasi
    Route::resource('/klasifikasi', App\Http\Controllers\Admin\KlasifikasiController::class)->except('show');

    // Informasi Publikasi
    Route::resource('/infopub', App\Http\Controllers\Admin\InformasiPublikController::class);

    // Permohonan Informasi
    Route::resource('/permohonaninformasi', App\Http\Controllers\Admin\PermohonanInformasiController::class);
    Route::get('/permohonaninformasi/proses/{permohonaninformasi}', [App\Http\Controllers\Admin\PermohonanInformasiController::class, 'proses'])->name('permohonaninformasi.proses');
    Route::put('/permohonaninformasi/terima/{permohonaninformasi}', [App\Http\Controllers\Admin\PermohonanInformasiController::class, 'terima'])->name('permohonaninformasi.terima');
    Route::put('/permohonaninformasi/batalterima/{permohonaninformasi}', [App\Http\Controllers\Admin\PermohonanInformasiController::class, 'batalterima'])->name('permohonaninformasi.batalterima');
    Route::put('/permohonaninformasi/sendterima/{id}', [App\Http\Controllers\Admin\PermohonanInformasiController::class, 'sendterima'])->name('permohonaninformasi.sendterima');
    Route::put('/permohonaninformasi/tolak/{permohonaninformasi}', [App\Http\Controllers\Admin\PermohonanInformasiController::class, 'tolak'])->name('permohonaninformasi.tolak');
    Route::put('/permohonaninformasi/sendtolak/{permohonaninformasi}', [App\Http\Controllers\Admin\PermohonanInformasiController::class, 'sendtolak'])->name('permohonaninformasi.sendtolak');


    // Pengajuan Keberatan
    Route::resource('/pengajuankeberatan', App\Http\Controllers\Admin\PengajuanKeberatanController::class);
    Route::put('/pengajuankeberatan/terima/{id}', [App\Http\Controllers\Admin\PengajuanKeberatanController::class, 'terima'])->name('pengajuankeberatan.terima');
    Route::put('/pengajuankeberatan/tolak/{pengajuankeberatan}', [App\Http\Controllers\Admin\PengajuanKeberatanController::class, 'tolak'])->name('pengajuankeberatan.tolak');
    Route::put('/pengajuankeberatan/sendterima/{id}', [App\Http\Controllers\Admin\PengajuanKeberatanController::class, 'sendterima'])->name('pengajuankeberatan.sendterima');
    Route::put('/pengajuankeberatan/sendtolak/{id}', [App\Http\Controllers\Admin\PengajuanKeberatanController::class, 'sendtolak'])->name('pengajuankeberatan.sendtolak');
    Route::get('/getpermohonaninformasi/{permohonaninformasi}', [App\Http\Controllers\Admin\PengajuanKeberatanController::class, 'getPermohonanInformasi']);

    Route::get('/petugas', [App\Http\Controllers\Admin\DashboardController::class, 'user'])->name('petugas');
    Route::get('/petugas/create', [App\Http\Controllers\Admin\DashboardController::class, 'usercreate'])->name('petugas.create');
    Route::post('/petugas/store', [App\Http\Controllers\Admin\DashboardController::class, 'userstore'])->name('petugas.store');
    Route::get('/petugas/password/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userpassword'])->name('petugas.password');
    Route::get('/pemohon/password/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userpassword'])->name('pemohon.password');
    Route::put('/petugas/password/update/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userpasswordupdate'])->name('password.update');
    Route::get('/pemohon', [App\Http\Controllers\Admin\DashboardController::class, 'user'])->name('pemohon');
    Route::get('/petugas/show/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'usershow'])->name('petugas.show');
    Route::get('/pemohon/show/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'usershow'])->name('pemohon.show');
    Route::get('/petugas/edit/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'useredit'])->name('petugas.edit');
    Route::get('/pemohon/edit/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'useredit'])->name('pemohon.edit');
    Route::put('/petugas/update/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userupdate'])->name('petugas.update');
    Route::put('/pemohon/update/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userupdate'])->name('pemohon.update');
    Route::delete('/petugas/destroy/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userdestroy'])->name('petugas.destroy');
    Route::delete('/pemohon/destroy/{id}', [App\Http\Controllers\Admin\DashboardController::class, 'userdestroy'])->name('pemohon.destroy');

    // Profil Kantor
    Route::get('/profilkantor', [ProfilKantorController::class, 'index'])->name('profilkantor');
    Route::put('/profilkantor/update/{id}', [ProfilKantorController::class, 'update'])->name('profilkantor.update');

    // Kotak Pesan
    Route::get('/kotakpesan', [KontakKamiController::class, 'index'])->name('kotakpesan');
    Route::delete('/kotakpesan/destroy/{id}', [KontakKamiController::class, 'destroy'])->name('kotakpesan.destroy');

    // Report
    Route::get('/laporan', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('report.index');
    Route::get('/laporan/search', [App\Http\Controllers\Admin\ReportController::class, 'search'])->name('report.search');

    // Role
    Route::resource('/role', \App\Http\Controllers\Admin\RoleAndPermissionController::class);
});
