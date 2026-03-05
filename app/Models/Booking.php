<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ical_source_id',
        'ical_uid',
        'booked_at',
        'holidu_booking_id',
        'holidu_channel',
        'check_in',
        'check_out',
        'number_of_guests',
        'paid_by_guest',
        'home_owner_payout',
        'channel_commission',
        'bookiply_commission',
        'bookiply_processing_markup',
        'cedolare_secca',
        'vat',
        'guest_name',
        'guest_surname',
        'guest_email',
        'guest_phone',
        'checkin_token',
        'checkin_completed_at',
        'checkin_link_expires_at',
        'status',
        'sent_to_alloggiatiweb_at',
        'send_attempts',
        'last_error',
        'notes',
        'ical_raw_data',
    ];

    protected $casts = [
        'booked_at' => 'datetime',
        'check_in' => 'date',
        'check_out' => 'date',
        'paid_by_guest' => 'decimal:2',
        'home_owner_payout' => 'decimal:2',
        'channel_commission' => 'decimal:2',
        'bookiply_commission' => 'decimal:2',
        'bookiply_processing_markup' => 'decimal:2',
        'cedolare_secca' => 'decimal:2',
        'vat' => 'decimal:2',
        'checkin_completed_at' => 'datetime',
        'checkin_link_expires_at' => 'datetime',
        'sent_to_alloggiatiweb_at' => 'datetime',
        'ical_raw_data' => 'array',
    ];

    // Relazioni
    public function icalSource(): BelongsTo
    {
        return $this->belongsTo(IcalSource::class, 'ical_source_id');
    }

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }

    public function alloggiatiwebLogs(): HasMany
    {
        return $this->hasMany(AlloggiatiwebLog::class);
    }

    // Scopes
    public function scopeIncomplete($query)
    {
        return $query->where('status', 'incomplete');
    }

    public function scopeComplete($query)
    {
        return $query->where('status', 'complete');
    }

    public function scopeCheckedIn($query)
    {
        return $query->where('status', 'checked_in');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('check_in', today());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('check_in', '>=', today())->orderBy('check_in');
    }

    public function scopeReadyForAlloggiatiweb($query)
    {
        return $query->where('status', 'checked_in')
                     ->whereDate('check_in', today())
                     ->whereNull('sent_to_alloggiatiweb_at');
    }

    // Helper methods
    public function generateCheckinToken(): string
    {
        $this->checkin_token = Str::random(64);
        $this->checkin_link_expires_at = now()->addDays(
            (int) Setting::get('checkin_link_expiry_days', 30)
        );
        $this->save();
        
        return $this->checkin_token;
    }

    public function getCheckinUrl(): string
    {
        return url("/checkin/{$this->checkin_token}");
    }

    public function isCheckinLinkValid(): bool
    {
        return $this->checkin_token && 
               $this->checkin_link_expires_at && 
               $this->checkin_link_expires_at->isFuture() &&
               !$this->checkin_completed_at;
    }

    public function markAsComplete(): void
    {
        $this->update(['status' => 'complete']);
    }

    public function markAsCheckedIn(): void
    {
        $this->update([
            'status' => 'checked_in',
            'checkin_completed_at' => now(),
        ]);
    }

    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_to_alloggiatiweb_at' => now(),
        ]);
    }

    public function markAsFailed(string $error): void
    {
        $this->update([
            'status' => 'failed',
            'last_error' => $error,
            'send_attempts' => $this->send_attempts + 1,
        ]);
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
}
