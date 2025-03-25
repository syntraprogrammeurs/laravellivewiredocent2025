<?php

use App\Livewire\Users\ShowUsers;
use App\Livewire\Users\CreateUser;
use App\Livewire\Users\EditUser;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
    Route::get('/users', ShowUsers::class)->name('users.index');
    Route::get('/users/create', CreateUser::class)->name('users.create');
    Route::get('/users/{user}/edit', EditUser::class)->name('users.edit');

    // Role routes
    Route::get('/roles', \App\Livewire\Roles\ShowRoles::class)->name('roles.index');
    Route::get('/roles/create', \App\Livewire\Roles\CreateRole::class)->name('roles.create');
    Route::get('/roles/{role}/edit', \App\Livewire\Roles\EditRole::class)->name('roles.edit');
});

require __DIR__.'/auth.php';
