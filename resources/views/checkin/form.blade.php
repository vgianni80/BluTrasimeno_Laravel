<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Check-in Online - {{ $propertyName }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', system-ui, sans-serif; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2rem; text-align: center; }
        .guest-card { background: white; border-radius: 0.5rem; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
        .guest-card-header { background: #f8f9fa; padding: 1rem; border-bottom: 1px solid #e9ecef; display: flex; justify-content: space-between; align-items: center; }
        .guest-card-body { padding: 1.5rem; }
    </style>
</head>
<body>
    <div class="header">
        <h1><i class="bi bi-house-door-fill me-2"></i>{{ $propertyName }}</h1>
        <p class="mb-0">Check-in Online</p>
    </div>

    <div class="container py-4">
        <!-- Riepilogo -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <small class="text-muted">Check-in</small>
                        <div class="fw-bold">{{ $booking->check_in->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-4">
                        <small class="text-muted">Check-out</small>
                        <div class="fw-bold">{{ $booking->check_out->format('d/m/Y') }}</div>
                    </div>
                    <div class="col-4">
                        <small class="text-muted">Notti</small>
                        <div class="fw-bold">{{ $booking->nights }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="alert alert-info">
            <i class="bi bi-info-circle me-2"></i>
            Per legge italiana, tutti gli ospiti devono essere registrati. Compila i dati di <strong>tutti</strong> gli ospiti.
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
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

            <div class="text-center mb-4">
                <button type="button" class="btn btn-outline-primary" onclick="addGuest()">
                    <i class="bi bi-plus-lg me-2"></i>Aggiungi Ospite
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="form-check">
                        <input type="checkbox" name="privacy" class="form-check-input" id="privacy" required>
                        <label class="form-check-label" for="privacy">
                            Accetto il trattamento dei dati personali ai sensi del GDPR per l'adempimento degli obblighi di legge. <span class="text-danger">*</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-check-lg me-2"></i>Completa Check-in
                </button>
            </div>
        </form>
    </div>

    <template id="guestTemplate">
        @include('checkin._guest-form', ['index' => '__INDEX__', 'isFirst' => false])
    </template>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let guestCount = {{ max(1, $booking->number_of_guests ?? 1) }};
        
        function addGuest() {
            const template = document.getElementById('guestTemplate').innerHTML;
            const newGuest = template.replace(/__INDEX__/g, guestCount);
            document.getElementById('guestsContainer').insertAdjacentHTML('beforeend', newGuest);
            guestCount++;
        }
        
        function removeGuest(btn) {
            btn.closest('.guest-card').remove();
        }
    </script>
</body>
</html>
