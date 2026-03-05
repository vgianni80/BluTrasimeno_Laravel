<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_name',
        'guest_surname',
        'guest_email',
        'guest_phone',
        'check_in',
        'check_out',
        'guests',
        'notes',
        'total',
        'price_breakdown',
        'status', // pending, confirmed, rejected, cancelled
        'admin_notes',
        'booking_id', // Se convertito in booking reale
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'total' => 'decimal:2',
        'price_breakdown' => 'array',
    ];

    // Relazioni
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getNightsAttribute(): int
    {
        return $this->check_in->diffInDays($this->check_out);
    }

    public function getFullGuestNameAttribute(): string
    {
        return trim("{$this->guest_name} {$this->guest_surname}");
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'In attesa',
            'confirmed' => 'Confermata',
            'rejected' => 'Rifiutata',
            'cancelled' => 'Cancellata',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    // Metodi
    public function confirm(): void
    {
        $this->update(['status' => 'confirmed']);
    }

    public function reject(?string $reason = null): void
    {
        $this->update([
            'status' => 'rejected',
            'admin_notes' => $reason,
        ]);
    }
}
