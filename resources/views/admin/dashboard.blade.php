<x-app-layout>
    <h4 class="mb-4">Dashboard</h4>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stats-card warning">
                <h3>{{ $stats['incomplete'] }}</h3>
                <p>Da completare</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card info">
                <h3>{{ $stats['complete'] }}</h3>
                <p>In attesa check-in</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card success">
                <h3>{{ $stats['checked_in'] + $stats['sent'] }}</h3>
                <p>Check-in OK</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card danger">
                <h3>{{ $stats['failed'] }}</h3>
                <p>Errori invio</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Check-in Oggi -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-event me-2"></i>Check-in Oggi
                </div>
                <div class="card-body p-0">
                    @if($todayBookings->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($todayBookings as $booking)
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $booking->full_guest_name ?: 'N/D' }}</strong>
                                        @include('admin.bookings._status-badge', ['status' => $booking->status])
                                    </div>
                                    <small class="text-muted">{{ $booking->guests->count() }} ospiti</small>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4 mb-0">Nessun check-in oggi</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Da Completare -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-exclamation-triangle me-2"></i>Da Completare
                </div>
                <div class="card-body p-0">
                    @if($incompleteBookings->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($incompleteBookings as $booking)
                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $booking->full_guest_name ?: 'Ospite sconosciuto' }}</strong>
                                        <span class="badge bg-secondary">{{ $booking->check_in->format('d/m') }}</span>
                                    </div>
                                    @if($booking->icalSource)
                                        <small class="text-muted">{{ $booking->icalSource->name }}</small>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted text-center py-4 mb-0">Tutto in ordine!</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Prossimi 7 giorni -->
    @if($upcomingBookings->count() > 0)
    <div class="card mt-4">
        <div class="card-header">
            <i class="bi bi-calendar-week me-2"></i>Prossimi 7 Giorni
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Check-in</th>
                            <th>Ospite</th>
                            <th>Notti</th>
                            <th>Stato</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingBookings as $booking)
                            <tr>
                                <td>{{ $booking->check_in->format('d/m/Y') }}</td>
                                <td>{{ $booking->full_guest_name ?: 'N/D' }}</td>
                                <td>{{ $booking->nights }}</td>
                                <td>@include('admin.bookings._status-badge', ['status' => $booking->status])</td>
                                <td><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">Dettagli</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
