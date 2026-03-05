<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Arial, sans-serif; background-color: #f7fafc;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7fafc; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); padding: 40px; text-align: center;">
                            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 15px; line-height: 60px;">
                                <span style="font-size: 30px;">✓</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 400;">Check-in Completato</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="font-size: 16px; color: #2d3748; margin: 0 0 25px;">
                                L'ospite <strong>{{ $booking->full_guest_name }}</strong> ha completato il check-in online.
                            </p>
                            
                            <!-- Booking Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #e8f0f7; border-radius: 8px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <span style="color: #718096;">Check-in:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->check_in->format('d/m/Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #cbd5e0;">
                                                    <span style="color: #718096;">Check-out:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->check_out->format('d/m/Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #cbd5e0;">
                                                    <span style="color: #718096;">Notti:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->nights }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #cbd5e0;">
                                                    <span style="color: #718096;">Ospiti registrati:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->guests->count() }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Guest List -->
                            <h4 style="color: #1a3a5c; margin: 0 0 15px; font-size: 16px;">👥 Ospiti Registrati</h4>
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 25px;">
                                @foreach($booking->guests as $guest)
                                <tr>
                                    <td style="padding: 10px 15px; background-color: {{ $loop->even ? '#f7fafc' : '#ffffff' }}; border-radius: 4px;">
                                        <strong style="color: #2d3748;">{{ $guest->nome }} {{ $guest->cognome }}</strong>
                                        @if($guest->is_capogruppo)
                                        <span style="background-color: #c9a227; color: #ffffff; font-size: 10px; padding: 2px 8px; border-radius: 10px; margin-left: 10px;">CAPOGRUPPO</span>
                                        @endif
                                        <br>
                                        <span style="font-size: 13px; color: #718096;">{{ $guest->tipo_documento }}: {{ $guest->numero_documento }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                            
                            <!-- Info -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ebf8ff; border-left: 4px solid #4a90b8; border-radius: 0 8px 8px 0;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <p style="margin: 0; font-size: 14px; color: #2c5282;">
                                            ℹ️ I dati verranno inviati automaticamente ad AlloggiatiWeb il giorno del check-in.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 30px 0 10px;">
                                        <a href="{{ route('admin.bookings.show', $booking) }}" style="display: inline-block; background: #1a3a5c; color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 8px; font-size: 14px; font-weight: 500;">
                                            Visualizza Dettagli
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #2d3748; padding: 25px; text-align: center;">
                            <p style="margin: 0; color: rgba(255,255,255,0.6); font-size: 13px;">
                                Notifica automatica dal sistema di gestione prenotazioni
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
