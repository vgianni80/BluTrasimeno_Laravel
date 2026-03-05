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
        $summary = trim((string) ($event->SUMMARY ?? ''));
        $description = (string) ($event->DESCRIPTION ?? '');

        $checkIn = $event->DTSTART->getDateTime();
        $checkOut = $event->DTEND ? $event->DTEND->getDateTime() : null;
        $bookedAt = $event->DTSTAMP ? $event->DTSTAMP->getDateTime() : null;

        // Ignora eventi passati
        if ($checkIn < now()->startOfDay()) {
            return 'skipped';
        }

        $booking = Booking::where('ical_uid', $uid)->first();

        // Estrai nome e cognome dal summary (formato Holidu: "Nome Cognome")
        $nameParts = preg_split('/\s+/', $summary, 2);
        $guestName = $nameParts[0] ?? null;
        $guestSurname = $nameParts[1] ?? null;

        $data = [
            'ical_source_id' => $source->id,
            'ical_uid' => $uid,
            'booked_at' => $bookedAt,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guest_name' => $guestName,
            'guest_surname' => $guestSurname,
            'ical_raw_data' => [
                'summary' => $summary,
                'description' => $description,
            ],
        ];

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
