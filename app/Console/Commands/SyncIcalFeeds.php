<?php

namespace App\Console\Commands;

use App\Services\IcalSyncService;
use Illuminate\Console\Command;

class SyncIcalFeeds extends Command
{
    protected $signature = 'ical:sync';
    protected $description = 'Sincronizza tutti i calendari iCal';

    public function handle(IcalSyncService $service): int
    {
        $this->info('Sincronizzazione iCal in corso...');
        
        $result = $service->syncAll();

        $this->info("Fonti sincronizzate: {$result['sources_synced']}");
        $this->info("Nuove prenotazioni: {$result['bookings_created']}");

        return Command::SUCCESS;
    }
}
