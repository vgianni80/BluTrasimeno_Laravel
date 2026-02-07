<div class="guest-card">
    <div class="guest-card-header">
        <strong><i class="bi bi-person me-2"></i>Ospite {{ (int)$index + 1 }} @if($isFirst)<span class="badge bg-primary">Capogruppo</span>@endif</strong>
        @if(!$isFirst)
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeGuest(this)">
                <i class="bi bi-trash"></i>
            </button>
        @endif
    </div>
    <div class="guest-card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][nome]" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Cognome <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][cognome]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Sesso <span class="text-danger">*</span></label>
                <select name="guests[{{ $index }}][sesso]" class="form-select" required>
                    <option value="">Seleziona...</option>
                    <option value="M">Maschio</option>
                    <option value="F">Femmina</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Data Nascita <span class="text-danger">*</span></label>
                <input type="date" name="guests[{{ $index }}][data_nascita]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cittadinanza <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][cittadinanza]" class="form-control" value="ITALIA" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Stato Nascita <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][stato_nascita]" class="form-control" value="ITALIA" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Comune Nascita <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][comune_nascita]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Provincia (sigla)</label>
                <input type="text" name="guests[{{ $index }}][provincia_nascita]" class="form-control" maxlength="2" placeholder="es. RM">
            </div>

            <div class="col-12"><hr><h6 class="text-muted">Documento</h6></div>

            <div class="col-md-4">
                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                <select name="guests[{{ $index }}][tipo_documento]" class="form-select" required>
                    <option value="">Seleziona...</option>
                    <option value="carta_identita">Carta d'Identità</option>
                    <option value="passaporto">Passaporto</option>
                    <option value="patente">Patente</option>
                    <option value="altro">Altro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Numero <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][numero_documento]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Rilasciato da <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][rilasciato_da]" class="form-control" placeholder="es. COMUNE DI ROMA" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Data Rilascio</label>
                <input type="date" name="guests[{{ $index }}][data_rilascio]" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Data Scadenza</label>
                <input type="date" name="guests[{{ $index }}][data_scadenza]" class="form-control">
            </div>
        </div>
    </div>
</div>
