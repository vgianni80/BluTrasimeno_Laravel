<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Check-in Online - {{ $propertyName }}</title>
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
            --text-dark: #2d3748;
            --text-light: #718096;
        }
        
        * { box-sizing: border-box; }
        
        body {
            font-family: 'Montserrat', sans-serif;
            font-weight: 300;
            color: var(--text-dark);
            background: linear-gradient(135deg, #f7fafc 0%, var(--blu-light) 100%);
            min-height: 100vh;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
        }
        
        .site-header {
            background: var(--blu-primary);
            padding: 1rem 0;
        }
        
        .site-header .logo { height: 50px; }
        
        .hero {
            background: linear-gradient(rgba(26, 58, 92, 0.85), rgba(26, 58, 92, 0.9)), 
                        url('https://www.blutrasimeno.it/wp-content/uploads/2025/07/copertina09.jpg') center/cover;
            color: white;
            padding: 3rem 0;
            text-align: center;
        }
        
        .hero h1 { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        .hero p { font-size: 1rem; opacity: 0.9; }
        
        .booking-summary {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(26, 58, 92, 0.1);
            padding: 1.5rem;
            margin-top: -2rem;
            position: relative;
            z-index: 10;
        }
        
        .booking-summary .date-box { text-align: center; padding: 1rem; }
        .booking-summary .date-box label { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-light); }
        .booking-summary .date-box .value { font-size: 1.25rem; font-weight: 600; color: var(--blu-primary); }
        
        .main-content { padding: 2rem 0 3rem; }
        
        .info-box {
            background: var(--blu-light);
            border-left: 4px solid var(--blu-accent);
            padding: 1rem 1.25rem;
            border-radius: 0 0.5rem 0.5rem 0;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        
        .guest-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 5px 20px rgba(26, 58, 92, 0.08);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }
        
        .guest-card-header {
            background: var(--blu-primary);
            color: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .guest-card-header h5 { margin: 0; font-size: 1.1rem; font-family: 'Cormorant Garamond', serif; }
        .guest-card-header .badge { background: var(--gold); font-size: 0.7rem; padding: 0.35rem 0.75rem; }
        .guest-card-header .btn-remove {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.85rem;
        }
        .guest-card-header .btn-remove:hover { background: rgba(255,255,255,0.3); }
        .guest-card-body { padding: 1.5rem; }
        
        .form-label { font-size: 0.85rem; font-weight: 500; color: var(--text-light); }
        .form-control, .form-select {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.6rem 0.9rem;
            font-size: 0.9rem;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--blu-accent);
            box-shadow: 0 0 0 3px rgba(74, 144, 184, 0.1);
        }
        
        .section-title {
            color: var(--blu-primary);
            font-size: 1rem;
            margin: 1rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--blu-light);
            font-family: 'Cormorant Garamond', serif;
        }
        
        .btn-add-guest {
            background: white;
            border: 2px dashed var(--blu-accent);
            color: var(--blu-accent);
            padding: 1rem;
            border-radius: 0.75rem;
            width: 100%;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-add-guest:hover {
            background: var(--blu-light);
            border-color: var(--blu-primary);
            color: var(--blu-primary);
        }
        
        .btn-submit {
            background: var(--blu-primary);
            border: none;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 0.5rem;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            background: var(--blu-secondary);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 58, 92, 0.2);
        }
        
        .privacy-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 5px 20px rgba(26, 58, 92, 0.08);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .site-footer {
            background: var(--blu-primary);
            color: rgba(255,255,255,0.7);
            padding: 2rem 0;
            font-size: 0.9rem;
        }
        .site-footer a { color: rgba(255,255,255,0.8); text-decoration: none; }
        
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 0.75rem;
        }
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 1.75rem; }
            .guest-card-body { padding: 1rem; }
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <a href="https://www.blutrasimeno.it/">
                <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" class="logo">
            </a>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h1><i class="bi bi-person-check me-2"></i>Check-in Online</h1>
            <p>Compila i dati degli ospiti per velocizzare il tuo arrivo</p>
        </div>
    </section>

    <main class="main-content">
        <div class="container">
            <div class="booking-summary mb-4">
                <div class="row text-center">
                    <div class="col-4 date-box">
                        <label>Check-in</label>
                        <div class="value">{{ $booking->check_in->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-4 date-box" style="border-left: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0;">
                        <label>Check-out</label>
                        <div class="value">{{ $booking->check_out->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-4 date-box">
                        <label>Notti</label>
                        <div class="value">{{ $booking->nights }}</div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="info-box">
                        <i class="bi bi-info-circle me-2" style="color: var(--blu-accent);"></i>
                        Per legge italiana, tutti gli ospiti devono essere registrati. Compila i dati di <strong>tutti</strong> gli ospiti che soggiorneranno.
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i><strong>Attenzione:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checkin.store', $booking->checkin_token) }}" id="checkinForm">
                        @csrf
                        <div id="guestsContainer">
                            @for($i = 0; $i < max(1, $booking->number_of_guests ?? 1); $i++)
                                @include('checkin._guest-form', ['index' => $i, 'isFirst' => $i === 0])
                            @endfor
                        </div>

                        <button type="button" class="btn-add-guest mb-4" onclick="addGuest()">
                            <i class="bi bi-plus-lg me-2"></i>Aggiungi Ospite
                        </button>

                        <div class="privacy-card">
                            <div class="form-check">
                                <input type="checkbox" name="privacy" class="form-check-input" id="privacy" required>
                                <label class="form-check-label" for="privacy">
                                    Accetto il trattamento dei dati personali ai sensi del GDPR per l'adempimento degli obblighi di legge.
                                    <a href="https://www.blutrasimeno.it/termsfeed/privacy-policy/" target="_blank">Leggi la Privacy Policy</a>
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-submit btn-primary btn-lg">
                                <i class="bi bi-check-lg me-2"></i>Completa Check-in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <footer class="site-footer">
        <div class="container text-center">
            <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" style="height: 35px;" class="mb-2">
            <p class="mb-0">Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG) · ©2025 Blu Trasimeno</p>
        </div>
    </footer>

    <template id="guestTemplate">
        @include('checkin._guest-form', ['index' => '__INDEX__', 'isFirst' => false])
    </template>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let guestCount = {{ max(1, $booking->number_of_guests ?? 1) }};
        function addGuest() {
            const template = document.getElementById('guestTemplate').innerHTML;
            document.getElementById('guestsContainer').insertAdjacentHTML('beforeend', template.replace(/__INDEX__/g, guestCount));
            guestCount++;
        }
        function removeGuest(btn) { btn.closest('.guest-card').remove(); }
    </script>
</body>
</html>
