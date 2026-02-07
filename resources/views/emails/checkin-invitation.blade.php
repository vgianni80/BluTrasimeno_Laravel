<!DOCTYPE html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #667eea;">✨ {{ $propertyName }}</h2>
        
        <p>Gentile <strong>{{ $booking->full_guest_name }}</strong>,</p>
        
        <p>Grazie per la tua prenotazione! Ti chiediamo di completare il check-in online prima del tuo arrivo.</p>
        
        <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
            <p><strong>Check-in:</strong> {{ $booking->check_in->format('d/m/Y') }}</p>
            <p><strong>Check-out:</strong> {{ $booking->check_out->format('d/m/Y') }}</p>
            <p><strong>Notti:</strong> {{ $booking->nights }}</p>
        </div>
        
        <p style="text-align: center;">
            <a href="{{ $checkinUrl }}" 
               style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 40px; text-decoration: none; border-radius: 8px; font-weight: bold;">
                Completa il Check-in
            </a>
        </p>
        
        <p style="text-align: center; font-size: 12px; color: #999;">
            Link: {{ $checkinUrl }}
        </p>
        
        @if($checkinInstructions)
            <div style="background: #e7f1ff; padding: 15px; border-radius: 8px; margin: 20px 0;">
                <strong>ℹ️ Istruzioni:</strong>
                <p style="margin: 10px 0 0;">{{ $checkinInstructions }}</p>
            </div>
        @endif
        
        @if($propertyAddress)
            <p><strong>📍 Indirizzo:</strong> {{ $propertyAddress }}</p>
        @endif
        
        <hr style="margin: 30px 0;">
        <p style="font-size: 12px; color: #666; text-align: center;">
            {{ $propertyName }}
        </p>
    </div>
</body>
</html>
