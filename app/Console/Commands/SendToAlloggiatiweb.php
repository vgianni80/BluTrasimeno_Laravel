<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Services\AlloggiatiwebService;
use Illuminate\Console\Command;

class SendToAlloggiatiweb extends Command
{
    protected $signature = 'alloggiatiweb:send {--booking= : ID specifico}';
    protected $description = 'Invia dati ad AlloggiatiWeb';

    public function handle(AlloggiatiwebService $service): int
    {
        if ($bookingId = $this->option('booking')) {
            $booking = Booking::find($bookingId);
            
            if (!$booking) {
                $this->error("Prenotazione #{$bookingId} non trovata");
                return Command::FAILURE;
            }

            $this->info("Invio prenotazione #{$bookingId}...");
            
            if ($service->sendBooking($booking)) {
                $this->info('✓ Invio completato!');
                return Command::SUCCESS;
            }

            $this->error('✗ Errore: ' . $booking->last_error);
            return Command::FAILURE;
        }

        $this->info('Invio giornaliero AlloggiatiWeb...');
        $results = $service->sendDailyBookings();

        if ($results['skipped'] ?? false) {
            $this->warn('AlloggiatiWeb non abilitato');
            return Command::SUCCESS;
        }

        $this->info("Totale: {$results['total']}, OK: {$results['success']}, Errori: {$results['failed']}");

        return $results['failed'] > 0 ? Command::FAILURE : Command::SUCCESS;
    }
}
