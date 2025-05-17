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
    return view('landing_page');
})->name('landing_page');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::view('dashboard', 'admin.dashboard')
        ->name('dashboard');
    Route::view('students-data', 'admin.students-data')
        ->name('students-data');
    Route::view('detail-students', 'admin.students-detail')
        ->name('detail-students');
});

require __DIR__ . '/auth.php';


    Route::view('mahasiswa/dashboard', 'mahasiswa.dashboard')
        ->name('mahasiswa.dashboard');
    Route::view('mahasiswa/pengajuan-magang', 'mahasiswa.pengajuan_magang')
        ->name('mahasiswa.pengajuan-magang');
    Route::view('mahasiswa/pembaruan-status', 'mahasiswa.pembaruan_status')
        ->name('mahasiswa.pembaruan-status');
    Route::view('mahasiswa/log-mahasiswa', 'mahasiswa.log_mahasiswa')
        ->name('mahasiswa.log-mahasiswa');
    Route::view('mahasiswa/setting-profile', 'mahasiswa.setting_profile')
        ->name('mahasiswa.setting-profile');