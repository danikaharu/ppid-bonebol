<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InformasiPublikController;
use App\Http\Controllers\KontakKamiController;
use App\Http\Controllers\PengajuanKeberatanController;
use App\Http\Controllers\PermohonanInformasiController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PetugasPengajuanKeberatanController;
use App\Http\Controllers\PetugasPermohonanInformasiController;
use App\Http\Controllers\ProfilKantorController;
use App\Http\Controllers\UserController;
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

// Route::get('/home', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index'])->name('home');

Route::get('/daftar-informasi-publik', [InformasiPublikController::class, 'index'])->name('infopub');
Route::get('/daftar-informasi-publik/download/{id}', [InformasiPublikController::class, 'download'])->name('download.infopub');

Route::get('/pemohon', [PermohonanInformasiController::class, 'index'])->name('pemohon.register');

Route::get('/pemohon/lembaga', [PermohonanInformasiController::class, 'indexlembaga'])->name('lembaga.register');
Route::post('/pemohon/lembaga', [PermohonanInformasiController::class, 'storelembaga'])->name('lembaga.register.store');

Route::get('/pemohon/perorangan', [PermohonanInformasiController::class, 'indexperorangan'])->name('perorangan.register');
Route::post('/pemohon/perorangan', [PermohonanInformasiController::class, 'storeperorangan'])->name('perorangan.register.store');

Route::get('/statistik', [UserController::class, 'statistik'])->name('statistik');

Route::post('/kontakkami', [UserController::class, 'kontakkami'])->name('kontakkami');

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
    Route::resource('/klasifikasi', App\Http\Controllers\Admin\KlasifikasiController::class);

    // Informasi Publikasi
    Route::resource('/infopub', App\Http\Controllers\Admin\InformasiPublikController::class);

    // Permohonan Informasi
    Route::get('/permohonaninformasi', [PetugasPermohonanInformasiController::class, 'index'])->name('permohonaninformasi');
    Route::get('/permohonaninformasi/proses/{id}', [PetugasPermohonanInformasiController::class, 'proses'])->name('permohonaninformasi.proses');
    Route::get('/permohonaninformasi/show/{id}', [PetugasPermohonanInformasiController::class, 'show'])->name('permohonaninformasi.show');
    Route::put('/permohonaninformasi/terima/{id}', [PetugasPermohonanInformasiController::class, 'terima'])->name('permohonaninformasi.terima');
    Route::put('/permohonaninformasi/batalterima/{id}', [PetugasPermohonanInformasiController::class, 'batalterima'])->name('permohonaninformasi.batalterima');
    Route::put('/permohonaninformasi/sendterima/{id}', [PetugasPermohonanInformasiController::class, 'sendterima'])->name('permohonaninformasi.sendterima');
    Route::put('/permohonaninformasi/tolak/{id}', [PetugasPermohonanInformasiController::class, 'tolak'])->name('permohonaninformasi.tolak');
    Route::put('/permohonaninformasi/sendtolak/{id}', [PetugasPermohonanInformasiController::class, 'sendtolak'])->name('permohonaninformasi.sendtolak');

    Route::delete('/permohonaninformasi/destroy/{id}', [PermohonanInformasiController::class, 'userdestroypermohonaninformasi'])->name('permohonaninformasi.destroy');
    Route::get('/permohonaninformasi/edit/{id}', [PermohonanInformasiController::class, 'usereditpermohonaninformasi'])->name('permohonaninformasi.edit');
    Route::put('/permohonaninformasi/update/{id}', [PermohonanInformasiController::class, 'userupdatepermohonaninformasi'])->name('permohonaninformasi.update');

    // Pengajuan Keberatan
    Route::get('/pengajuankeberatan', [PetugasPengajuanKeberatanController::class, 'index'])->name('pengajuankeberatan');
    Route::get('/pengajuankeberatan/show/{id}', [PetugasPengajuanKeberatanController::class, 'show'])->name('pengajuankeberatan.show');
    Route::put('/pengajuankeberatan/terima/{id}', [PetugasPengajuanKeberatanController::class, 'terima'])->name('pengajuankeberatan.terima');
    Route::put('/pengajuankeberatan/tolak/{id}', [PetugasPengajuanKeberatanController::class, 'tolak'])->name('pengajuankeberatan.tolak');
    Route::put('/pengajuankeberatan/sendterima/{id}', [PetugasPengajuanKeberatanController::class, 'sendterima'])->name('pengajuankeberatan.sendterima');
    Route::put('/pengajuankeberatan/sendtolak/{id}', [PetugasPengajuanKeberatanController::class, 'sendtolak'])->name('pengajuankeberatan.sendtolak');

    Route::delete('/pengajuankeberatan/destroy/{id}', [PengajuanKeberatanController::class, 'destroy'])->name('pengajuankeberatan.destroy');
    Route::get('/pengajuankeberatan/edit/{id}', [PengajuanKeberatanController::class, 'edit'])->name('pengajuankeberatan.edit');
    Route::put('/pengajuankeberatan/update/{id}', [PengajuanKeberatanController::class, 'update'])->name('pengajuankeberatan.update');
    Route::get('/getpermohonaninformasi/{id}', [PengajuanKeberatanController::class, 'getPermohonanInformasi']);

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

    Route::get('/profilkantor', [ProfilKantorController::class, 'index'])->name('profilkantor');
    Route::put('/profilkantor/update/{id}', [ProfilKantorController::class, 'update'])->name('profilkantor.update');
    Route::get('/kotakpesan', [KontakKamiController::class, 'index'])->name('kotakpesan');
    Route::delete('/kotakpesan/destroy/{id}', [KontakKamiController::class, 'destroy'])->name('kotakpesan.destroy');

    Route::get('/laporan', [App\Http\Controllers\Admin\DashboardController::class, 'laporan'])->name('laporan');
    Route::get('/laporan/search', [App\Http\Controllers\Admin\DashboardController::class, 'laporansearch'])->name('laporan.search');
});

