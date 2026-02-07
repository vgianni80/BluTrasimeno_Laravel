<x-app-layout>
    <h4 class="mb-4">Impostazioni</h4>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-6">
                <!-- Struttura -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-house me-2"></i>Dati Struttura</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Nome Struttura</label>
                            <input type="text" name="property_name" class="form-control" 
                                   value="{{ $settings['property_name'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Indirizzo</label>
                            <input type="text" name="property_address" class="form-control" 
                                   value="{{ $settings['property_address'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefono</label>
                            <input type="tel" name="property_phone" class="form-control" 
                                   value="{{ $settings['property_phone'] ?? '' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Istruzioni Check-in</label>
                            <textarea name="checkin_instructions" class="form-control" rows="3">{{ $settings['checkin_instructions'] ?? '' }}</textarea>
                            <small class="text-muted">Incluse nell'email agli ospiti</small>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-envelope me-2"></i>Email</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Email Admin (per notifiche)</label>
                            <input type="email" name="admin_email" class="form-control" 
                                   value="{{ $settings['admin_email'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nome Mittente</label>
                            <input type="text" name="email_from_name" class="form-control" 
                                   value="{{ $settings['email_from_name'] ?? '' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Email Mittente</label>
                            <input type="email" name="email_from_address" class="form-control" 
                                   value="{{ $settings['email_from_address'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <!-- AlloggiatiWeb -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-shield-check me-2"></i>AlloggiatiWeb</div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <small>Configura le credenziali per l'invio automatico alla Polizia di Stato.</small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="alloggiatiweb_enabled" class="form-check-input" id="awEnabled" value="1"
                                       {{ ($settings['alloggiatiweb_enabled'] ?? false) ? 'checked' : '' }}>
                                <label class="form-check-label" for="awEnabled"><strong>Abilita Invio Automatico</strong></label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL WSDL</label>
                            <input type="url" name="alloggiatiweb_wsdl_url" class="form-control" 
                                   value="{{ $settings['alloggiatiweb_wsdl_url'] ?? 'https://alloggiatiweb.poliziadistato.it/service/service.asmx?wsdl' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="alloggiatiweb_username" class="form-control" 
                                   value="{{ $settings['alloggiatiweb_username'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="alloggiatiweb_password" class="form-control" 
                                   value="{{ $settings['alloggiatiweb_password'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chiave WS</label>
                            <input type="text" name="alloggiatiweb_ws_key" class="form-control" 
                                   value="{{ $settings['alloggiatiweb_ws_key'] ?? '' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Codice Struttura</label>
                            <input type="text" name="alloggiatiweb_property_id" class="form-control" 
                                   value="{{ $settings['alloggiatiweb_property_id'] ?? '' }}">
                        </div>
                    </div>
                </div>

                <!-- Generale -->
                <div class="card mb-4">
                    <div class="card-header"><i class="bi bi-gear me-2"></i>Generale</div>
                    <div class="card-body">
                        {{-- <div class="mb-3">
                            <label class="form-label">Scadenza Link Check-in (giorni)</label>
                            <input type="number" name="checkin_link_expiry_days" class="form-control" 
                                   value="{{ $settings['checkin_link_expiry_days'] ?? 30 }}" min="1" max="365">
                        </div> --}}
                        <div class="mb-0">
                            <label class="form-label">Orario Invio AlloggiatiWeb</label>
                            <input type="time" name="send_time" class="form-control" 
                                   value="{{ $settings['send_time'] ?? '06:00' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg">
            <i class="bi bi-check-lg me-2"></i>Salva Impostazioni
        </button>
    </form>
</x-app-layout>
