<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('admin.public-bookings.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Torna alle Richieste
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-calendar-check me-2"></i>Richiesta #{{ $publicBooking->id }}</span>
                    <span class="badge bg-{{ $publicBooking->status_color }} fs-6">{{ $publicBooking->status_label }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small">Dati Ospite</h6>
                            <p class="mb-1"><strong>{{ $publicBooking->guest_name }} {{ $publicBooking->guest_surname }}</strong></p>
                            <p class="mb-1">
                                <i class="bi bi-envelope me-2 text-muted"></i>
                                <a href="mailto:{{ $publicBooking->guest_email }}">{{ $publicBooking->guest_email }}</a>
                            </p>
                            @if($publicBooking->guest_phone)
                                <p class="mb-0">
                                    <i class="bi bi-telephone me-2 text-muted"></i>
                                    <a href="tel:{{ $publicBooking->guest_phone }}">{{ $publicBooking->guest_phone }}</a>
                                </p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted text-uppercase small">Date Soggiorno</h6>
                            <p class="mb-1">
                                <strong>Check-in:</strong> {{ $publicBooking->check_in->format('d/m/Y') }} 
                                <small class="text-muted">({{ $publicBooking->check_in->translatedFormat('l') }})</small>
                            </p>
                            <p class="mb-1">
                                <strong>Check-out:</strong> {{ $publicBooking->check_out->format('d/m/Y') }}
                                <small class="text-muted">({{ $publicBooking->check_out->translatedFormat('l') }})</small>
                            </p>
                            <p class="mb-0">
                                <span class="badge bg-primary">{{ $publicBooking->nights }} notti</span>
                                <span class="badge bg-secondary">{{ $publicBooking->guests }} ospiti</span>
                            </p>
                        </div>
                    </div>

                    @if($publicBooking->notes)
                        <hr>
                        <h6 class="text-muted text-uppercase small">Note dell'Ospite</h6>
                        <p class="mb-0 bg-light p-3 rounded">{{ $publicBooking->notes }}</p>
                    @endif

                    @if($publicBooking->admin_notes)
                        <hr>
                        <h6 class="text-muted text-uppercase small">Note Admin</h6>
                        <p class="mb-0 bg-warning bg-opacity-10 p-3 rounded">{{ $publicBooking->admin_notes }}</p>
                    @endif
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-receipt me-2"></i>Riepilogo Economico
                </div>
                <div class="card-body">
                    @php $breakdown = $publicBooking->price_breakdown; @endphp
                    <table class="table table-sm mb-0">
                        <tr>
                            <td>{{ $breakdown['nights'] ?? $publicBooking->nights }} notti</td>
                            <td class="text-end">EUR {{ number_format($breakdown['subtotal'] ?? $publicBooking->total, 2, ',', '.') }}</td>
                        </tr>
                        @if(isset($breakdown['discount']) && $breakdown['discount'] > 0)
                            <tr class="text-success">
                                <td>Sconto {{ $breakdown['discount_percent'] }}%</td>
                                <td class="text-end">- EUR {{ number_format($breakdown['discount'], 2, ',', '.') }}</td>
                            </tr>
                        @endif
                        @if(isset($breakdown['cleaning_fee']) && $breakdown['cleaning_fee'] > 0)
                            <tr>
                                <td>Pulizie finali</td>
                                <td class="text-end">EUR {{ number_format($breakdown['cleaning_fee'], 2, ',', '.') }}</td>
                            </tr>
                        @endif
                        <tr class="table-light fw-bold">
                            <td>TOTALE</td>
                            <td class="text-end text-success fs-5">EUR {{ number_format($publicBooking->total, 2, ',', '.') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($publicBooking->booking)
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-link-45deg me-2"></i>Prenotazione Collegata
                    </div>
                    <div class="card-body">
                        <p class="mb-2">Questa richiesta e stata convertita nella prenotazione <strong>#{{ $publicBooking->booking->id }}</strong></p>
                        <a href="{{ route('admin.bookings.show', $publicBooking->booking) }}" class="btn btn-outline-success">
                            <i class="bi bi-eye me-2"></i>Visualizza Prenotazione
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-lightning me-2"></i>Azioni
                </div>
                <div class="card-body">
                    @if($publicBooking->status === 'pending')
                        <form action="{{ route('admin.public-bookings.confirm', $publicBooking) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="form-check mb-3">
                                <input type="checkbox" name="create_booking" value="1" class="form-check-input" id="createBooking" checked>
                                <label class="form-check-label" for="createBooking">
                                    Crea anche la prenotazione nel calendario
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Confermare questa prenotazione?')">
                                <i class="bi bi-check-lg me-2"></i>Conferma Richiesta
                            </button>
                        </form>

                        <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            <i class="bi bi-x-lg me-2"></i>Rifiuta Richiesta
                        </button>

                        <div class="modal fade" id="rejectModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('admin.public-bookings.reject', $publicBooking) }}" method="POST">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rifiuta Richiesta</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Motivo (verra inviato all'ospite)</label>
                                                <textarea name="admin_notes" class="form-control" rows="3" 
                                                          placeholder="Es. Ci dispiace, le date richieste non sono disponibili..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                                            <button type="submit" class="btn btn-danger">Rifiuta e Notifica</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-{{ $publicBooking->status_color }} mb-0">
                            <i class="bi bi-info-circle me-2"></i>
                            Questa richiesta e gia stata 
                            <strong>{{ strtolower($publicBooking->status_label) }}</strong>
                            @if($publicBooking->updated_at)
                                il {{ $publicBooking->updated_at->format('d/m/Y H:i') }}
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle me-2"></i>Informazioni
                </div>
                <div class="card-body">
                    <p class="mb-2"><small class="text-muted">Richiesta ricevuta:</small><br>{{ $publicBooking->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-0"><small class="text-muted">Ultimo aggiornamento:</small><br>{{ $publicBooking->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
