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
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 300;">Check-in Online</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <p style="font-size: 16px; color: #2d3748; margin: 0 0 20px;">
                                Gentile <strong>{{ $booking->full_guest_name }}</strong>,
                            </p>
                            
                            <p style="font-size: 16px; color: #4a5568; line-height: 1.6; margin: 0 0 25px;">
                                Grazie per aver scelto Blu Trasimeno! Per velocizzare il tuo arrivo, ti chiediamo di completare il check-in online prima del soggiorno.
                            </p>
                            
                            <!-- Booking Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #e8f0f7; border-radius: 8px; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="33%" style="text-align: center; padding: 10px;">
                                                    <p style="margin: 0; font-size: 12px; color: #718096; text-transform: uppercase; letter-spacing: 1px;">Check-in</p>
                                                    <p style="margin: 5px 0 0; font-size: 18px; font-weight: 600; color: #1a3a5c;">{{ $booking->check_in->format('d/m/Y') }}</p>
                                                </td>
                                                <td width="33%" style="text-align: center; padding: 10px; border-left: 1px solid #cbd5e0; border-right: 1px solid #cbd5e0;">
                                                    <p style="margin: 0; font-size: 12px; color: #718096; text-transform: uppercase; letter-spacing: 1px;">Check-out</p>
                                                    <p style="margin: 5px 0 0; font-size: 18px; font-weight: 600; color: #1a3a5c;">{{ $booking->check_out->format('d/m/Y') }}</p>
                                                </td>
                                                <td width="33%" style="text-align: center; padding: 10px;">
                                                    <p style="margin: 0; font-size: 12px; color: #718096; text-transform: uppercase; letter-spacing: 1px;">Notti</p>
                                                    <p style="margin: 5px 0 0; font-size: 18px; font-weight: 600; color: #1a3a5c;">{{ $booking->nights }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding: 10px 0 30px;">
                                        <a href="{{ $checkinUrl }}" style="display: inline-block; background: linear-gradient(135deg, #1a3a5c 0%, #2c5282 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 8px; font-size: 16px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase;">
                                            Completa il Check-in
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            
                            <p style="font-size: 12px; color: #a0aec0; text-align: center; margin: 0 0 25px; word-break: break-all;">
                                {{ $checkinUrl }}
                            </p>
                            
                            @if($checkinInstructions)
                            <!-- Instructions -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #fffbeb; border-left: 4px solid #c9a227; border-radius: 0 8px 8px 0; margin-bottom: 25px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px; font-weight: 600; color: #1a3a5c;">📍 Istruzioni per l'arrivo</p>
                                        <p style="margin: 0; font-size: 14px; color: #4a5568; line-height: 1.6;">{{ $checkinInstructions }}</p>
                                    </td>
                                </tr>
                            </table>
                            @endif
                            
                            @if($propertyAddress)
                            <p style="font-size: 14px; color: #4a5568; margin: 0;">
                                <strong>📍 Indirizzo:</strong> {{ $propertyAddress }}
                            </p>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1a3a5c; padding: 30px; text-align: center;">
                            <p style="margin: 0 0 10px; color: #ffffff; font-weight: 600;">{{ $propertyName }}</p>
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
