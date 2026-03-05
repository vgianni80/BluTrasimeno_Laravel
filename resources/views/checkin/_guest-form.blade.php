<div class="guest-card">
    <div class="guest-card-header">
        <h5>
            <i class="bi bi-person me-2"></i>Ospite {{ (int)$index + 1 }}
            @if($isFirst)
                <span class="badge ms-2">Capogruppo</span>
            @endif
        </h5>
        @if(!$isFirst)
            <button type="button" class="btn-remove" onclick="removeGuest(this)">
                <i class="bi bi-trash"></i> Rimuovi
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
                <label class="form-label">Data di Nascita <span class="text-danger">*</span></label>
                <input type="date" name="guests[{{ $index }}][data_nascita]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Cittadinanza <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][cittadinanza]" class="form-control" value="ITALIA" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Stato di Nascita <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][stato_nascita]" class="form-control" value="ITALIA" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Comune di Nascita <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][comune_nascita]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Provincia (sigla)</label>
                <input type="text" name="guests[{{ $index }}][provincia_nascita]" class="form-control" maxlength="2" placeholder="es. PG">
            </div>

            <div class="col-12">
                <h6 class="section-title"><i class="bi bi-credit-card me-2"></i>Documento di Identità</h6>
            </div>

            <div class="col-md-4">
                <label class="form-label">Tipo Documento <span class="text-danger">*</span></label>
                <select name="guests[{{ $index }}][tipo_documento]" class="form-select" required>
                    <option value="">Seleziona...</option>
                    <option value="carta_identita">Carta d'Identità</option>
                    <option value="passaporto">Passaporto</option>
                    <option value="patente">Patente di Guida</option>
                    <option value="altro">Altro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Numero Documento <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][numero_documento]" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Rilasciato da <span class="text-danger">*</span></label>
                <input type="text" name="guests[{{ $index }}][rilasciato_da]" class="form-control" placeholder="es. Comune di Perugia" required>
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
