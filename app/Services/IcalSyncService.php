<?php

namespace App\Services;

use App\Mail\NewBookingNotification;
use App\Models\Booking;
use App\Models\IcalSource;
use App\Models\Setting;
use App\Models\SyncLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Sabre\VObject\Reader;
use Exception;

class IcalSyncService
{
    public function syncAll(): array
    {
        $sources = IcalSource::active()->get();
        $totalCreated = 0;
        $newBookings = collect();

        foreach ($sources as $source) {
            if ($source->shouldSync()) {
                $log = $this->syncSource($source);
                $totalCreated += $log->bookings_created;
                
                if ($log->bookings_created > 0) {
                    $recent = Booking::where('ical_source_id', $source->id)
                        ->where('status', 'incomplete')
                        ->where('created_at', '>=', now()->subMinutes(5))
                        ->get();
                    $newBookings = $newBookings->merge($recent);
                }
            }
        }

        if ($newBookings->isNotEmpty()) {
            $this->sendNotificationEmail($newBookings);
        }

        return [
            'sources_synced' => $sources->count(),
            'bookings_created' => $totalCreated,
        ];
    }

    public function syncSource(IcalSource $source): SyncLog
    {
        $log = new SyncLog([
            'ical_source_id' => $source->id,
            'synced_at' => now(),
        ]);

        try {
            $response = Http::timeout(30)->get($source->url);

            if (!$response->successful()) {
                throw new Exception("HTTP Error: {$response->status()}");
            }

            $vcalendar = Reader::read($response->body());
            
            $found = 0;
            $created = 0;
            $updated = 0;

            if (isset($vcalendar->VEVENT)) {
                foreach ($vcalendar->VEVENT as $event) {
                    $found++;
                    $result = $this->processEvent($event, $source);
                    
                    if ($result === 'created') $created++;
                    elseif ($result === 'updated') $updated++;
                }
            }

            $log->fill([
                'status' => 'success',
                'message' => 'Sync completata',
                'bookings_found' => $found,
                'bookings_created' => $created,
                'bookings_updated' => $updated,
            ]);

            $source->markAsSynced();

        } catch (Exception $e) {
            Log::error("iCal Sync Error [{$source->name}]: {$e->getMessage()}");

            $log->fill([
                'status' => 'error',
                'message' => $e->getMessage(),
                'bookings_found' => 0,
                'bookings_created' => 0,
                'bookings_updated' => 0,
            ]);
        }

        $log->save();
        return $log;
    }

    protected function processEvent($event, IcalSource $source): string
    {
        $uid = (string) $event->UID;
        $summary = (string) ($event->SUMMARY ?? '');
        $description = (string) ($event->DESCRIPTION ?? '');
        
        $checkIn = $event->DTSTART->getDateTime();
        $checkOut = $event->DTEND ? $event->DTEND->getDateTime() : null;

        // Ignora eventi passati
        if ($checkIn < now()->startOfDay()) {
            return 'skipped';
        }

        $booking = Booking::where('ical_uid', $uid)->first();

        $data = [
            'ical_source_id' => $source->id,
            'ical_uid' => $uid,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'ical_raw_data' => [
                'summary' => $summary,
                'description' => $description,
            ],
        ];

        // Estrai nome e cognome dal summary
        $guestInfo = $this->extractGuestName($summary, $description);
        if ($guestInfo['name']) {
            $data['guest_name'] = $guestInfo['name'];
        }
        if ($guestInfo['surname']) {
            $data['guest_surname'] = $guestInfo['surname'];
        }
        if ($guestInfo['email']) {
            $data['guest_email'] = $guestInfo['email'];
        }
        if ($guestInfo['phone']) {
            $data['guest_phone'] = $guestInfo['phone'];
        }
        if ($guestInfo['guests_count']) {
            $data['number_of_guests'] = $guestInfo['guests_count'];
        }

        if ($booking) {
            if ($booking->status === 'incomplete') {
                $booking->update($data);
                return 'updated';
            }
            return 'skipped';
        }

        $data['status'] = 'incomplete';
        Booking::create($data);
        return 'created';
    }

    /**
     * Estrae nome, cognome e altre info dal summary/description iCal
     */
    protected function extractGuestName(string $summary, string $description): array
    {
        $result = [
            'name' => null,
            'surname' => null,
            'email' => null,
            'phone' => null,
            'guests_count' => null,
        ];

        // Pattern per estrarre il nome dal summary
        // Formati comuni:
        // - "Mario Rossi - Booking.com"
        // - "CLOSED - Mario Rossi"
        // - "Reserved - Mario Rossi (Airbnb)"
        // - "Mario Rossi"
        // - "Booking.com: Mario Rossi"
        
        $patterns = [
            // "Nome Cognome - Booking.com" o "Nome Cognome - Airbnb"
            '/^([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)\s*[-–]\s*(?:Booking|Airbnb|VRBO|Expedia|Hotels)/iu',
            
            // "CLOSED - Nome Cognome" o "Reserved - Nome Cognome"
            '/^(?:CLOSED|Reserved|Blocked|Not available)\s*[-–]\s*([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)/iu',
            
            // "Booking.com: Nome Cognome"
            '/^(?:Booking\.com|Airbnb|VRBO):\s*([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)/iu',
            
            // "Nome Cognome (qualcosa)"
            '/^([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)\s*\(/iu',
            
            // Solo "Nome Cognome" (almeno 2 parole)
            '/^([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)$/iu',
            
            // "Nome Cognome" all'inizio seguito da qualsiasi cosa
            '/^([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)\s+/iu',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, trim($summary), $matches)) {
                $result['name'] = ucfirst(strtolower(trim($matches[1])));
                $result['surname'] = ucfirst(strtolower(trim($matches[2])));
                break;
            }
        }

        // Se non trovato nel summary, cerca nella description
        if (!$result['name'] && $description) {
            // Cerca "Guest: Nome Cognome" o "Name: Nome Cognome"
            if (preg_match('/(?:Guest|Name|Nome|Ospite):\s*([A-Za-zÀ-ÿ]+)\s+([A-Za-zÀ-ÿ]+)/iu', $description, $matches)) {
                $result['name'] = ucfirst(strtolower(trim($matches[1])));
                $result['surname'] = ucfirst(strtolower(trim($matches[2])));
            }
        }

        // Estrai email dalla description
        if (preg_match('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/i', $description, $matches)) {
            $result['email'] = strtolower($matches[0]);
        }

        // Estrai telefono dalla description
        if (preg_match('/(?:Tel|Phone|Mobile|Cell|Telefono)[\s.:]*([+]?[\d\s\-().]{8,20})/i', $description, $matches)) {
            $result['phone'] = preg_replace('/[^\d+]/', '', $matches[1]);
        }

        // Estrai numero ospiti
        if (preg_match('/(\d+)\s*(?:guest|ospit|person|adult|pax)/i', $summary . ' ' . $description, $matches)) {
            $result['guests_count'] = (int) $matches[1];
        }

        return $result;
    }

    protected function sendNotificationEmail($bookings): void
    {
        $adminEmail = Setting::get('admin_email');
        if (!$adminEmail) return;

        try {
            Mail::to($adminEmail)->send(new NewBookingNotification($bookings->first(), $bookings->count()));
        } catch (Exception $e) {
            Log::error("Failed to send notification: {$e->getMessage()}");
        }
    }
}
