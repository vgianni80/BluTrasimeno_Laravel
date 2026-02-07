<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #28a745;">✅ Check-in Completato</h2>
        
        <p>L'ospite ha completato il check-in online:</p>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p><strong>Ospite:</strong> {{ $booking->full_guest_name }}</p>
            <p><strong>Check-in:</strong> {{ $booking->check_in->format('d/m/Y') }}</p>
            <p><strong>Check-out:</strong> {{ $booking->check_out->format('d/m/Y') }}</p>
            <p><strong>Ospiti registrati:</strong> {{ $booking->guests->count() }}</p>
        </div>
        
        <h4>Ospiti:</h4>
        <ul>
            @foreach($booking->guests as $guest)
                <li>{{ $guest->nome_completo }} @if($guest->is_capogruppo)(Capogruppo)@endif</li>
            @endforeach
        </ul>
        
        <p>I dati verranno inviati ad AlloggiatiWeb il giorno del check-in.</p>
        
        <p style="text-align: center;">
            <a href="{{ route('admin.bookings.show', $booking) }}" 
               style="display: inline-block; background: #1e3a5f; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px;">
                Visualizza Dettagli
            </a>
        </p>
    </div>
</body>
</html>
