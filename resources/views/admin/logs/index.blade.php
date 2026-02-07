<x-app-layout>
    <h4 class="mb-4">Log Invii AlloggiatiWeb</h4>

    <div class="card">
        <div class="card-header">
            <form method="GET" class="d-flex gap-2">
                <select name="status" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    <option value="">Tutti gli stati</option>
                    <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Successo</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Errore</option>
                </select>
            </form>
        </div>
        <div class="card-body p-0">
            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Data/Ora</th>
                                <th>Prenotazione</th>
                                <th>Stato</th>
                                <th>Messaggio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td>{{ $log->sent_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @if($log->booking)
                                            <a href="{{ route('admin.bookings.show', $log->booking) }}">
                                                #{{ $log->booking_id }} - {{ $log->booking->full_guest_name }}
                                            </a>
                                        @else
                                            #{{ $log->booking_id }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($log->status === 'success')
                                            <span class="badge bg-success">OK</span>
                                        @else
                                            <span class="badge bg-danger">Errore</span>
                                        @endif
                                    </td>
                                    <td><small>{{ Str::limit($log->error_message, 80) }}</small></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted text-center py-5 mb-0">Nessun log trovato</p>
            @endif
        </div>
        @if($logs->hasPages())
            <div class="card-footer">{{ $logs->withQueryString()->links() }}</div>
        @endif
    </div>
</x-app-layout>
