<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Link non valido - Blu Trasimeno</title>
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
        
        .error-card {
            background: white;
            border-radius: 1rem;
            padding: 3rem;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        
        .error-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #f56565, #e53e3e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(245, 101, 101, 0.3);
        }
        
        .error-icon i { font-size: 3rem; color: white; }
        
        .error-card h2 {
            color: var(--blu-primary);
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .reason-box {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 0.75rem;
            padding: 1.25rem;
            margin: 1.5rem 0;
            color: #991b1b;
        }
        
        .info-box {
            background: var(--blu-light);
            border-left: 4px solid var(--blu-accent);
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
    <div class="error-card">
        <a href="https://www.blutrasimeno.it/">
            <img src="https://www.blutrasimeno.it/wp-content/uploads/2025/07/logo-white-scaled.png" alt="Blu Trasimeno" class="logo">
        </a>
        
        <div class="error-icon">
            <i class="bi bi-exclamation-triangle"></i>
        </div>
        
        <h2>Link non valido</h2>
        
        <div class="reason-box">
            <i class="bi bi-x-circle me-2"></i>{{ $reason }}
        </div>

        <div class="info-box">
            <i class="bi bi-info-circle me-2" style="color: var(--blu-accent);"></i>
            <strong>Hai già completato il check-in?</strong><br>
            Non devi fare altro! Per assistenza o modifiche, contatta direttamente la struttura.
        </div>

        <div class="footer-info">
            <p><strong>Blu Trasimeno</strong></p>
            <p><i class="bi bi-geo-alt me-1"></i>Via Paolo Borsellino 5, Tuoro sul Trasimeno (PG)</p>
        </div>

        <a href="https://www.blutrasimeno.it/contatti/" class="btn-home">
            <i class="bi bi-envelope me-2"></i>Contattaci
        </a>
    </div>
</body>
</html>
