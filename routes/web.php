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
    Route::view('data-mahasiswa', 'admin.data-mahasiswa')
        ->name('data-mahasiswa');
    Route::view('detail-mahasiswa', 'admin.detail-mahasiswa')
        ->name('detail-mahasiswa');
    Route::view('data-dosen', 'admin.data-dosen')
        ->name('data-dosen');
    Route::view('detail-dosen', 'admin.detail-dosen')
        ->name('detail-dosen');
});

require __DIR__ . '/auth.php';
