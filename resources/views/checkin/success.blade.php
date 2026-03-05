<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check-in Completato - Blu Trasimeno</title>
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
        
        h1, h2, h3, h4, h5, h6 { font-family: 'Cormorant Garamond', serif; }
        
        .success-card {
            background: white;
            border-radius: 1rem;
            padding: 3rem;
            max-width: 550px;
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
        
        .success-icon i { font-size: 3rem; color: white; }
        
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
        
        .guest-list {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            text-align: left;
        }
        
        .guest-list h6 {
            color: var(--blu-primary);
            margin-bottom: 0.75rem;
            font-size: 0.9rem;
        }
        
        .guest-list ul {
            margin: 0;
            padding-left: 1.25rem;
            font-size: 0.9rem;
        }
        
        .info-box {
            background: #ebf8ff;
            border-left: 4px solid var(--blu-accent);
            padding: 1rem;
            border-radius: 0 0.5rem 0.5rem 0;
            text-align: left;
            font-size: 0.9rem;
            margin: 1.5rem 0;
        }
        
        .warning-box {
            background: #fffbeb;
            border-left: 4px solid var(--gold);
            padding: 1rem;
            border-radius: 0 0.5rem 0.5rem 0;
            text-align: left;
            font-size: 0.9rem;
        }
        
        .logo {
            height: 40px;
            margin-bottom: 1rem;
            filter: brightness(0) saturate(100%) invert(19%) sepia(31%) saturate(1095%) hue-rotate(175deg) brightness(93%) contrast(91%);
        }
        
        .footer-info {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-info p {
            margin: 0.25rem 0;
            font-size: 0.9rem;
            color: #718096;
        }
        
        .btn-home {
            background: var(--blu-primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            margin-top: 1rem;
        }
        
        .btn-home:hover {
            background: var(--blu-secondary);
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="success-card">
        <a href="https://www.blutrasimeno.it/">
            <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" class="logo">
        </a>
        
        <div class="success-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        
        <h2>Check-in Completato!</h2>
        <p class="text-muted">La registrazione è stata completata con successo.</p>

        <div class="booking-details">
            <div class="row">
                <div class="col-6 mb-2">
                    <label>Check-in</label>
                    <div class="value">{{ $booking->check_in->format('d/m/Y') }}</div>
                </div>
                <div class="col-6 mb-2">
                    <label>Check-out</label>
                    <div class="value">{{ $booking->check_out->format('d/m/Y') }}</div>
                </div>
                <div class="col-6">
                    <label>Notti</label>
                    <div class="value">{{ $booking->nights }}</div>
                </div>
                <div class="col-6">
                    <label>Registrato il</label>
                    <div class="value">{{ $booking->checkin_completed_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
            
            <div class="guest-list">
                <h6><i class="bi bi-people me-2"></i>Ospiti Registrati ({{ $booking->guests->count() }})</h6>
                <ul>
                    @foreach($booking->guests as $guest)
                        <li>{{ $guest->nome }} {{ $guest->cognome }} @if($guest->is_capogruppo)<small class="text-muted">(Capogruppo)</small>@endif</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="warning-box">
            <i class="bi bi-exclamation-triangle me-2" style="color: var(--gold);"></i>
            <strong>Devi modificare i dati?</strong><br>
            Contatta direttamente la struttura per richiedere eventuali correzioni.
        </div>

        @if($checkinInstructions)
            <div class="info-box">
                <i class="bi bi-info-circle me-2" style="color: var(--blu-accent);"></i>
                <strong>Istruzioni per l'arrivo:</strong><br>
                {{ $checkinInstructions }}
            </div>
        @endif

        <div class="footer-info">
            <p><strong>{{ $propertyName }}</strong></p>
            @if($propertyAddress)<p><i class="bi bi-geo-alt me-1"></i>{{ $propertyAddress }}</p>@endif
            @if($propertyPhone)<p><i class="bi bi-telephone me-1"></i>{{ $propertyPhone }}</p>@endif
        </div>

        <a href="https://www.blutrasimeno.it/" class="btn-home">
            <i class="bi bi-house me-2"></i>Visita il Sito
        </a>
    </div>
</body>
</html>
