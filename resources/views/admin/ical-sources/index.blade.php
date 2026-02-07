<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Fonti iCal</h4>
        <a href="{{ route('admin.ical-sources.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Aggiungi
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            @if($icalSources->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Frequenza</th>
                                <th>Ultima Sync</th>
                                <th>Prenotazioni</th>
                                <th>Stato</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($icalSources as $source)
                                <tr>
                                    <td>
                                        <strong>{{ $source->name }}</strong>
                                        <br><small class="text-muted">{{ Str::limit($source->url, 40) }}</small>
                                    </td>
                                    <td>{{ $source->polling_frequency_minutes }} min</td>
                                    <td>
                                        @if($source->last_synced_at)
                                            {{ $source->last_synced_at->diffForHumans() }}
                                        @else
                                            <span class="text-muted">Mai</span>
                                        @endif
                                    </td>
                                    <td>{{ $source->bookings_count }}</td>
                                    <td>
                                        @if($source->is_active)
                                            <span class="badge bg-success">Attivo</span>
                                        @else
                                            <span class="badge bg-secondary">Inattivo</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <form method="POST" action="{{ route('admin.ical-sources.sync', $source) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success" title="Sincronizza ora">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>
                                            <a href="{{ route('admin.ical-sources.edit', $source) }}" class="btn btn-outline-primary">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.ical-sources.destroy', $source) }}" 
                                                  onsubmit="return confirm('Eliminare questo calendario?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-calendar-x fs-1 text-muted"></i>
                    <p class="mt-3">Nessun calendario configurato</p>
                    <a href="{{ route('admin.ical-sources.create') }}" class="btn btn-primary">Aggiungi il primo</a>
                </div>
            @endif
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Come funziona</div>
        <div class="card-body">
            <p>I calendari iCal vengono sincronizzati automaticamente in base alla frequenza impostata. Le nuove prenotazioni vengono create con stato "Da completare".</p>
            <p class="mb-0"><strong>Dove trovo l'URL?</strong></p>
            <ul class="mb-0">
                <li><strong>Booking.com:</strong> Extranet → Tariffe e disponibilità → Sincronizza calendari → Esporta</li>
                <li><strong>Airbnb:</strong> Calendario → Impostazioni → Esporta calendario</li>
            </ul>
        </div>
    </div>
</x-app-layout>
