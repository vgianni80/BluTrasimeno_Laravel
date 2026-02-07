<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Link non valido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; display: flex; align-items: center; }
        .error-card { background: white; border-radius: 1rem; padding: 3rem; text-align: center; max-width: 500px; margin: auto; }
        .error-icon { width: 80px; height: 80px; background: #dc3545; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; }
        .error-icon i { font-size: 2.5rem; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-card">
            <div class="error-icon">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <h2>Link non valido</h2>
            <p class="text-muted">{{ $reason }}</p>
            <div class="alert alert-info mt-4">
                <i class="bi bi-info-circle me-2"></i>
                Se hai già completato il check-in, non devi fare altro. Per assistenza, contatta la struttura.
            </div>
        </div>
    </div>
</body>
</html>
