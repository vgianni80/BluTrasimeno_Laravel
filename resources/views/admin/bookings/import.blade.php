<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Importa Prenotazioni da Holidu</h4>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Indietro
        </a>
    </div>

    @if(session('import_result'))
        @php $result = session('import_result'); @endphp
        <div class="alert alert-{{ ($result['created'] + $result['updated']) > 0 ? 'success' : 'warning' }} mb-4">
            <strong>Import completato:</strong>
            {{ $result['created'] }} nuove prenotazioni create,
            {{ $result['updated'] }} aggiornate con dati finanziari,
            {{ $result['skipped'] }} saltate (CANCELLED o riga non valida).
            @if(count($result['errors']))
                <hr class="my-2">
                <strong>Avvisi:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($result['errors'] as $err)
                        <li><small>{{ $err }}</small></li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-excel me-2"></i>Carica file Excel
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bookings.import.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-semibold">File Excel Holidu (.xlsx)</label>
                            <input type="file"
                                   name="file"
                                   class="form-control @error('file') is-invalid @enderror"
                                   accept=".xlsx,.xls">
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Esporta il file da <strong>Holidu › Rendiconti › Prenotazioni</strong> in formato Excel.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-2"></i>Importa
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header"><i class="bi bi-info-circle me-2"></i>Informazioni</div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Il file deve contenere le seguenti colonne nell'ordine standard Holidu:</p>
                    <table class="table table-sm table-borderless small mb-0">
                        <tbody>
                            <tr><td class="text-muted pe-2">A</td><td>Booking ID</td></tr>
                            <tr><td class="text-muted pe-2">E</td><td>Channel</td></tr>
                            <tr><td class="text-muted pe-2">F</td><td>Guest Name</td></tr>
                            <tr><td class="text-muted pe-2">G–I</td><td>Nr. Adults / Children / Babies</td></tr>
                            <tr><td class="text-muted pe-2">K</td><td>Paid by Guest</td></tr>
                            <tr><td class="text-muted pe-2">L</td><td>Date of Booking</td></tr>
                            <tr><td class="text-muted pe-2">M–N</td><td>Check In / Check Out</td></tr>
                            <tr><td class="text-muted pe-2">O</td><td>Booking Status</td></tr>
                            <tr><td class="text-muted pe-2">P</td><td>Home Owner Payout</td></tr>
                            <tr><td class="text-muted pe-2">Q</td><td>VAT</td></tr>
                            <tr><td class="text-muted pe-2">R</td><td>Bookiply Commission</td></tr>
                            <tr><td class="text-muted pe-2">S</td><td>Channel Commission</td></tr>
                            <tr><td class="text-muted pe-2">T</td><td>Bookiply Processing Markup</td></tr>
                            <tr><td class="text-muted pe-2">X</td><td>Withheld amounts (Cedolare Secca)</td></tr>
                        </tbody>
                    </table>
                    <hr class="my-2">
                    <p class="text-muted small mb-0">
                        Le prenotazioni già presenti (stesso Booking ID o stessa data di check-in
                        e cognome ospite) vengono <strong>aggiornate</strong> con i dati finanziari
                        dell'Excel, senza sovrascrivere i dati anagrafici già compilati.
                        Le prenotazioni con stato <strong>CANCELLED</strong> vengono saltate.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
