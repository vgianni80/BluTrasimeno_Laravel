<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HoliduImportController;
use App\Http\Controllers\Admin\IcalSourceController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\PublicBookingController as AdminPublicBookingController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\IcalExportController;
use App\Http\Controllers\PublicBookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect()->route('login'));

// Export iCal pubblico (per Holidu, Booking, Airbnb, ecc.)
Route::get('/calendar/export.ics', [IcalExportController::class, 'export'])->name('ical.export');
Route::get('/calendar.ics', [IcalExportController::class, 'export']); // URL alternativo più corto

// Check-in pubblico
Route::get('/checkin/{token}', [CheckinController::class, 'show'])->name('checkin.show');
Route::post('/checkin/{token}', [CheckinController::class, 'store'])->name('checkin.store');

/*
|--------------------------------------------------------------------------
| Public Booking Routes
|--------------------------------------------------------------------------
*/

Route::prefix('prenota')->name('public.booking.')->group(function () {
    Route::get('/', [PublicBookingController::class, 'index'])->name('index');
    Route::get('/calendar', [PublicBookingController::class, 'getCalendar'])->name('calendar');
    Route::post('/calculate', [PublicBookingController::class, 'calculatePrice'])->name('calculate');
    Route::post('/availability', [PublicBookingController::class, 'checkAvailability'])->name('availability');
    Route::post('/', [PublicBookingController::class, 'store'])->name('store');
    Route::get('/conferma/{publicBooking}', [PublicBookingController::class, 'success'])->name('success');
});

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

    // Import Holidu (prima del resource per evitare conflitti con {booking})
    Route::get('bookings/import', [HoliduImportController::class, 'form'])->name('bookings.import');
    Route::post('bookings/import', [HoliduImportController::class, 'import'])->name('bookings.import.store');

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

    // Tariffe
    Route::prefix('pricing')->name('pricing.')->group(function () {
        Route::get('/', [PricingController::class, 'index'])->name('index');
        Route::get('/rules/create', [PricingController::class, 'createRule'])->name('rules.create');
        Route::post('/rules', [PricingController::class, 'storeRule'])->name('rules.store');
        Route::get('/rules/{pricingRule}/edit', [PricingController::class, 'editRule'])->name('rules.edit');
        Route::put('/rules/{pricingRule}', [PricingController::class, 'updateRule'])->name('rules.update');
        Route::delete('/rules/{pricingRule}', [PricingController::class, 'destroyRule'])->name('rules.destroy');
        Route::post('/discounts', [PricingController::class, 'storeDiscount'])->name('discounts.store');
        Route::delete('/discounts/{lengthDiscount}', [PricingController::class, 'destroyDiscount'])->name('discounts.destroy');
        Route::post('/discounts/{lengthDiscount}/toggle', [PricingController::class, 'toggleDiscount'])->name('discounts.toggle');
    });

    // Richieste prenotazione pubbliche
    Route::resource('public-bookings', AdminPublicBookingController::class)->only(['index', 'show', 'destroy']);
    Route::post('public-bookings/{publicBooking}/confirm', [AdminPublicBookingController::class, 'confirm'])->name('public-bookings.confirm');
    Route::post('public-bookings/{publicBooking}/reject', [AdminPublicBookingController::class, 'reject'])->name('public-bookings.reject');
});
