<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.landing-page');
})->name('landing-page');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::view('dashboard', 'pages.admin.dashboard')
        ->name('dashboard');
    Route::view('data-mahasiswa', 'pages.admin.data-mahasiswa')
        ->name('data-mahasiswa');
    Route::view('detail-mahasiswa', 'pages.admin.detail-mahasiswa')
        ->name('detail-mahasiswa');
    Route::view('data-dosen', 'pages.admin.data-dosen')
        ->name('data-dosen');
    Route::view('detail-dosen', 'pages.admin.detail-dosen')
        ->name('detail-dosen');
});

require __DIR__ . '/auth.php';


Route::view('mahasiswa/dashboard', 'pages.mahasiswa.dashboard')
    ->name('mahasiswa.dashboard');
Route::view('mahasiswa/pengajuan-magang', 'pages.mahasiswa.pengajuan_magang')
    ->name('mahasiswa.pengajuan-magang');
Volt::route('/mahasiswa/pembaruan-status', 'pages.mahasiswa.pembaruan-status')
    ->name('mahasiswa.pembaruan-status');
Route::view('mahasiswa/log-mahasiswa', 'pages.mahasiswa.log_mahasiswa')
    ->name('mahasiswa.log-mahasiswa');
Route::view('mahasiswa/setting-profile', 'pages.mahasiswa.setting_profile')
    ->name('mahasiswa.setting-profile');
