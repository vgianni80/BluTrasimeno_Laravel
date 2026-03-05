<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PublicBooking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Response;

class IcalExportController extends Controller
{
    /**
     * Genera il feed iCal pubblico con tutte le prenotazioni
     * URL: /calendar/export.ics
     * 
     * Questo URL può essere dato a Holidu, Booking.com, Airbnb, ecc.
     * per sincronizzare le date occupate.
     */
    public function export()
    {
        $propertyName = Setting::get('property_name', 'Blu Trasimeno');
        
        // Prendi tutte le prenotazioni confermate (non cancellate)
        $bookings = Booking::whereNull('deleted_at')
            ->where('status', '!=', 'cancelled')
            ->where('check_out', '>=', now()->subMonths(1)) // Includi anche quelle recenti passate
            ->orderBy('check_in')
            ->get();

        // Prendi anche le richieste pubbliche confermate (se non già convertite in booking)
        $publicBookings = PublicBooking::where('status', 'confirmed')
            ->whereNull('booking_id') // Solo quelle non ancora collegate a un booking
            ->where('check_out', '>=', now()->subMonths(1))
            ->get();

        $ical = $this->generateIcal($bookings, $publicBookings, $propertyName);

        return response($ical, 200)
            ->header('Content-Type', 'text/calendar; charset=utf-8')
            ->header('Content-Disposition', 'inline; filename="calendar.ics"')
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache');
    }

    /**
     * Genera il contenuto iCal
     */
    protected function generateIcal($bookings, $publicBookings, $propertyName): string
    {
        $lines = [
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:-//Blu Trasimeno//Booking System//IT',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'X-WR-CALNAME:' . $this->escapeIcal($propertyName),
            'X-WR-TIMEZONE:Europe/Rome',
        ];

        // Aggiungi timezone
        $lines = array_merge($lines, $this->getTimezoneComponent());

        // Aggiungi eventi dalle prenotazioni
        foreach ($bookings as $booking) {
            $lines = array_merge($lines, $this->bookingToEvent($booking));
        }

        // Aggiungi eventi dalle richieste pubbliche confermate
        foreach ($publicBookings as $pb) {
            $lines = array_merge($lines, $this->publicBookingToEvent($pb));
        }

        $lines[] = 'END:VCALENDAR';

        return implode("\r\n", $lines);
    }

    /**
     * Converte una prenotazione in evento iCal
     */
    protected function bookingToEvent(Booking $booking): array
    {
        $uid = 'booking-' . $booking->id . '@blutrasimeno.it';
        $created = $booking->created_at ?? now();
        $modified = $booking->updated_at ?? now();
        
        // Per iCal, le date devono essere in formato DATE (non DATETIME) per eventi tutto il giorno
        $dtstart = $booking->check_in->format('Ymd');
        $dtend = $booking->check_out->format('Ymd');
        
        // Summary: nome ospite o "Prenotato"
        $summary = 'Prenotato';
        if ($booking->guest_name || $booking->guest_surname) {
            $guestName = trim(($booking->guest_name ?? '') . ' ' . ($booking->guest_surname ?? ''));
            if ($guestName) {
                $summary = $guestName;
            }
        }

        // Aggiungi fonte se disponibile
        if ($booking->icalSource) {
            $summary .= ' - ' . $booking->icalSource->name;
        } elseif ($booking->source) {
            $summary .= ' - ' . $booking->source;
        }

        $lines = [
            'BEGIN:VEVENT',
            'UID:' . $uid,
            'DTSTAMP:' . $this->formatDateTime($modified),
            'DTSTART;VALUE=DATE:' . $dtstart,
            'DTEND;VALUE=DATE:' . $dtend,
            'SUMMARY:' . $this->escapeIcal($summary),
            'STATUS:CONFIRMED',
            'TRANSP:OPAQUE', // Mostra come "occupato"
        ];

        // Aggiungi descrizione con dettagli
        $description = "Check-in: " . $booking->check_in->format('d/m/Y') . "\\n";
        $description .= "Check-out: " . $booking->check_out->format('d/m/Y') . "\\n";
        $description .= "Notti: " . $booking->nights . "\\n";
        if ($booking->number_of_guests) {
            $description .= "Ospiti: " . $booking->number_of_guests;
        }
        $lines[] = 'DESCRIPTION:' . $this->escapeIcal($description);

        $lines[] = 'END:VEVENT';

        return $lines;
    }

    /**
     * Converte una richiesta pubblica in evento iCal
     */
    protected function publicBookingToEvent(PublicBooking $pb): array
    {
        $uid = 'public-booking-' . $pb->id . '@blutrasimeno.it';
        $created = $pb->created_at ?? now();
        
        $dtstart = $pb->check_in->format('Ymd');
        $dtend = $pb->check_out->format('Ymd');
        
        $summary = trim($pb->guest_name . ' ' . $pb->guest_surname) ?: 'Prenotato';
        $summary .= ' - Diretto';

        $lines = [
            'BEGIN:VEVENT',
            'UID:' . $uid,
            'DTSTAMP:' . $this->formatDateTime($created),
            'DTSTART;VALUE=DATE:' . $dtstart,
            'DTEND;VALUE=DATE:' . $dtend,
            'SUMMARY:' . $this->escapeIcal($summary),
            'STATUS:CONFIRMED',
            'TRANSP:OPAQUE',
        ];

        $description = "Prenotazione diretta\\n";
        $description .= "Check-in: " . $pb->check_in->format('d/m/Y') . "\\n";
        $description .= "Check-out: " . $pb->check_out->format('d/m/Y') . "\\n";
        $description .= "Ospiti: " . $pb->guests;
        $lines[] = 'DESCRIPTION:' . $this->escapeIcal($description);

        $lines[] = 'END:VEVENT';

        return $lines;
    }

    /**
     * Componente timezone per Europe/Rome
     */
    protected function getTimezoneComponent(): array
    {
        return [
            'BEGIN:VTIMEZONE',
            'TZID:Europe/Rome',
            'BEGIN:DAYLIGHT',
            'TZOFFSETFROM:+0100',
            'TZOFFSETTO:+0200',
            'TZNAME:CEST',
            'DTSTART:19700329T020000',
            'RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU',
            'END:DAYLIGHT',
            'BEGIN:STANDARD',
            'TZOFFSETFROM:+0200',
            'TZOFFSETTO:+0100',
            'TZNAME:CET',
            'DTSTART:19701025T030000',
            'RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU',
            'END:STANDARD',
            'END:VTIMEZONE',
        ];
    }

    /**
     * Formatta una data per iCal
     */
    protected function formatDateTime(Carbon $date): string
    {
        return $date->utc()->format('Ymd\THis\Z');
    }

    /**
     * Escape caratteri speciali per iCal
     */
    protected function escapeIcal(string $text): string
    {
        $text = str_replace('\\', '\\\\', $text);
        $text = str_replace("\n", '\\n', $text);
        $text = str_replace("\r", '', $text);
        $text = str_replace(',', '\\,', $text);
        $text = str_replace(';', '\\;', $text);
        return $text;
    }
}
