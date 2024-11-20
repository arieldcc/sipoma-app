<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\CalonController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GaleryKegiatanController;
use App\Http\Controllers\KeanggotaanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\KepanitiaanController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\PeriodeController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::controller(DashboardController::class)->group(function(){
    Route::get('/dashboard', 'index');
});

Route::middleware(['auth'])->group(function(){
    Route::controller(AnggotaController::class)->group(function(){
        Route::get('/anggota', 'index');
        Route::get('/anggota/create', 'create');
        Route::post('/anggota/store', 'store');
        Route::get('/anggota/{id}', 'show_detail');
        Route::get('/anggota/{id}/edit', 'show_edit');
        Route::put('/anggota/{id}', 'update');
        Route::delete('/anggota/{id}', 'delete');
    });

    Route::controller(KeanggotaanController::class)->group(function(){
        Route::get('/keanggotaan', 'index');
        Route::get('/keanggotaan/create', 'create');
        Route::post('/keanggotaan/store', 'store');
        Route::get('/keanggotaan/{id}', 'show_detail');
        Route::get('/keanggotaan/{id}/edit', 'show_edit');
        Route::put('/keanggotaan/{id}', 'update');

        // lakukan perubahan data secara langsung pada halaman data awal
        Route::put('/keanggotaan/{id}/update-status', 'update_status');
        Route::put('/keanggotaan/{id}/update-tanggal-keluar', 'update_tanggal_keluar');

        Route::delete('/keanggotaan/{id}', 'delete');
    });

    Route::controller(PengurusController::class)->group(function(){
        Route::get('/pengurus', 'index');
        Route::get('/pengurus/create', 'create');
        Route::post('/pengurus/store', 'store');
        Route::get('/pengurus/{id}', 'show_detail');
        Route::get('/pengurus/{id}/edit', 'show_edit');
        Route::put('/pengurus/{id}', 'update');
        Route::delete('/pengurus/{id}', 'delete');
    });

    Route::controller(KegiatanController::class)->group(function(){
        Route::get('/kegiatan', 'index');
        Route::get('/kegiatan/create', 'create');
        Route::post('/kegiatan/store', 'store');
        Route::get('/kegiatan/{id}', 'show_detail');
        Route::get('/kegiatan/{id}/edit', 'show_edit');
        Route::put('/kegiatan/{id}', 'update');
        Route::delete('/kegiatan/{id}', 'delete');
    });

    Route::controller(KepanitiaanController::class)->group(function(){
        Route::get('/kepanitiaan', 'index');
        Route::get('/kepanitiaan/create', 'create');
        Route::post('/kepanitiaan/store', 'store');
        Route::get('/kepanitiaan/get-anggota/{id}', 'getAvailableAnggota');
        Route::get('/kepanitiaan/{id}', 'show_detail');
        Route::get('/kepanitiaan/{id}/edit', 'show_edit');
        Route::put('/kepanitiaan/{id}', 'update');
        Route::delete('/kepanitiaan/{id}', 'delete');
    });

    Route::controller(KeuanganController::class)->group(function(){
        Route::get('/keuangan', 'index');
        Route::get('/keuangan/create', 'create');
        Route::post('/keuangan/store', 'store');
        Route::get('/keuangan/{id}', 'show_detail');
        Route::get('/keuangan/{id}/edit', 'show_edit');
        Route::put('/keuangan/{id}', 'update');
        Route::delete('/keuangan/{id}', 'delete');
    });

    Route::controller(PrestasiController::class)->group(function(){
        Route::get('/prestasi', 'index');
        Route::get('/prestasi/create', 'create');
        Route::post('/prestasi/store', 'store');
        Route::get('/prestasi/{id}', 'show_detail');
        Route::get('/prestasi/{id}/edit', 'show_edit');
        Route::put('/prestasi/{id}', 'update');
        Route::delete('/prestasi/{id}', 'delete');
    });


    Route::controller(PeriodeController::class)->group(function(){
        Route::get('/periode', 'index');
        Route::get('/periode/create', 'create');
        Route::post('/periode/store', 'store');
        Route::get('/periode/{id}/edit', 'show_edit');
        Route::put('/periode/{id}', 'update');
        Route::delete('/periode/{id}', 'delete');

        Route::post('/periode/toggle-status/{id}', 'toggleStatus');
    });

    Route::controller(OrganisasiController::class)->group(function(){
        Route::get('/organisasi', 'index');
        Route::get('/organisasi/create', 'create');
        Route::post('/organisasi/store', 'store');
        Route::get('/organisasi/{id}', 'show_detail');
        Route::get('/organisasi/{id}/edit', 'show_edit');
        Route::put('/organisasi/{id}', 'update');
        Route::delete('/organisasi/{id}', 'delete');
    });

    Route::controller(GaleryKegiatanController::class)->group(function(){
        Route::get('/galery', 'index');
        Route::get('/galery/create', 'create');
        Route::post('/galery/store', 'store');
        Route::delete('/galery/{id}', 'delete');
    });

    Route::controller(UserController::class)->group(function(){
        Route::get('/user-manajemen', 'index');
        Route::get('/user-manajemen/create', 'create');
        Route::post('/user-manajemen/store', 'store');
        Route::get('/user-manajemen/{id}/edit', 'edit');
        Route::put('/user-manajemen/{id}', 'update');
        Route::delete('/user-manajemen/{id}', 'delete');
    });


});

Route::controller(CalonController::class)->group(function(){
    Route::get('/calon', 'index');
});

Route::get('/struktur-organisasi', [OrganisasiController::class, 'showStrukturOrganisasi'])->name('struktur-organisasi');

Auth::routes();

Route::get('/home', [DashboardController::class, 'index'])->name('home');
