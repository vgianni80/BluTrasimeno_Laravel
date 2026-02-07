<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyncLog extends Model
{
    protected $fillable = [
        'ical_source_id',
        'synced_at',
        'status',
        'message',
        'bookings_found',
        'bookings_created',
        'bookings_updated',
    ];

    protected $casts = [
        'synced_at' => 'datetime',
    ];

    public function icalSource(): BelongsTo
    {
        return $this->belongsTo(IcalSource::class, 'ical_source_id');
    }
}
