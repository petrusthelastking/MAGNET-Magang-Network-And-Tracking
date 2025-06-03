<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\PengajuanMagangController;
use App\Http\Controllers\UserController;

require_once __DIR__ . '/auth.php';

Route::view('/', 'pages.landing-page')->name('landing-page');

Route::middleware('role:admin,mahasiswa,dosen')
    ->group(function () {
        Route::get('dashboard', [UserController::class, 'showDashboard'])->name('dashboard');
        Route::get('profile', [UserController::class, 'showProfile'])->name('profile');
});

Route::name('admin.')
    ->middleware('role:admin')
    ->group(function () {
        Volt::route('data-mahasiswa', 'pages.admin.kelola-data.data-mahasiswa')->name('data-mahasiswa');
        Volt::route('detail-mahasiswa/{id}', 'pages.admin.kelola-data.detail-mahasiswa')->name('detail-mahasiswa');

        Volt::route('data-dosen', 'pages.admin.kelola-data.data-dosen')->name('data-dosen');
        Volt::route('detail-dosen/{id}', 'pages.admin.kelola-data.detail-dosen')->name('detail-dosen');

        Volt::route('data-perusahaan', 'pages.admin.kelola-data.data-perusahaan')->name('data-perusahaan');
        Volt::route('detail-perusahaan/{id}', 'pages.admin.kelola-data.detail-perusahaan')->name('detail-perusahaan');

        Volt::route('data-lowongan', 'pages.admin.magang.data-lowongan')->name('data-lowongan');
        Route::view('detail-lowongan', 'pages.admin.magang.detail-lowongan')->name('detail-lowongan');

        Volt::route('data-pengajuan-magang', 'pages.admin.magang.data-pengajuan')->name('data-pengajuan-magang');
        Volt::route('detail-pengajuan/{id}', 'pages.admin.magang.detail-pengajuan')->name('detail-pengajuan');

        Route::view('statistik-magang', 'pages.admin.magang.statistik-magang')->name('statistik-magang');

        Route::view('perusahaan-terpopuler', 'pages.admin.magang.perusahaan-terpopuler')->name('perusahaan-terpopuler'); 
        Route::view('aturan-magang', 'pages.admin.magang.aturan-magang')->name('aturan-magang');
});


Route::name('mahasiswa.')
    ->middleware('role:mahasiswa')
    ->group(function () {
        Volt::route('persiapan', 'pages.mahasiswa.persiapan-preferensi')->name('persiapan-preferensi');
        Volt::route('pengajuan-magang', 'pages.mahasiswa.pengajuan-magang.pengajuan-magang')->name('pengajuan-magang');
        Volt::route('formulir-pengajuan', 'pages.mahasiswa.pengajuan-magang.formulir-pengajuan')->name('form-pengajuan-magang');
        Route::post('formulir-pengajuan', [PengajuanMagangController::class, 'storePengajuan'])->name('store-pengajuan-magang');

        Route::view('konsul-dospem', 'pages.mahasiswa.konsul-dospem')->name('konsul-dospem');
        Volt::route('pembaruan-status', 'pages.mahasiswa.pembaruan-status')->name('pembaruan-status');
        Route::view('log-mahasiswa', 'pages.mahasiswa.log-mahasiswa')->name('log-mahasiswa');
        Volt::route('search', 'pages.mahasiswa.search')->name('search');
        Route::view('/detail-perusahaan', 'components.mahasiswa.detail-perusahaan')->name('detail-perusahaan');
    });

Route::name('dosen.')
    ->middleware('role:dosen')
    ->group(function () {
        Route::view('mahasiswa-bimbingan', 'pages.dosen.mahasiswa-bimbingan')->name('mahasiswa-bimbingan');
        Route::view('detail-mahasiswa-bimbingan', 'pages.dosen.detail-mahasiswa-bimbingan')->name('detail-mahasiswa-bimbingan');
        Route::view('komunikasi', 'pages.dosen.komunikasi-mahasiswa')->name('komunikasi');
});

Route::view('data-pendukung', 'pages.auth.data-pendukung')->name('data-pendukung');
