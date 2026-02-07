<?php

use Illuminate\Support\Facades\Schedule;

// Sincronizza iCal ogni 15 minuti
Schedule::command('ical:sync')->everyFifteenMinutes()->withoutOverlapping();

// Invia ad AlloggiatiWeb alle 06:00 (orario fisso, configurabile dopo)
Schedule::command('alloggiatiweb:send')->dailyAt('06:00')->withoutOverlapping();

// Pulizia log vecchi (ogni domenica alle 3:00)
Schedule::call(function () {
    \App\Models\SyncLog::where('created_at', '<', now()->subDays(90))->delete();
    \App\Models\AlloggiatiwebLog::where('created_at', '<', now()->subDays(90))->delete();
})->weeklyOn(0, '03:00');