<x-app-layout>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">{{ isset($booking) ? 'Modifica Prenotazione' : 'Nuova Prenotazione' }}</h4>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Indietro
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ isset($booking) ? route('admin.bookings.update', $booking) : route('admin.bookings.store') }}">
                @csrf
                @if(isset($booking))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Check-in <span class="text-danger">*</span></label>
                        <input type="date" name="check_in" class="form-control @error('check_in') is-invalid @enderror" 
                               value="{{ old('check_in', isset($booking) ? $booking->check_in->format('Y-m-d') : '') }}" required>
                        @error('check_in')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Check-out <span class="text-danger">*</span></label>
                        <input type="date" name="check_out" class="form-control @error('check_out') is-invalid @enderror" 
                               value="{{ old('check_out', isset($booking) ? $booking->check_out->format('Y-m-d') : '') }}" required>
                        @error('check_out')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Nome <span class="text-danger">*</span></label>
                        <input type="text" name="guest_name" class="form-control @error('guest_name') is-invalid @enderror" 
                               value="{{ old('guest_name', $booking->guest_name ?? '') }}" required>
                        @error('guest_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Cognome <span class="text-danger">*</span></label>
                        <input type="text" name="guest_surname" class="form-control @error('guest_surname') is-invalid @enderror" 
                               value="{{ old('guest_surname', $booking->guest_surname ?? '') }}" required>
                        @error('guest_surname')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Numero Ospiti <span class="text-danger">*</span></label>
                        <input type="number" name="number_of_guests" class="form-control @error('number_of_guests') is-invalid @enderror" 
                               value="{{ old('number_of_guests', $booking->number_of_guests ?? 1) }}" min="1" required>
                        @error('number_of_guests')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="guest_email" class="form-control @error('guest_email') is-invalid @enderror" 
                               value="{{ old('guest_email', $booking->guest_email ?? '') }}" required>
                        @error('guest_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telefono</label>
                        <input type="tel" name="guest_phone" class="form-control @error('guest_phone') is-invalid @enderror" 
                               value="{{ old('guest_phone', $booking->guest_phone ?? '') }}">
                        @error('guest_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Note</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes', $booking->notes ?? '') }}</textarea>
                </div>

                @if(isset($booking) && $booking->ical_raw_data)
                    <div class="alert alert-info">
                        <strong>Dati iCal originali:</strong><br>
                        <small>{{ $booking->ical_raw_data['summary'] ?? '' }}</small>
                    </div>
                @endif

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">Annulla</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-2"></i>{{ isset($booking) ? 'Salva' : 'Crea' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