// Route Petugas
Route::group(['middleware' => ['auth', 'role:petugas'], 'prefix' => 'petugas'], function () {
    Route::get('/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');
    Route::get('/akun', [PetugasController::class, 'akun'])->name('petugas.akun');
    Route::put('/akun/update/{id}', [PetugasController::class, 'akunupdate'])->name('petugas.akun.update');
    Route::get('/akun/password', [PetugasController::class, 'akunpassword'])->name('petugas.password');
    Route::put('/akun/password/update/{id}', [PetugasController::class, 'akunpasswordupdate'])->name('petugas.password.update');

    // Permohonan Informasi
    Route::get('/permohonaninformasi', [PetugasPermohonanInformasiController::class, 'index'])->name('petugas.permohonaninformasi');
    Route::get('/permohonaninformasi/proses/{id}', [PetugasPermohonanInformasiController::class, 'proses'])->name('petugas.permohonaninformasi.proses');
    Route::get('/permohonaninformasi/show/{id}', [PetugasPermohonanInformasiController::class, 'show'])->name('petugas.permohonaninformasi.show');
    Route::put('/permohonaninformasi/terima/{id}', [PetugasPermohonanInformasiController::class, 'terima'])->name('petugas.permohonaninformasi.terima');
    Route::put('/permohonaninformasi/batalterima/{id}', [PetugasPermohonanInformasiController::class, 'batalterima'])->name('petugas.permohonaninformasi.batalterima');
    Route::put('/permohonaninformasi/sendterima/{id}', [PetugasPermohonanInformasiController::class, 'sendterima'])->name('petugas.permohonaninformasi.sendterima');
    Route::put('/permohonaninformasi/tolak/{id}', [PetugasPermohonanInformasiController::class, 'tolak'])->name('petugas.permohonaninformasi.tolak');
    Route::put('/permohonaninformasi/sendtolak/{id}', [PetugasPermohonanInformasiController::class, 'sendtolak'])->name('petugas.permohonaninformasi.sendtolak');

    // Pengajuan Keberatan
    Route::get('/pengajuankeberatan', [PetugasPengajuanKeberatanController::class, 'index'])->name('petugas.pengajuankeberatan');
    Route::get('/pengajuankeberatan/show/{id}', [PetugasPengajuanKeberatanController::class, 'show'])->name('petugas.pengajuankeberatan.show');
    Route::put('/pengajuankeberatan/terima/{id}', [PetugasPengajuanKeberatanController::class, 'terima'])->name('petugas.pengajuankeberatan.terima');
    Route::put('/pengajuankeberatan/tolak/{id}', [PetugasPengajuanKeberatanController::class, 'tolak'])->name('petugas.pengajuankeberatan.tolak');
    Route::put('/pengajuankeberatan/sendterima/{id}', [PetugasPengajuanKeberatanController::class, 'sendterima'])->name('petugas.pengajuankeberatan.sendterima');
    Route::put('/pengajuankeberatan/sendtolak/{id}', [PetugasPengajuanKeberatanController::class, 'sendtolak'])->name('petugas.pengajuankeberatan.sendtolak');
});

