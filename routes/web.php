<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::get('/', fn() => view('home'))
    ->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    Route::view('dashboard', 'admin.dashboard')
        ->name('dashboard');
    Route::view('students-data', 'admin.students-data')
        ->name('students-data');
});

require __DIR__.'/auth.php';

Route::view('mahasiswa/dashboard', 'mahasiswa.dashboard')
    ->name('mahasiswa.dashboard');