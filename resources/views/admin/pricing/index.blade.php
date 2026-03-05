<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Gestione Tariffe</h2>
            <p class="text-muted mb-0">Configura i prezzi per notte e gli sconti per durata soggiorno</p>
        </div>
        <a href="{{ route('admin.pricing.rules.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Nuova Regola
        </a>
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

    <div class="row">
        <!-- Regole Tariffarie -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-currency-euro me-2"></i>Regole Tariffarie
                </div>
                <div class="card-body p-0">
                    @if($rules->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Prezzo/Notte</th>
                                        <th>Periodo</th>
                                        <th>Priorità</th>
                                        <th>Stato</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rules as $rule)
                                        <tr>
                                            <td>
                                                <strong>{{ $rule->name }}</strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $rule->type_color }}">
                                                    {{ $rule->type_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <strong class="text-success">€ {{ number_format($rule->price_per_night, 2, ',', '.') }}</strong>
                                            </td>
                                            <td>
                                                @if($rule->start_date && $rule->end_date)
                                                    {{ $rule->start_date->format('d/m/Y') }} - {{ $rule->end_date->format('d/m/Y') }}
                                                @elseif($rule->days_of_week)
                                                    @php
                                                        $days = ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'];
                                                        $selectedDays = array_map(fn($d) => $days[$d], $rule->days_of_week);
                                                    @endphp
                                                    {{ implode(', ', $selectedDays) }}
                                                @else
                                                    <span class="text-muted">Sempre</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $rule->priority }}</span>
                                            </td>
                                            <td>
                                                @if($rule->is_active)
                                                    <span class="badge bg-success">Attiva</span>
                                                @else
                                                    <span class="badge bg-secondary">Disattiva</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.pricing.rules.edit', $rule) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.pricing.rules.destroy', $rule) }}" method="POST" class="d-inline" 
                                                      onsubmit="return confirm('Eliminare questa regola?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-currency-euro display-4 text-muted"></i>
                            <p class="text-muted mt-3">Nessuna regola tariffaria configurata</p>
                            <a href="{{ route('admin.pricing.rules.create') }}" class="btn btn-primary">
                                Crea la prima regola
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                <strong>Come funzionano le priorità:</strong> La regola con priorità più alta viene applicata per prima. 
                Ad esempio, una regola "Alta Stagione" (priorità 50) prevale sulla regola "Base" (priorità 0).
            </div>
        </div>

        <!-- Sconti per durata -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-percent me-2"></i>Sconti per Durata
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pricing.discounts.store') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <input type="text" name="name" class="form-control form-control-sm" placeholder="Nome (es. Sconto settimanale)" required>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">≥</span>
                                    <input type="number" name="min_nights" class="form-control" placeholder="Notti" min="2" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group input-group-sm">
                                    <input type="number" name="discount_percent" class="form-control" placeholder="%" min="1" max="100" step="0.5" required>
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-plus-lg me-1"></i>Aggiungi Sconto
                        </button>
                    </form>

                    @if($discounts->count() > 0)
                        <ul class="list-group">
                            @foreach($discounts as $discount)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $discount->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            ≥ {{ $discount->min_nights }} notti → 
                                            <span class="text-success">-{{ $discount->discount_percent }}%</span>
                                        </small>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <form action="{{ route('admin.pricing.discounts.toggle', $discount) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-{{ $discount->is_active ? 'success' : 'secondary' }}" title="{{ $discount->is_active ? 'Disattiva' : 'Attiva' }}">
                                                <i class="bi bi-{{ $discount->is_active ? 'check-circle' : 'circle' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.pricing.discounts.destroy', $discount) }}" method="POST" 
                                              onsubmit="return confirm('Eliminare questo sconto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted text-center mb-0">
                            <small>Nessuno sconto configurato</small>
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
