<?php

namespace App\Http\Controllers;

use App\Mail\CheckinCompletedNotification;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckinController extends Controller
{
    public function show(string $token)
    {
        $booking = Booking::where('checkin_token', $token)->first();

        if (!$booking) {
            return view('checkin.invalid', [
                'reason' => 'Il link non è valido o la prenotazione non esiste.',
            ]);
        }

        if ($booking->checkin_completed_at) {
            return view('checkin.success', $this->getSuccessData($booking));
        }

        if ($booking->checkin_link_expires_at && $booking->checkin_link_expires_at->isPast()) {
            return view('checkin.invalid', [
                'reason' => 'Il link è scaduto. Contatta la struttura per un nuovo link.',
            ]);
        }

        return view('checkin.form', [
            'booking' => $booking,
            'propertyName' => Setting::get('property_name', config('app.name')),
            'propertyAddress' => Setting::get('property_address'),
        ]);
    }

    public function store(Request $request, string $token)
    {
        $booking = Booking::where('checkin_token', $token)->first();

        if (!$booking || $booking->checkin_completed_at) {
            return redirect()->route('checkin.show', $token);
        }

        $request->validate([
            'guests' => 'required|array|min:1',
            'guests.*.nome' => 'required|string|max:255',
            'guests.*.cognome' => 'required|string|max:255',
            'guests.*.sesso' => 'required|in:M,F',
            'guests.*.data_nascita' => 'required|date|before:today',
            'guests.*.comune_nascita' => 'required|string|max:255',
            'guests.*.provincia_nascita' => 'nullable|string|max:2',
            'guests.*.stato_nascita' => 'required|string|max:255',
            'guests.*.cittadinanza' => 'required|string|max:255',
            'guests.*.tipo_documento' => 'required|string',
            'guests.*.numero_documento' => 'required|string|max:50',
            'guests.*.rilasciato_da' => 'required|string|max:255',
            'guests.*.data_rilascio' => 'nullable|date',
            'guests.*.data_scadenza' => 'nullable|date',
            'privacy' => 'required|accepted',
        ], [
            'guests.required' => 'Inserisci almeno un ospite.',
            'guests.*.nome.required' => 'Il nome è obbligatorio.',
            'guests.*.cognome.required' => 'Il cognome è obbligatorio.',
            'guests.*.data_nascita.required' => 'La data di nascita è obbligatoria.',
            'guests.*.tipo_documento.required' => 'Il tipo documento è obbligatorio.',
            'guests.*.numero_documento.required' => 'Il numero documento è obbligatorio.',
            'privacy.accepted' => 'Devi accettare la privacy policy.',
        ]);

        DB::transaction(function () use ($request, $booking) {
            $booking->guests()->delete();

            foreach ($request->input('guests') as $index => $guestData) {
                Guest::create([
                    'booking_id' => $booking->id,
                    'nome' => strtoupper($guestData['nome']),
                    'cognome' => strtoupper($guestData['cognome']),
                    'sesso' => $guestData['sesso'],
                    'data_nascita' => $guestData['data_nascita'],
                    'comune_nascita' => strtoupper($guestData['comune_nascita']),
                    'provincia_nascita' => strtoupper($guestData['provincia_nascita'] ?? ''),
                    'stato_nascita' => strtoupper($guestData['stato_nascita']),
                    'cittadinanza' => strtoupper($guestData['cittadinanza']),
                    'tipo_documento' => $guestData['tipo_documento'],
                    'numero_documento' => strtoupper($guestData['numero_documento']),
                    'rilasciato_da' => strtoupper($guestData['rilasciato_da']),
                    'data_rilascio' => $guestData['data_rilascio'] ?? null,
                    'data_scadenza' => $guestData['data_scadenza'] ?? null,
                    'is_capogruppo' => $index === 0,
                ]);
            }

            $booking->markAsCheckedIn();
        });

        // Notifica admin
        $adminEmail = Setting::get('admin_email');
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new CheckinCompletedNotification($booking->fresh()));
            } catch (\Exception $e) {
                Log::error('Errore invio email check-in completato: ' . $e->getMessage());
            }
        }

        return view('checkin.success', $this->getSuccessData($booking->fresh()->load('guests')));
    }

    protected function getSuccessData(Booking $booking): array
    {
        return [
            'booking' => $booking,
            'propertyName' => Setting::get('property_name', config('app.name')),
            'propertyAddress' => Setting::get('property_address'),
            'propertyPhone' => Setting::get('property_phone'),
            'checkinInstructions' => Setting::get('checkin_instructions'),
        ];
    }
}