// Route User
Route::group(['middleware' => ['auth', 'role:user'], 'prefix' => 'user'], function () {
    Route::get('/dashboard', [UserController::class, 'indexlogin'])->name('user.dashboard');
    Route::get('/akun', [UserController::class, 'akun'])->name('user.akun');
    Route::put('/akun/update/{id}', [UserController::class, 'akunupdate'])->name('user.akun.update');
    Route::get('/akun/password', [UserController::class, 'akunpassword'])->name('user.password');
    Route::put('/akun/password/update/{id}', [UserController::class, 'akunpasswordupdate'])->name('user.password.update');

    // Permohonan Informasi
    Route::get('/permohonaninformasi', [PermohonanInformasiController::class, 'userpermohonaninformasi'])->name('user.permohonaninformasi');
    Route::get('/permohonaninformasi/create', [PermohonanInformasiController::class, 'usercreatepermohonaninformasi'])->name('user.permohonaninformasi.create');
    Route::post('/permohonaninformasi/store', [PermohonanInformasiController::class, 'userstorepermohonaninformasi'])->name('user.permohonaninformasi.store');
    Route::get('/permohonaninformasi/show/{id}', [PermohonanInformasiController::class, 'usershowpermohonaninformasi'])->name('user.permohonaninformasi.show');
    Route::get('/permohonaninformasi/edit/{id}', [PermohonanInformasiController::class, 'usereditpermohonaninformasi'])->name('user.permohonaninformasi.edit');
    Route::put('/permohonaninformasi/update/{id}', [PermohonanInformasiController::class, 'userupdatepermohonaninformasi'])->name('user.permohonaninformasi.update');
    Route::delete('/permohonaninformasi/destroy/{id}', [PermohonanInformasiController::class, 'userdestroypermohonaninformasi'])->name('user.permohonaninformasi.destroy');

    // Pengajuan Keberatan
    Route::get('/pengajuankeberatan', [PengajuanKeberatanController::class, 'index'])->name('user.pengajuankeberatan');
    Route::get('/pengajuankeberatan/create', [PengajuanKeberatanController::class, 'create'])->name('user.pengajuankeberatan.create');
    Route::get('/getpermohonaninformasi/{id}', [PengajuanKeberatanController::class, 'getPermohonanInformasi']);
    Route::post('/pengajuankeberatan/store', [PengajuanKeberatanController::class, 'store'])->name('user.pengajuankeberatan.store');
    Route::get('/pengajuankeberatan/show/{id}', [PengajuanKeberatanController::class, 'show'])->name('user.pengajuankeberatan.show');
    Route::get('/pengajuankeberatan/edit/{id}', [PengajuanKeberatanController::class, 'edit'])->name('user.pengajuankeberatan.edit');
    Route::put('/pengajuankeberatan/update/{id}', [PengajuanKeberatanController::class, 'update'])->name('user.pengajuankeberatan.update');
    Route::delete('/pengajuankeberatan/destroy/{id}', [PengajuanKeberatanController::class, 'destroy'])->name('user.pengajuankeberatan.destroy');
});    

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/login', [LoginController::class, 'index']);
// Route::post('/login', [LoginController::class, 'authenticate']);