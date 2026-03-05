<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\LengthDiscount;
use App\Models\PricingRule;
use App\Models\PublicBooking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicBookingController extends Controller
{
    /**
     * Mostra la pagina di prenotazione pubblica
     */
    public function index()
    {
        $propertyName = Setting::get('property_name', 'Blu Trasimeno');
        $maxGuests = (int) Setting::get('max_guests', 6);

        return view('public.booking', compact('propertyName', 'maxGuests'));
    }

    /**
     * Restituisce i dati del calendario per un mese specifico
     */
    public function getCalendar(Request $request)
    {
        $year = $request->get('year', now()->year);
        $month = $request->get('month', now()->month);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        // Ottieni le date occupate
        $occupiedDates = $this->getOccupiedDates($startDate, $endDate);

        $days = [];
        $current = $startDate->copy();
        $today = now()->startOfDay();

        while ($current->lte($endDate)) {
            $dateStr = $current->format('Y-m-d');
            $isPast = $current->lt($today);
            $isOccupied = in_array($dateStr, $occupiedDates);

            $price = null;
            if (!$isPast && !$isOccupied) {
                $price = PricingRule::getPriceForDate($current);
            }

            $days[] = [
                'date' => $dateStr,
                'day' => $current->day,
                'available' => !$isOccupied,
                'isPast' => $isPast,
                'price' => $price ? round($price) : null,
            ];

            $current->addDay();
        }

        return response()->json([
            'year' => $year,
            'month' => $month,
            'days' => $days,
        ]);
    }

    /**
     * Calcola il prezzo per un soggiorno
     */
    public function calculatePrice(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $guests = $request->guests;

        // Verifica disponibilità
        if (!$this->isAvailable($checkIn, $checkOut)) {
            return response()->json([
                'available' => false,
                'message' => 'Le date selezionate non sono disponibili.',
            ]);
        }

        // Calcola prezzo
        $pricing = $this->calculatePricing($checkIn, $checkOut, $guests);

        return response()->json([
            'available' => true,
            'pricing' => $pricing,
        ]);
    }

    /**
     * Verifica disponibilità
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $available = $this->isAvailable($checkIn, $checkOut);

        return response()->json([
            'available' => $available,
            'message' => $available ? 'Date disponibili!' : 'Le date selezionate non sono disponibili.',
        ]);
    }

    /**
     * Salva una richiesta di prenotazione
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . Setting::get('max_guests', 6),
            'guest_name' => 'required|string|max:255',
            'guest_surname' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string|max:1000',
            'privacy' => 'required|accepted',
        ]);

        $checkIn = Carbon::parse($validated['check_in']);
        $checkOut = Carbon::parse($validated['check_out']);

        // Verifica disponibilità
        if (!$this->isAvailable($checkIn, $checkOut)) {
            return back()
                ->withInput()
                ->withErrors(['check_in' => 'Le date selezionate non sono più disponibili.']);
        }

        // Calcola prezzo
        $pricing = $this->calculatePricing($checkIn, $checkOut, $validated['guests']);

        // Crea la richiesta
        $publicBooking = PublicBooking::create([
            'guest_name' => $validated['guest_name'],
            'guest_surname' => $validated['guest_surname'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'guests' => $validated['guests'],
            'notes' => $validated['notes'] ?? null,
            'total' => $pricing['total'],
            'price_breakdown' => $pricing,
            'status' => 'pending',
        ]);

        // Invia email all'admin
        $this->sendAdminNotification($publicBooking);

        // Invia email di conferma all'ospite
        $this->sendGuestConfirmation($publicBooking);

        return redirect()->route('public.booking.success', $publicBooking);
    }

    /**
     * Mostra la pagina di conferma
     */
    public function success(PublicBooking $publicBooking)
    {
        $propertyName = Setting::get('property_name', 'Blu Trasimeno');
        $propertyPhone = Setting::get('property_phone');

        return view('public.booking-success', compact('publicBooking', 'propertyName', 'propertyPhone'));
    }

    /**
     * Ottiene le date occupate in un range
     */
    protected function getOccupiedDates(Carbon $startDate, Carbon $endDate): array
    {
        $occupiedDates = [];

        // Dalle prenotazioni esistenti
        $bookings = Booking::whereNull('deleted_at')
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in', [$startDate, $endDate])
                  ->orWhereBetween('check_out', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('check_in', '<=', $startDate)
                         ->where('check_out', '>=', $endDate);
                  });
            })
            ->get();

        foreach ($bookings as $booking) {
            $current = $booking->check_in->copy();
            while ($current->lt($booking->check_out)) {
                $occupiedDates[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }

        // Dalle richieste pubbliche confermate (non ancora convertite)
        $publicBookings = PublicBooking::where('status', 'confirmed')
            ->whereNull('booking_id')
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in', [$startDate, $endDate])
                  ->orWhereBetween('check_out', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('check_in', '<=', $startDate)
                         ->where('check_out', '>=', $endDate);
                  });
            })
            ->get();

        foreach ($publicBookings as $pb) {
            $current = $pb->check_in->copy();
            while ($current->lt($pb->check_out)) {
                $occupiedDates[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }

        return array_unique($occupiedDates);
    }

    /**
     * Verifica se un range di date è disponibile
     */
    protected function isAvailable(Carbon $checkIn, Carbon $checkOut): bool
    {
        // Verifica che check-in sia nel futuro
        if ($checkIn->lt(now()->startOfDay())) {
            return false;
        }

        $occupiedDates = $this->getOccupiedDates($checkIn, $checkOut);

        $current = $checkIn->copy();
        while ($current->lt($checkOut)) {
            if (in_array($current->format('Y-m-d'), $occupiedDates)) {
                return false;
            }
            $current->addDay();
        }

        return true;
    }

    /**
     * Calcola il prezzo totale del soggiorno
     */
    protected function calculatePricing(Carbon $checkIn, Carbon $checkOut, int $guests): array
    {
        // Calcola il totale base
        $baseCalc = PricingRule::calculateTotal($checkIn, $checkOut);
        $nights = $baseCalc['nights'];
        $subtotal = $baseCalc['subtotal'];

        // Applica sconto per durata
        $discountData = LengthDiscount::calculateDiscount($nights, $subtotal);
        $discountAmount = $discountData['discount_amount'];
        $discountPercent = $discountData['discount_percent'];

        // Costo pulizie
        $cleaningFee = (float) Setting::get('cleaning_fee', 0);

        // Totale finale
        $total = $subtotal - $discountAmount + $cleaningFee;

        return [
            'nights' => $nights,
            'subtotal' => round($subtotal, 2),
            'discount_percent' => $discountPercent,
            'discount' => round($discountAmount, 2),
            'cleaning_fee' => round($cleaningFee, 2),
            'total' => round($total, 2),
            'average_per_night' => round($baseCalc['average_per_night'], 2),
            'daily_prices' => $baseCalc['daily_prices'],
        ];
    }

    /**
     * Invia notifica all'admin
     */
    protected function sendAdminNotification(PublicBooking $publicBooking): void
    {
        $adminEmail = Setting::get('admin_email');
        if (!$adminEmail) {
            return;
        }

        try {
            $propertyName = Setting::get('property_name', 'Blu Trasimeno');
            
            Mail::send('emails.new-public-booking', [
                'publicBooking' => $publicBooking,
                'propertyName' => $propertyName,
            ], function ($message) use ($adminEmail, $publicBooking) {
                $message->to($adminEmail)
                    ->subject("Nuova richiesta: {$publicBooking->guest_name} {$publicBooking->guest_surname} - " . 
                             $publicBooking->check_in->format('d/m') . " al " . $publicBooking->check_out->format('d/m'));
            });
        } catch (\Exception $e) {
            \Log::error('Errore invio email admin nuova prenotazione: ' . $e->getMessage());
        }
    }

    /**
     * Invia conferma all'ospite
     */
    protected function sendGuestConfirmation(PublicBooking $publicBooking): void
    {
        try {
            $propertyName = Setting::get('property_name', 'Blu Trasimeno');
            
            Mail::send('emails.public-booking-confirmation', [
                'publicBooking' => $publicBooking,
                'propertyName' => $propertyName,
            ], function ($message) use ($publicBooking, $propertyName) {
                $message->to($publicBooking->guest_email)
                    ->subject("Richiesta ricevuta - {$propertyName}");
            });
        } catch (\Exception $e) {
            \Log::error('Errore invio email conferma ospite: ' . $e->getMessage());
        }
    }
}
