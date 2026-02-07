<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Prenotazioni</h4>
        <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Nuova
        </a>
    </div>

    <!-- Filtri -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tutti gli stati</option>
                        <option value="incomplete" {{ request('status') === 'incomplete' ? 'selected' : '' }}>Da completare</option>
                        <option value="complete" {{ request('status') === 'complete' ? 'selected' : '' }}>In attesa</option>
                        <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Check-in OK</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Inviato</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Errore</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control" placeholder="Cerca ospite..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">Filtra</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabella -->
    <div class="card">
        <div class="card-body p-0">
            @if($bookings->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Ospite</th>
                                <th>Ospiti</th>
                                <th>Fonte</th>
                                <th>Stato</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->check_in->format('d/m/Y') }}</td>
                                    <td>{{ $booking->check_out->format('d/m/Y') }}</td>
                                    <td>
                                        <strong>{{ $booking->full_guest_name ?: 'N/D' }}</strong>
                                        @if($booking->guest_email)
                                            <br><small class="text-muted">{{ $booking->guest_email }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $booking->guests->count() ?: ($booking->number_of_guests ?: '-') }}</td>
                                    <td>
                                        @if($booking->icalSource)
                                            <small>{{ $booking->icalSource->name }}</small>
                                        @else
                                            <small class="text-muted">Manuale</small>
                                        @endif
                                    </td>
                                    <td>@include('admin.bookings._status-badge', ['status' => $booking->status])</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-5 mb-0">Nessuna prenotazione trovata</p>
            @endif
        </div>
        @if($bookings->hasPages())
            <div class="card-footer">{{ $bookings->withQueryString()->links() }}</div>
        @endif
    </div>
</x-app-layout>
