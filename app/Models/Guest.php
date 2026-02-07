<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'nome',
        'cognome',
        'sesso',
        'data_nascita',
        'comune_nascita',
        'provincia_nascita',
        'stato_nascita',
        'cittadinanza',
        'tipo_documento',
        'numero_documento',
        'rilasciato_da',
        'data_rilascio',
        'data_scadenza',
        'is_capogruppo',
    ];

    protected $casts = [
        'data_nascita' => 'date',
        'data_rilascio' => 'date',
        'data_scadenza' => 'date',
        'is_capogruppo' => 'boolean',
    ];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function getNomeCompletoAttribute(): string
    {
        return "{$this->nome} {$this->cognome}";
    }

    public function getEtaAttribute(): int
    {
        return $this->data_nascita->age;
    }
}
