<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PublicBooking;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicBookingController extends Controller
{
    /**
     * Mostra l'elenco delle richieste di prenotazione
     */
    public function index(Request $request)
    {
        $query = PublicBooking::query();

        // Filtro per stato
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Ricerca
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('guest_name', 'like', "%{$search}%")
                  ->orWhere('guest_surname', 'like', "%{$search}%")
                  ->orWhere('guest_email', 'like', "%{$search}%");
            });
        }

        $publicBookings = $query->orderBy('created_at', 'desc')->paginate(20);

        // Conteggi per le tab
        $counts = [
            'all' => PublicBooking::count(),
            'pending' => PublicBooking::where('status', 'pending')->count(),
            'confirmed' => PublicBooking::where('status', 'confirmed')->count(),
            'rejected' => PublicBooking::where('status', 'rejected')->count(),
        ];

        return view('admin.public-bookings.index', compact('publicBookings', 'counts'));
    }

    /**
     * Mostra i dettagli di una richiesta
     */
    public function show(PublicBooking $publicBooking)
    {
        $publicBooking->load('booking');

        return view('admin.public-bookings.show', compact('publicBooking'));
    }

    /**
     * Conferma una richiesta di prenotazione
     */
    public function confirm(Request $request, PublicBooking $publicBooking)
    {
        if ($publicBooking->status !== 'pending') {
            return back()->with('error', 'Questa richiesta non è in attesa di conferma.');
        }

        // Conferma la richiesta
        $publicBooking->confirm();

        // Se richiesto, crea anche la prenotazione nel calendario
        if ($request->has('create_booking')) {
            $booking = Booking::create([
                'check_in' => $publicBooking->check_in,
                'check_out' => $publicBooking->check_out,
                'number_of_guests' => $publicBooking->guests,
                'guest_name' => $publicBooking->guest_name,
                'guest_surname' => $publicBooking->guest_surname,
                'guest_email' => $publicBooking->guest_email,
                'guest_phone' => $publicBooking->guest_phone,
                'notes' => $publicBooking->notes,
                'status' => 'complete',
            ]);

            // Genera il token per il check-in
            $booking->generateCheckinToken();

            // Collega la richiesta alla prenotazione
            $publicBooking->update(['booking_id' => $booking->id]);
        }

        // Invia email di conferma all'ospite
        $this->sendStatusEmail($publicBooking, 'confirmed');

        return back()->with('success', 'Prenotazione confermata! L\'ospite è stato notificato via email.');
    }

    /**
     * Rifiuta una richiesta di prenotazione
     */
    public function reject(Request $request, PublicBooking $publicBooking)
    {
        if ($publicBooking->status !== 'pending') {
            return back()->with('error', 'Questa richiesta non è in attesa di conferma.');
        }

        $reason = $request->get('admin_notes');

        // Rifiuta la richiesta
        $publicBooking->reject($reason);

        // Invia email di notifica all'ospite
        $this->sendStatusEmail($publicBooking, 'rejected');

        return back()->with('success', 'Richiesta rifiutata. L\'ospite è stato notificato via email.');
    }

    /**
     * Elimina una richiesta di prenotazione
     */
    public function destroy(PublicBooking $publicBooking)
    {
        // Non eliminare se già collegata a una prenotazione
        if ($publicBooking->booking_id) {
            return back()->with('error', 'Non è possibile eliminare una richiesta collegata a una prenotazione.');
        }

        $publicBooking->delete();

        return redirect()->route('admin.public-bookings.index')
            ->with('success', 'Richiesta eliminata!');
    }

    /**
     * Invia email di notifica sullo stato della prenotazione
     */
    protected function sendStatusEmail(PublicBooking $publicBooking, string $status): void
    {
        try {
            $propertyName = Setting::get('property_name', 'Blu Trasimeno');
            $propertyPhone = Setting::get('property_phone');
            $propertyEmail = Setting::get('admin_email');

            $subject = match($status) {
                'confirmed' => "Prenotazione Confermata - {$propertyName}",
                'rejected' => "Aggiornamento sulla tua richiesta - {$propertyName}",
                default => "Aggiornamento prenotazione - {$propertyName}",
            };

            Mail::send('emails.public-booking-status', [
                'publicBooking' => $publicBooking,
                'propertyName' => $propertyName,
                'propertyPhone' => $propertyPhone,
                'propertyEmail' => $propertyEmail,
                'status' => $status,
            ], function ($message) use ($publicBooking, $subject) {
                $message->to($publicBooking->guest_email)
                    ->subject($subject);
            });
        } catch (\Exception $e) {
            \Log::error('Errore invio email stato prenotazione: ' . $e->getMessage());
        }
    }
}
