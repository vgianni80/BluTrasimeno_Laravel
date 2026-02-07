<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Check-in Completato</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .success-card { background: white; border-radius: 1rem; padding: 3rem; text-align: center; max-width: 500px; margin: auto; }
        .success-icon { width: 80px; height: 80px; background: #28a745; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .success-icon i { font-size: 2.5rem; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-card">
            <div class="success-icon">
                <i class="bi bi-check-lg"></i>
            </div>
            <h2>Check-in già completato</h2>
            <p class="text-muted">La registrazione per questa prenotazione è già stata effettuata.</p>

            <div class="bg-light rounded p-3 my-4">
                <div class="row text-start">
                    <div class="col-6 mb-2">
                        <small class="text-muted">Check-in</small>
                        <div class="fw-bold">{{ $booking->check_in->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted">Check-out</small>
                        <div class="fw-bold">{{ $booking->check_out->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Ospiti registrati</small>
                        <div class="fw-bold">{{ $booking->guests->count() }}</div>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Completato il</small>
                        <div class="fw-bold">{{ $booking->checkin_completed_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="alert alert-warning text-start">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Hai bisogno di modificare i dati?</strong><br>
                Contatta direttamente la struttura per richiedere eventuali correzioni.
            </div>

            @if($checkinInstructions)
                <div class="alert alert-info text-start">
                    <strong><i class="bi bi-info-circle me-2"></i>Istruzioni per il check-in:</strong>
                    <p class="mb-0 mt-2">{{ $checkinInstructions }}</p>
                </div>
            @endif

            <hr>
            <p class="mb-1"><strong>{{ $propertyName }}</strong></p>
            @if($propertyAddress)<p class="text-muted small mb-1"><i class="bi bi-geo-alt me-1"></i>{{ $propertyAddress }}</p>@endif
            @if($propertyPhone)<p class="text-muted small mb-0"><i class="bi bi-telephone me-1"></i>{{ $propertyPhone }}</p>@endif
        </div>
    </div>
</body>
</html>