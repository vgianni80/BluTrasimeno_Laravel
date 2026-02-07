<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #1e3a5f;">🏠 Nuova Prenotazione</h2>
        
        <p>È stata sincronizzata una nuova prenotazione che richiede completamento:</p>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p><strong>Check-in:</strong> {{ $booking->check_in->format('d/m/Y') }}</p>
            <p><strong>Check-out:</strong> {{ $booking->check_out->format('d/m/Y') }}</p>
            <p><strong>Notti:</strong> {{ $booking->nights }}</p>
            @if($booking->icalSource)
                <p><strong>Fonte:</strong> {{ $booking->icalSource->name }}</p>
            @endif
        </div>
        
        @if($totalNew > 1)
            <p><strong>Totale nuove prenotazioni:</strong> {{ $totalNew }}</p>
        @endif
        
        <p style="text-align: center;">
            <a href="{{ route('admin.bookings.edit', $booking) }}" 
               style="display: inline-block; background: #1e3a5f; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px;">
                Completa la prenotazione
            </a>
        </p>
    </div>
</body>
</html>
