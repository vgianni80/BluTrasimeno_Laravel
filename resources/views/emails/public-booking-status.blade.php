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
                        <td style="background: linear-gradient(135deg, #1a3a5c 0%, #2c5282 100%); padding: 40px; text-align: center;">
                            <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" style="height: 50px; margin-bottom: 15px;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 300;">
                                @if($status === 'rejected')
                                    Date non disponibili
                                @else
                                    Aggiornamento Richiesta
                                @endif
                            </h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="font-size: 16px; color: #2d3748; margin: 0 0 25px;">
                                Gentile <strong>{{ $publicBooking->guest_name }}</strong>,
                            </p>
                            
                            @if($status === 'rejected')
                            <p style="font-size: 16px; color: #4a5568; line-height: 1.6; margin: 0 0 25px;">
                                Ci dispiace comunicarti che le date richieste non sono disponibili.
                            </p>
                            
                            <!-- Booking Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fef2f2; border-left: 4px solid #f56565; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px; color: #991b1b;">
                                            <strong>Date richieste:</strong>
                                        </p>
                                        <p style="margin: 0; color: #4a5568;">
                                            {{ $publicBooking->check_in->format('d/m/Y') }} → {{ $publicBooking->check_out->format('d/m/Y') }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                            
                            @if($publicBooking->admin_notes)
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fffbeb; border-left: 4px solid #c9a227; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 5px; font-weight: 600; color: #744210;">Messaggio dalla struttura:</p>
                                        <p style="margin: 0; color: #4a5568;">{{ $publicBooking->admin_notes }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            
                            <p style="font-size: 16px; color: #4a5568; line-height: 1.6; margin: 0 0 25px;">
                                Ti invitiamo a verificare altre date sul nostro sito di prenotazione. Saremo lieti di ospitarti in futuro!
                            </p>
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0;">
                                        <a href="https://www.blutrasimeno.it/prenota/" style="display: inline-block; background: linear-gradient(135deg, #1a3a5c 0%, #2c5282 100%); color: #ffffff; text-decoration: none; padding: 14px 30px; border-radius: 8px; font-size: 14px; font-weight: 500;">
                                            Verifica Altre Date
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1a3a5c; padding: 30px; text-align: center;">
                            <p style="margin: 0 0 5px; color: #ffffff; font-weight: 600;">{{ $propertyName }}</p>
                            <p style="margin: 0; color: rgba(255,255,255,0.7); font-size: 14px;">
                                Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG)
                            </p>
                            @if($propertyPhone)
                            <p style="margin: 10px 0 0; color: rgba(255,255,255,0.7); font-size: 14px;">
                                📞 {{ $propertyPhone }}
                            </p>
                            @endif
                            <p style="margin: 15px 0 0; color: rgba(255,255,255,0.5); font-size: 12px;">
                                ©2025 Blu Trasimeno
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
