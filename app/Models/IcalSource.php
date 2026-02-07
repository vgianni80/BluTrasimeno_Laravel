<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IcalSource extends Model
{
    use HasFactory;

    protected $table = 'ical_sources';

    protected $fillable = [
        'name',
        'url',
        'polling_frequency_minutes',
        'last_synced_at',
        'is_active',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'ical_source_id');
    }

    public function syncLogs(): HasMany
    {
        return $this->hasMany(SyncLog::class, 'ical_source_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function shouldSync(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if (!$this->last_synced_at) {
            return true;
        }

        return $this->last_synced_at->diffInMinutes(now()) >= $this->polling_frequency_minutes;
    }

    public function markAsSynced(): void
    {
        $this->update(['last_synced_at' => now()]);
    }
}
