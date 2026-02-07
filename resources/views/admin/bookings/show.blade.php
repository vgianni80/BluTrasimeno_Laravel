<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            Prenotazione #{{ $booking->id }}
            @include('admin.bookings._status-badge', ['status' => $booking->status])
        </h4>
        <div>
            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-outline-primary">
                <i class="bi bi-pencil me-2"></i>Modifica
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Indietro
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Dettagli prenotazione -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-calendar-check me-2"></i>Dettagli Soggiorno</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Check-in</label>
                            <div class="fw-bold">{{ $booking->check_in->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Check-out</label>
                            <div class="fw-bold">{{ $booking->check_out->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small">Notti</label>
                            <div class="fw-bold">{{ $booking->nights }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Ospite Principale</label>
                            <div class="fw-bold">{{ $booking->full_guest_name ?: 'N/D' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Email</label>
                            <div>{{ $booking->guest_email ?: 'N/D' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Telefono</label>
                            <div>{{ $booking->guest_phone ?: 'N/D' }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Fonte</label>
                            <div>{{ $booking->icalSource?->name ?? 'Manuale' }}</div>
                        </div>
                    </div>
                    @if($booking->notes)
                        <hr>
                        <label class="text-muted small">Note</label>
                        <div>{{ $booking->notes }}</div>
                    @endif
                </div>
            </div>

            <!-- Ospiti registrati -->
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-people me-2"></i>Ospiti Registrati ({{ $booking->guests->count() }})</div>
                <div class="card-body p-0">
                    @if($booking->guests->count() > 0)
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Nascita</th>
                                        <th>Documento</th>
                                        <th>Tipo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($booking->guests as $guest)
                                        <tr>
                                            <td>
                                                {{ $guest->nome_completo }}
                                                @if($guest->is_capogruppo)
                                                    <span class="badge bg-primary">Capogruppo</span>
                                                @endif
                                            </td>
                                            <td>{{ $guest->data_nascita->format('d/m/Y') }}<br><small class="text-muted">{{ $guest->comune_nascita }}</small></td>
                                            <td>{{ $guest->numero_documento }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $guest->tipo_documento)) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center py-4 mb-0">Nessun ospite registrato</p>
                    @endif
                </div>
            </div>

            <!-- Log AlloggiatiWeb -->
            @if($booking->alloggiatiwebLogs->count() > 0)
            <div class="card">
                <div class="card-header"><i class="bi bi-journal-text me-2"></i>Log Invii</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead><tr><th>Data</th><th>Stato</th><th>Messaggio</th></tr></thead>
                            <tbody>
                                @foreach($booking->alloggiatiwebLogs->take(5) as $log)
                                    <tr>
                                        <td>{{ $log->sent_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($log->status === 'success')
                                                <span class="badge bg-success">OK</span>
                                            @else
                                                <span class="badge bg-danger">Errore</span>
                                            @endif
                                        </td>
                                        <td><small>{{ Str::limit($log->error_message, 50) }}</small></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Azioni -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header"><i class="bi bi-lightning me-2"></i>Azioni</div>
                <div class="card-body">
                    @if($booking->checkin_token)
                        <div class="mb-3">
                            <label class="text-muted small">Link Check-in</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" value="{{ $booking->getCheckinUrl() }}" id="checkinUrl" readonly>
                                <button class="btn btn-outline-secondary btn-sm" onclick="navigator.clipboard.writeText(document.getElementById('checkinUrl').value); alert('Copiato!')">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                            @if($booking->checkin_link_expires_at)
                                <small class="text-muted">Scade: {{ $booking->checkin_link_expires_at->format('d/m/Y') }}</small>
                            @endif
                        </div>
                    @endif

                    @if(!$booking->checkin_token && $booking->status === 'incomplete')
                        <form method="POST" action="{{ route('admin.bookings.generate-link', $booking) }}" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="bi bi-link-45deg me-2"></i>Genera Link Check-in
                            </button>
                        </form>
                    @endif

                    @if($booking->guest_email && $booking->checkin_token)
                        <form method="POST" action="{{ route('admin.bookings.send-checkin-email', $booking) }}" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-envelope me-2"></i>Invia Email Check-in
                            </button>
                        </form>
                    @endif

                    @if(in_array($booking->status, ['checked_in', 'failed']))
                        <form method="POST" action="{{ route('admin.bookings.resend-alloggiatiweb', $booking) }}">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="bi bi-arrow-repeat me-2"></i>Reinvia ad AlloggiatiWeb
                            </button>
                        </form>
                    @endif

                    @if($booking->last_error)
                        <div class="alert alert-danger mt-3 mb-0">
                            <small><strong>Ultimo errore:</strong><br>{{ $booking->last_error }}</small>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Elimina -->
            <div class="card border-danger">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Eliminare questa prenotazione?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Elimina Prenotazione
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
