<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlloggiatiwebLog extends Model
{
    protected $table = 'alloggiatiweb_logs';

    protected $fillable = [
        'booking_id',
        'sent_at',
        'status',
        'http_status_code',
        'request_payload',
        'response_payload',
        'error_message',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }
}
