<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\IcalSourceController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CheckinController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

// Check-in pubblico
Route::get('/checkin/{token}', [CheckinController::class, 'show'])->name('checkin.show');
Route::post('/checkin/{token}', [CheckinController::class, 'store'])->name('checkin.store');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Prenotazioni
    Route::resource('bookings', BookingController::class);
    Route::post('bookings/{booking}/generate-link', [BookingController::class, 'generateLink'])
        ->name('bookings.generate-link');
    Route::post('bookings/{booking}/send-checkin-email', [BookingController::class, 'sendCheckinEmail'])
        ->name('bookings.send-checkin-email');
    Route::post('bookings/{booking}/resend-alloggiatiweb', [BookingController::class, 'resendAlloggiatiweb'])
        ->name('bookings.resend-alloggiatiweb');

    // Fonti iCal
    Route::resource('ical-sources', IcalSourceController::class)->parameters([
        'ical-sources' => 'icalSource'
    ]);
    Route::post('ical-sources/{icalSource}/sync', [IcalSourceController::class, 'sync'])
        ->name('ical-sources.sync');

    // Impostazioni
    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/test-alloggiatiweb', [SettingsController::class, 'testAlloggiatiweb'])
        ->name('settings.test-alloggiatiweb');

    // Log
    Route::get('logs', [LogsController::class, 'index'])->name('logs.index');
});
