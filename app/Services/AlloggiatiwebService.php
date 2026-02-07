<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\AlloggiatiwebLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;
use SoapClient;
use Exception;

class AlloggiatiwebService
{
    protected ?string $wsdlUrl;
    protected ?string $username;
    protected ?string $password;
    protected ?string $wsKey;
    protected ?string $propertyId;
    protected bool $enabled;

    public function __construct()
    {
        $this->enabled = (bool) Setting::get('alloggiatiweb_enabled', false);
        $this->wsdlUrl = Setting::get('alloggiatiweb_wsdl_url');
        $this->username = Setting::get('alloggiatiweb_username');
        $this->password = Setting::get('alloggiatiweb_password');
        $this->wsKey = Setting::get('alloggiatiweb_ws_key');
        $this->propertyId = Setting::get('alloggiatiweb_property_id');
    }

    public function isEnabled(): bool
    {
        return $this->enabled && $this->wsdlUrl && $this->username && $this->password;
    }

    public function sendBooking(Booking $booking): bool
    {
        $log = new AlloggiatiwebLog([
            'booking_id' => $booking->id,
            'status' => 'pending',
            'sent_at' => now(),
        ]);

        try {
            if (!$this->isEnabled()) {
                throw new Exception('AlloggiatiWeb non configurato');
            }

            if ($booking->guests()->count() === 0) {
                throw new Exception('Nessun ospite registrato');
            }

            $payload = $this->buildPayload($booking);
            $log->request_payload = $payload;

            // Invio SOAP
            $client = new SoapClient($this->wsdlUrl, [
                'trace' => true,
                'exceptions' => true,
                'connection_timeout' => 60,
            ]);

            $params = [
                'Utente' => $this->username,
                'Password' => $this->password,
                'WSKey' => $this->wsKey,
                'CodiceStruttura' => $this->propertyId,
                'ElencoSchedine' => $payload,
            ];

            $response = $client->__soapCall('Test', [$params]);
            
            $log->response_payload = json_encode($response);
            $log->http_status_code = 200;
            $log->status = 'success';
            $booking->markAsSent();
            $log->save();

            return true;

        } catch (Exception $e) {
            $log->status = 'failed';
            $log->error_message = $e->getMessage();
            $booking->markAsFailed($e->getMessage());
            $log->save();

            Log::error("AlloggiatiWeb Error: {$e->getMessage()}");
            return false;
        }
    }

    protected function buildPayload(Booking $booking): string
    {
        $lines = [];

        foreach ($booking->guests as $guest) {
            $tipo = $booking->guests->count() === 1 ? '20' : ($guest->is_capogruppo ? '18' : '19');
            $sesso = $guest->sesso === 'M' ? '1' : '2';
            $tipoDoc = match($guest->tipo_documento) {
                'carta_identita' => 'IDENT',
                'passaporto' => 'PASOR',
                'patente' => 'PATEN',
                default => 'ALTRO'
            };

            $lines[] = implode(';', [
                $tipo,
                $booking->check_in->format('d/m/Y'),
                str_pad($booking->nights, 2, '0', STR_PAD_LEFT),
                mb_strtoupper(mb_substr($guest->cognome, 0, 50)),
                mb_strtoupper(mb_substr($guest->nome, 0, 30)),
                $sesso,
                $guest->data_nascita->format('d/m/Y'),
                mb_strtoupper($guest->comune_nascita),
                mb_strtoupper($guest->provincia_nascita ?: 'EE'),
                mb_strtoupper($guest->stato_nascita),
                mb_strtoupper($guest->cittadinanza),
                $tipoDoc,
                mb_strtoupper($guest->numero_documento),
                mb_strtoupper($guest->rilasciato_da ?: ''),
            ]);
        }

        return implode("\r\n", $lines);
    }

    public function sendDailyBookings(): array
    {
        if (!$this->isEnabled()) {
            return ['total' => 0, 'success' => 0, 'failed' => 0, 'skipped' => true];
        }

        $bookings = Booking::readyForAlloggiatiweb()->get();
        $results = ['total' => $bookings->count(), 'success' => 0, 'failed' => 0, 'skipped' => false];

        foreach ($bookings as $booking) {
            $this->sendBooking($booking) ? $results['success']++ : $results['failed']++;
        }

        return $results;
    }
}
