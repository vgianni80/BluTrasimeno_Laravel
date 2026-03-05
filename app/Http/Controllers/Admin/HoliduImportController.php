<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HoliduImportController extends Controller
{
    public function form()
    {
        return view('admin.bookings.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240',
        ]);

        try {
            $path = $request->file('file')->getRealPath();
            $spreadsheet = IOFactory::load($path);
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'File non valido: ' . $e->getMessage()]);
        }

        $sheet = $spreadsheet->getActiveSheet();

        $created = 0;
        $updated = 0;
        $skipped = 0;
        $errors  = [];

        $highestRow = $sheet->getHighestDataRow();

        for ($row = 2; $row <= $highestRow; $row++) {
            try {
                $bookingStatus = trim((string) $sheet->getCell("O{$row}")->getValue());

                // Salta prenotazioni cancellate
                if (strtoupper($bookingStatus) === 'CANCELLED') {
                    $skipped++;
                    continue;
                }

                $holiduBookingId = (string) (int) $sheet->getCell("A{$row}")->getValue();
                if (!$holiduBookingId || $holiduBookingId === '0') {
                    $skipped++;
                    continue;
                }

                // Date (Excel serial number → Carbon)
                $checkIn  = $this->excelDateToCarbon($sheet->getCell("M{$row}")->getValue());
                $checkOut = $this->excelDateToCarbon($sheet->getCell("N{$row}")->getValue());
                $bookedAt = $this->excelDateToCarbon($sheet->getCell("L{$row}")->getValue());

                if (!$checkIn || !$checkOut) {
                    $errors[] = "Riga {$row}: date non valide";
                    $skipped++;
                    continue;
                }

                // Nome ospite: "Nome Cognome"
                $fullName     = trim((string) $sheet->getCell("F{$row}")->getValue());
                $nameParts    = preg_split('/\s+/', $fullName, 2);
                $guestName    = $nameParts[0] ?? null;
                $guestSurname = $nameParts[1] ?? null;

                // Numero ospiti
                $adults    = (int) $sheet->getCell("G{$row}")->getValue();
                $children  = (int) $sheet->getCell("H{$row}")->getValue();
                $babies    = (int) $sheet->getCell("I{$row}")->getValue();
                $numGuests = ($adults + $children + $babies) ?: null;

                // Valori finanziari
                $financialData = [
                    'holidu_booking_id'          => $holiduBookingId,
                    'holidu_channel'             => trim((string) $sheet->getCell("E{$row}")->getValue()) ?: null,
                    'paid_by_guest'              => $this->decimal($sheet->getCell("K{$row}")->getValue()),
                    'home_owner_payout'          => $this->decimal($sheet->getCell("P{$row}")->getValue()),
                    'vat'                        => $this->decimal($sheet->getCell("Q{$row}")->getValue()),
                    'bookiply_commission'        => $this->decimal($sheet->getCell("R{$row}")->getValue()),
                    'channel_commission'         => $this->decimal($sheet->getCell("S{$row}")->getValue()),
                    'bookiply_processing_markup' => $this->decimal($sheet->getCell("T{$row}")->getValue()),
                    'cedolare_secca'             => $this->decimal($sheet->getCell("X{$row}")->getValue()),
                ];

                // Cerca prenotazione esistente:
                // 1) per holidu_booking_id (re-import dello stesso file)
                // 2) per check_in + cognome (prenotazione già entrata via iCal)
                $existing = Booking::where('holidu_booking_id', $holiduBookingId)->first();

                if (!$existing && $guestSurname) {
                    $existing = Booking::whereDate('check_in', $checkIn->toDateString())
                        ->whereRaw('LOWER(guest_surname) = ?', [strtolower($guestSurname)])
                        ->first();
                }

                if ($existing) {
                    // Aggiorna dati finanziari (+ booked_at e numero ospiti se mancanti)
                    $updateData = $financialData;
                    if (!$existing->booked_at && $bookedAt) {
                        $updateData['booked_at'] = $bookedAt;
                    }
                    if (!$existing->number_of_guests && $numGuests) {
                        $updateData['number_of_guests'] = $numGuests;
                    }
                    $existing->update($updateData);
                    $updated++;
                } else {
                    // Crea nuova prenotazione
                    Booking::create(array_merge($financialData, [
                        'booked_at'        => $bookedAt,
                        'check_in'         => $checkIn,
                        'check_out'        => $checkOut,
                        'number_of_guests' => $numGuests,
                        'guest_name'       => $guestName,
                        'guest_surname'    => $guestSurname,
                        'status'           => 'incomplete',
                    ]));
                    $created++;
                }
            } catch (\Exception $e) {
                $errors[] = "Riga {$row}: " . $e->getMessage();
                $skipped++;
            }
        }

        return redirect()->route('admin.bookings.import')
            ->with('import_result', [
                'created' => $created,
                'updated' => $updated,
                'skipped' => $skipped,
                'errors'  => $errors,
            ]);
    }

    private function excelDateToCarbon(mixed $value): ?Carbon
    {
        if (!$value || !is_numeric($value)) {
            return null;
        }
        // Excel serial: giorno 1 = 1 Jan 1900, con bug Lotus (giorno 60 = 29 Feb 1900 inesistente)
        return Carbon::create(1899, 12, 30)->addDays((int) $value);
    }

    private function decimal(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }
        $f = (float) $value;
        return $f !== 0.0 ? $f : null;
    }
}
