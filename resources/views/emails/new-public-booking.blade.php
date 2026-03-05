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
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px; text-align: center;">
                            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 15px; line-height: 60px;">
                                <span style="font-size: 30px;">🆕</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 400;">Nuova Richiesta dal Sito</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="font-size: 16px; color: #2d3748; margin: 0 0 25px;">
                                Hai ricevuto una nuova richiesta di prenotazione dal sito web.
                            </p>
                            
                            <!-- Guest Info -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #e8f0f7; border-radius: 8px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h4 style="margin: 0 0 15px; color: #1a3a5c; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">👤 Dati Cliente</h4>
                                        <p style="margin: 5px 0; color: #2d3748;"><strong>{{ $publicBooking->guest_name }} {{ $publicBooking->guest_surname }}</strong></p>
                                        <p style="margin: 5px 0; color: #4a5568;">📧 {{ $publicBooking->guest_email }}</p>
                                        @if($publicBooking->guest_phone)
                                        <p style="margin: 5px 0; color: #4a5568;">📞 {{ $publicBooking->guest_phone }}</p>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Booking Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7fafc; border-radius: 8px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h4 style="margin: 0 0 15px; color: #1a3a5c; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">📅 Dettagli Soggiorno</h4>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="padding: 8px 0;">
                                                    <span style="color: #718096;">Check-in:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $publicBooking->check_in->format('d/m/Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #e2e8f0;">
                                                    <span style="color: #718096;">Check-out:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $publicBooking->check_out->format('d/m/Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #e2e8f0;">
                                                    <span style="color: #718096;">Notti:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $publicBooking->nights }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #e2e8f0;">
                                                    <span style="color: #718096;">Ospiti:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $publicBooking->guests }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Price -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f0fff4; border: 2px solid #48bb78; border-radius: 8px; margin-bottom: 20px;">
                                <tr>
                                    <td style="padding: 20px; text-align: center;">
                                        <p style="margin: 0; color: #718096; font-size: 14px;">Totale Proposto</p>
                                        <p style="margin: 5px 0 0; color: #22543d; font-size: 32px; font-weight: bold;">€ {{ number_format($publicBooking->total, 2, ',', '.') }}</p>
                                    </td>
                                </tr>
                            </table>
                            
                            @if($publicBooking->notes)
                            <!-- Notes -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fffbeb; border-left: 4px solid #c9a227; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 15px 20px;">
                                        <p style="margin: 0 0 5px; font-weight: 600; color: #744210;">📝 Note del Cliente</p>
                                        <p style="margin: 0; font-size: 14px; color: #4a5568;">{{ $publicBooking->notes }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0;">
                                        <a href="{{ route('admin.public-bookings.show', $publicBooking) }}" style="display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 8px; font-size: 16px; font-weight: 500;">
                                            Visualizza Richiesta
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
                                Richiesta ricevuta il {{ $publicBooking->created_at->format('d/m/Y H:i') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
