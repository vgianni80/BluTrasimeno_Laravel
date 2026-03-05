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
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 300;">Richiesta Ricevuta</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="font-size: 16px; color: #2d3748; margin: 0 0 10px;">
                                Gentile <strong>{{ $publicBooking->guest_name }}</strong>,
                            </p>
                            
                            <p style="font-size: 16px; color: #4a5568; line-height: 1.6; margin: 0 0 25px;">
                                Grazie per aver scelto Blu Trasimeno! Abbiamo ricevuto la tua richiesta di prenotazione e ti risponderemo al più presto.
                            </p>
                            
                            <!-- Booking Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #e8f0f7; border-radius: 8px; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h4 style="margin: 0 0 20px; color: #1a3a5c; font-size: 16px;">Riepilogo Richiesta</h4>
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="50%" style="padding: 10px; text-align: center; border-right: 1px solid #cbd5e0;">
                                                    <p style="margin: 0; font-size: 12px; color: #718096; text-transform: uppercase;">Check-in</p>
                                                    <p style="margin: 5px 0 0; font-size: 18px; font-weight: 600; color: #1a3a5c;">{{ $publicBooking->check_in->format('d/m/Y') }}</p>
                                                </td>
                                                <td width="50%" style="padding: 10px; text-align: center;">
                                                    <p style="margin: 0; font-size: 12px; color: #718096; text-transform: uppercase;">Check-out</p>
                                                    <p style="margin: 5px 0 0; font-size: 18px; font-weight: 600; color: #1a3a5c;">{{ $publicBooking->check_out->format('d/m/Y') }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 15px; border-top: 1px solid #cbd5e0; padding-top: 15px;">
                                            <tr>
                                                <td style="padding: 5px 0;">
                                                    <span style="color: #718096;">Notti:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $publicBooking->nights }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 0;">
                                                    <span style="color: #718096;">Ospiti:</span>
                                                    <strong style="color: #1a3a5c; float: right;">{{ $publicBooking->guests }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px 0; border-top: 2px solid #1a3a5c; margin-top: 10px;">
                                                    <span style="color: #1a3a5c; font-weight: 600;">Totale stimato:</span>
                                                    <strong style="color: #48bb78; float: right; font-size: 20px;">€ {{ number_format($publicBooking->total, 2, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- Info Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #ebf8ff; border-left: 4px solid #4a90b8; border-radius: 0 8px 8px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0; font-size: 14px; color: #2c5282;">
                                            ⏳ <strong>Cosa succede ora?</strong><br><br>
                                            Questa è una richiesta di prenotazione. Ti contatteremo entro 24 ore per confermare la disponibilità e le modalità di pagamento.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1a3a5c; padding: 30px; text-align: center;">
                            <p style="margin: 0 0 5px; color: #ffffff; font-weight: 600;">{{ $propertyName }}</p>
                            <p style="margin: 0; color: rgba(255,255,255,0.7); font-size: 14px;">
                                Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG)
                            </p>
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
