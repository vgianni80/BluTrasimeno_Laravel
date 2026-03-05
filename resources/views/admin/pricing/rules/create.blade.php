<x-app-layout>
    <div class="mb-4">
        <a href="{{ route('admin.pricing.index') }}" class="text-decoration-none">
            <i class="bi bi-arrow-left me-1"></i>Torna alle Tariffe
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle me-2"></i>Nuova Regola Tariffaria
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pricing.rules.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nome Regola *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="es. Tariffa Base, Alta Stagione Estate, Weekend" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo *</label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" id="ruleType" required>
                                    <option value="base" {{ old('type') == 'base' ? 'selected' : '' }}>Base (sempre applicata)</option>
                                    <option value="seasonal" {{ old('type') == 'seasonal' ? 'selected' : '' }}>Stagionale (periodo specifico)</option>
                                    <option value="weekend" {{ old('type') == 'weekend' ? 'selected' : '' }}>Weekend (giorni specifici)</option>
                                    <option value="special" {{ old('type') == 'special' ? 'selected' : '' }}>Speciale (evento/festività)</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prezzo per Notte *</label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input type="number" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror" 
                                           value="{{ old('price_per_night') }}" min="0" step="0.01" required>
                                </div>
                                @error('price_per_night')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Periodo (per seasonal e special) -->
                        <div id="dateRange" class="row" style="display: none;">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data Inizio</label>
                                <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror" 
                                       value="{{ old('start_date') }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Data Fine</label>
                                <input type="date" name="end_date" class="form-control @error('end_date') is-invalid @enderror" 
                                       value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Giorni della settimana (per weekend) -->
                        <div id="daysOfWeek" class="mb-3" style="display: none;">
                            <label class="form-label">Giorni della Settimana</label>
                            <div class="d-flex flex-wrap gap-2">
                                @php $days = ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab']; @endphp
                                @foreach($days as $index => $day)
                                    <div class="form-check">
                                        <input type="checkbox" name="days_of_week[]" value="{{ $index }}" 
                                               class="form-check-input" id="day{{ $index }}"
                                               {{ in_array($index, old('days_of_week', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="day{{ $index }}">{{ $day }}</label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="text-muted">Seleziona i giorni a cui applicare questa tariffa</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priorità *</label>
                                <input type="number" name="priority" class="form-control @error('priority') is-invalid @enderror" 
                                       value="{{ old('priority', 0) }}" min="0" max="100" required>
                                <small class="text-muted">0 = più bassa, 100 = più alta. Le regole con priorità maggiore prevalgono.</small>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stato</label>
                                <div class="form-check form-switch mt-2">
                                    <input type="checkbox" name="is_active" value="1" class="form-check-input" id="isActive" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isActive">Regola Attiva</label>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pricing.index') }}" class="btn btn-outline-secondary">
                                Annulla
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg me-2"></i>Crea Regola
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('ruleType').addEventListener('change', function() {
            const type = this.value;
            const dateRange = document.getElementById('dateRange');
            const daysOfWeek = document.getElementById('daysOfWeek');

            dateRange.style.display = (type === 'seasonal' || type === 'special') ? 'flex' : 'none';
            daysOfWeek.style.display = (type === 'weekend') ? 'block' : 'none';
        });

        // Trigger on page load
        document.getElementById('ruleType').dispatchEvent(new Event('change'));
    </script>
</x-app-layout>
