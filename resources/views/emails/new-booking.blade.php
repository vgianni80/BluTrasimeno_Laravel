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
                        <td style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); padding: 40px; text-align: center;">
                            <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 50%; margin: 0 auto 15px; line-height: 60px;">
                                <span style="font-size: 30px;">🏠</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 400;">Nuova Prenotazione</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="font-size: 16px; color: #2d3748; margin: 0 0 25px;">
                                È stata sincronizzata una nuova prenotazione che richiede il completamento dei dati.
                            </p>
                            
                            <!-- Booking Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fffbeb; border-left: 4px solid #ed8936; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
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
                                                <td style="padding: 8px 0; border-top: 1px solid #fbd38d;">
                                                    <span style="color: #718096;">Check-out:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->check_out->format('d/m/Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #fbd38d;">
                                                    <span style="color: #718096;">Notti:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->nights }}</strong>
                                                </td>
                                            </tr>
                                            @if($booking->icalSource)
                                            <tr>
                                                <td style="padding: 8px 0; border-top: 1px solid #fbd38d;">
                                                    <span style="color: #718096;">Fonte:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $booking->icalSource->name }}</strong>
                                                </td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            @if($totalNew > 1)
                            <p style="font-size: 14px; color: #718096; margin: 0 0 25px; text-align: center;">
                                📊 Totale nuove prenotazioni sincronizzate: <strong>{{ $totalNew }}</strong>
                            </p>
                            @endif
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0;">
                                        <a href="{{ route('admin.bookings.edit', $booking) }}" style="display: inline-block; background: #1a3a5c; color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 8px; font-size: 14px; font-weight: 500;">
                                            Completa la Prenotazione
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
