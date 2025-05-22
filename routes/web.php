<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PengajuanMagangController;

Route::view('/', 'pages.landing-page')->name('landing-page');

Route::middleware(['auth'])
    ->group(function () {
        Route::redirect('settings', 'settings/profile');

        Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
        Volt::route('settings/password', 'settings.password')->name('settings.password');
        Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

        Route::view('dashboard', 'pages.admin.dashboard')->name('dashboard');
        Volt::route('data-mahasiswa', 'pages.admin.kelola-data.data-mahasiswa')->name('data-mahasiswa');
        Route::view('detail-mahasiswa', 'pages.admin.kelola-data.detail-mahasiswa')->name('detail-mahasiswa');
        Volt::route('data-dosen', 'pages.admin.kelola-data.data-dosen')->name('data-dosen');
        Route::view('detail-dosen', 'pages.admin.kelola-data.detail-dosen')->name('detail-dosen');
        Volt::route('data-perusahaan', 'pages.admin.kelola-data.data-perusahaan')->name('data-perusahaan');
        Route::view('detail-perusahaan', 'pages.admin.kelola-data.detail-perusahaan')->name('detail-perusahaan');

        Volt::route('data-lowongan', 'pages.admin.magang.data-lowongan')->name('data-lowongan');
        Route::view('detail-lowongan', 'pages.admin.magang.detail-lowongan')->name('detail-lowongan');
    });

Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::view('dashboard', 'pages.mahasiswa.dashboard')->name('dashboard');
        // Pengajuan magang routes
        Route::get('pengajuan-magang', [PengajuanMagangController::class, 'index'])->name('pengajuan-magang');
        Route::get('formulir-pengajuan', [PengajuanMagangController::class, 'showForm'])->name('form-pengajuan-magang');
        Route::post('formulir-pengajuan', [PengajuanMagangController::class, 'storePengajuan'])->name('store-pengajuan-magang');

        // Other routes
        Volt::route('pembaruan-status', 'pages.mahasiswa.pembaruan-status')->name('pembaruan-status');
        Route::view('log-mahasiswa', 'pages.mahasiswa.log-mahasiswa')->name('log-mahasiswa');
        Route::get('setting-profile', [MahasiswaController::class, 'profile'])->name('setting-profile');
        Volt::route('search-perusahaan', 'pages.mahasiswa.search')->name('search-perusahaan');
    });
require __DIR__ . '/auth.php';

Route::view('dosen/dashboard', 'pages.dosen.dashboard')->name('dosen.dashboard');
Route::view('dosen/mahasiswa-bimbingan', 'pages.dosen.mahasiswa-bimbingan')->name('dosen.mahasiswa-bimbingan');
Route::view('dosen/detail-mahasiswa-bimbingan', 'pages.dosen.detail-mahasiswa-bimbingan')->name('dosen.detail-mahasiswa-bimbingan');
