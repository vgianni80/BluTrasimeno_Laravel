<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CheckinInvitation;
use App\Models\Booking;
use App\Models\IcalSource;
use App\Models\Setting;
use App\Services\AlloggiatiwebService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['guests', 'icalSource']);

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_surname', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%");
            });
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->where('check_in', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->where('check_in', '<=', $dateTo);
        }

        $bookings = $query->orderBy('check_in', 'desc')->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $icalSources = IcalSource::orderBy('name')->get();
        return view('admin.bookings.create', compact('icalSources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'number_of_guests' => 'required|integer|min:1',
            'guest_name' => 'required|string|max:255',
            'guest_surname' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $validated['status'] = 'complete';
        $booking = Booking::create($validated);
        $booking->generateCheckinToken();

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Prenotazione creata con successo!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['guests', 'icalSource', 'alloggiatiwebLogs']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $icalSources = IcalSource::orderBy('name')->get();
        return view('admin.bookings.edit', compact('booking', 'icalSources'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'number_of_guests' => 'required|integer|min:1',
            'guest_name' => 'required|string|max:255',
            'guest_surname' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'nullable|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $booking->update($validated);

        // Se era incomplete e ora ha i dati, genera il link
        if ($booking->status === 'incomplete' && $booking->guest_email) {
            $booking->generateCheckinToken();
            $booking->markAsComplete();
        }

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Prenotazione aggiornata!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Prenotazione eliminata!');
    }

    public function generateLink(Booking $booking)
    {
        if (!$booking->checkin_token) {
            $booking->generateCheckinToken();
        }
        
        if ($booking->status === 'incomplete') {
            $booking->markAsComplete();
        }

        return back()->with('success', 'Link check-in generato!');
    }

    public function sendCheckinEmail(Booking $booking)
    {
        if (!$booking->guest_email) {
            return back()->with('error', 'Email ospite non disponibile');
        }

        if (!$booking->checkin_token) {
            $booking->generateCheckinToken();
        }

        try {
            Mail::to($booking->guest_email)->send(new CheckinInvitation($booking));
            return back()->with('success', "Email inviata a {$booking->guest_email}");
        } catch (\Exception $e) {
            return back()->with('error', "Errore invio email: {$e->getMessage()}");
        }
    }

    public function resendAlloggiatiweb(Booking $booking, AlloggiatiwebService $service)
    {
        if (!in_array($booking->status, ['checked_in', 'failed'])) {
            return back()->with('error', 'La prenotazione deve essere in stato checked_in o failed');
        }

        if (!Setting::get('alloggiatiweb_enabled')) {
            return back()->with('error', 'AlloggiatiWeb non è abilitato nelle impostazioni');
        }

        if ($service->sendBooking($booking)) {
            return back()->with('success', 'Dati inviati ad AlloggiatiWeb!');
        } else {
            return back()->with('error', "Errore: {$booking->last_error}");
        }
    }
}
