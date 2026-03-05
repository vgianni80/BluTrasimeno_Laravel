<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Richieste di Prenotazione</h2>
            <p class="text-muted mb-0">Gestisci le richieste ricevute dal sito web</p>
        </div>
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

    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.public-bookings.index') }}">
                Tutte <span class="badge bg-secondary">{{ $counts['all'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" href="{{ route('admin.public-bookings.index', ['status' => 'pending']) }}">
                In Attesa <span class="badge bg-warning text-dark">{{ $counts['pending'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'confirmed' ? 'active' : '' }}" href="{{ route('admin.public-bookings.index', ['status' => 'confirmed']) }}">
                Confermate <span class="badge bg-success">{{ $counts['confirmed'] }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'rejected' ? 'active' : '' }}" href="{{ route('admin.public-bookings.index', ['status' => 'rejected']) }}">
                Rifiutate <span class="badge bg-danger">{{ $counts['rejected'] }}</span>
            </a>
        </li>
    </ul>

    <div class="card mb-4">
        <div class="card-body py-2">
            <form method="GET" class="row align-items-center g-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Cerca per nome, cognome o email..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search me-1"></i>Cerca
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.public-bookings.index', ['status' => request('status')]) }}" class="btn btn-outline-secondary btn-sm">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($publicBookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ospite</th>
                                <th>Date</th>
                                <th>Dettagli</th>
                                <th>Totale</th>
                                <th>Stato</th>
                                <th>Data Richiesta</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publicBookings as $pb)
                                <tr>
                                    <td>
                                        <strong>{{ $pb->guest_name }} {{ $pb->guest_surname }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            <i class="bi bi-envelope me-1"></i>{{ $pb->guest_email }}
                                        </small>
                                        @if($pb->guest_phone)
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>{{ $pb->guest_phone }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $pb->check_in->format('d/m/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">--> {{ $pb->check_out->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $pb->nights }} notti
                                        </span>
                                        <span class="badge bg-light text-dark">
                                            {{ $pb->guests }} ospiti
                                        </span>
                                    </td>
                                    <td>
                                        <strong class="text-success">EUR {{ number_format($pb->total, 2, ',', '.') }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $pb->status_color }}">
                                            {{ $pb->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $pb->created_at->format('d/m/Y H:i') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $pb->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="text-end">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.public-bookings.show', $pb) }}" class="btn btn-outline-primary" title="Dettagli">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            @if($pb->status === 'pending')
                                                <form action="{{ route('admin.public-bookings.confirm', $pb) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-success" title="Conferma" 
                                                            onclick="return confirm('Confermare questa prenotazione?')">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-outline-danger" title="Rifiuta" 
                                                        data-bs-toggle="modal" data-bs-target="#rejectModal{{ $pb->id }}">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                @if($pb->status === 'pending')
                                <div class="modal fade" id="rejectModal{{ $pb->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.public-bookings.reject', $pb) }}" method="POST">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Rifiuta Richiesta</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Stai rifiutando la richiesta di <strong>{{ $pb->guest_name }} {{ $pb->guest_surname }}</strong>.</p>
                                                    <div class="mb-3">
                                                        <label class="form-label">Motivo (opzionale)</label>
                                                        <textarea name="admin_notes" class="form-control" rows="3" 
                                                                  placeholder="Es. Le date richieste non sono disponibili..."></textarea>
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
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $publicBookings->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-4 text-muted"></i>
                    <p class="text-muted mt-3">Nessuna richiesta di prenotazione trovata</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
