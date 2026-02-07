<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ isset($icalSource) ? 'Modifica Calendario' : 'Nuovo Calendario' }}</h4>
        <a href="{{ route('admin.ical-sources.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Indietro
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ isset($icalSource) ? route('admin.ical-sources.update', $icalSource) : route('admin.ical-sources.store') }}">
                        @csrf
                        @if(isset($icalSource))
                            @method('PUT')
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Nome <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $icalSource->name ?? '') }}" 
                                   placeholder="es. Booking.com Casa Vacanze" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL Feed iCal <span class="text-danger">*</span></label>
                            <input type="url" name="url" class="form-control @error('url') is-invalid @enderror" 
                                   value="{{ old('url', $icalSource->url ?? '') }}" 
                                   placeholder="https://..." required>
                            @error('url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Frequenza Sincronizzazione</label>
                            <select name="polling_frequency_minutes" class="form-select">
                                @foreach([15 => '15 minuti', 30 => '30 minuti', 60 => '1 ora', 120 => '2 ore', 360 => '6 ore', 720 => '12 ore', 1440 => '24 ore'] as $value => $label)
                                    <option value="{{ $value }}" {{ old('polling_frequency_minutes', $icalSource->polling_frequency_minutes ?? 60) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" class="form-check-input" id="is_active" value="1"
                                       {{ old('is_active', $icalSource->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Calendario Attivo</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.ical-sources.index') }}" class="btn btn-outline-secondary">Annulla</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Salva
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
