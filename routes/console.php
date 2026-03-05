<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Schedule;

// Sincronizza iCal ogni 15 minuti
Schedule::command('ical:sync')->everyFifteenMinutes()->withoutOverlapping();

// Invia ad AlloggiatiWeb all'orario configurato
$sendTime = Setting::get('send_time', '06:00');
Schedule::command('alloggiatiweb:send')->dailyAt($sendTime)->withoutOverlapping();

// Pulizia log vecchi (ogni domenica alle 3:00)
Schedule::call(function () {
    \App\Models\SyncLog::where('created_at', '<', now()->subDays(90))->delete();
    \App\Models\AlloggiatiwebLog::where('created_at', '<', now()->subDays(90))->delete();
})->weeklyOn(0, '03:00');
