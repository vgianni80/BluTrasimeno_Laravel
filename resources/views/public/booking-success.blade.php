<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Richiesta Inviata - Blu Trasimeno</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --blu-primary: #1a3a5c;
            --blu-secondary: #2c5282;
            --blu-light: #e8f0f7;
            --blu-accent: #4a90b8;
            --gold: #c9a227;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            background: linear-gradient(135deg, var(--blu-primary) 0%, var(--blu-secondary) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cormorant Garamond', serif;
        }
        
        .success-card {
            background: white;
            border-radius: 1rem;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #48bb78, #38a169);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(72, 187, 120, 0.3);
        }
        
        .success-icon i {
            font-size: 3rem;
            color: white;
        }
        
        .success-card h2 {
            color: var(--blu-primary);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .booking-details {
            background: var(--blu-light);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin: 2rem 0;
            text-align: left;
        }
        
        .booking-details .row > div {
            padding: 0.5rem 0;
        }
        
        .booking-details label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #718096;
            display: block;
        }
        
        .booking-details .value {
            font-weight: 500;
            color: var(--blu-primary);
        }
        
        .booking-details .total {
            font-size: 1.25rem;
            color: #48bb78;
        }
        
        .info-alert {
            background: #ebf8ff;
            border-left: 4px solid var(--blu-accent);
            padding: 1rem;
            border-radius: 0 0.5rem 0.5rem 0;
            text-align: left;
            font-size: 0.9rem;
        }
        
        .logo {
            height: 40px;
            margin-bottom: 1rem;
        }
        
        .btn-back {
            background: var(--blu-primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-back:hover {
            background: var(--blu-secondary);
            color: white;
            transform: translateY(-2px);
        }
        
        .footer-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-info p {
            margin: 0;
            font-size: 0.9rem;
            color: #718096;
        }
    </style>
</head>
<body>
    <div class="success-card">
        <a href="https://www.blutrasimeno.it/">
            <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" class="logo" style="filter: brightness(0) saturate(100%) invert(19%) sepia(31%) saturate(1095%) hue-rotate(175deg) brightness(93%) contrast(91%);">
        </a>
        
        <div class="success-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        
        <h2>Richiesta Inviata!</h2>
        <p class="text-muted">Grazie per aver scelto Blu Trasimeno.<br>Ti risponderemo entro 24 ore.</p>

        <div class="booking-details">
            <div class="row">
                <div class="col-6">
                    <label>Check-in</label>
                    <div class="value">{{ $publicBooking->check_in->format('d/m/Y') }}</div>
                </div>
                <div class="col-6">
                    <label>Check-out</label>
                    <div class="value">{{ $publicBooking->check_out->format('d/m/Y') }}</div>
                </div>
                <div class="col-6">
                    <label>Notti</label>
                    <div class="value">{{ $publicBooking->nights }}</div>
                </div>
                <div class="col-6">
                    <label>Ospiti</label>
                    <div class="value">{{ $publicBooking->guests }}</div>
                </div>
                <div class="col-12 mt-2 pt-2" style="border-top: 1px solid #cbd5e0;">
                    <label>Totale Soggiorno</label>
                    <div class="value total">€ {{ number_format($publicBooking->total, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="info-alert">
            <i class="bi bi-envelope me-2" style="color: var(--blu-accent);"></i>
            Ti abbiamo inviato una email di conferma a <strong>{{ $publicBooking->guest_email }}</strong>
        </div>

        <div class="footer-info">
            <p><strong>{{ $propertyName }}</strong></p>
            <p>Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG)</p>
            @if($propertyPhone)
                <p><i class="bi bi-telephone me-1"></i>{{ $propertyPhone }}</p>
            @endif
        </div>

        <a href="https://www.blutrasimeno.it/" class="btn-back mt-4">
            <i class="bi bi-arrow-left me-2"></i>Torna al Sito
        </a>
    </div>
</body>
</html>
