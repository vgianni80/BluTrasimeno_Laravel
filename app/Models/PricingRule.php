<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PricingRule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type', // base, seasonal, weekend, special
        'price_per_night',
        'start_date',
        'end_date',
        'days_of_week', // JSON array: [0,1,2,3,4,5,6] (0=domenica)
        'priority',
        'is_active',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'days_of_week' => 'array',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeBase($query)
    {
        return $query->where('type', 'base');
    }

    public function scopeForDate($query, Carbon $date)
    {
        return $query->where(function ($q) use ($date) {
            // Nessun vincolo di data (es. prezzo base)
            $q->whereNull('start_date')
              ->whereNull('end_date');
        })->orWhere(function ($q) use ($date) {
            // Con vincolo di data
            $q->where('start_date', '<=', $date)
              ->where('end_date', '>=', $date);
        });
    }

    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'base' => 'Base',
            'seasonal' => 'Stagionale',
            'weekend' => 'Weekend',
            'special' => 'Speciale',
            default => $this->type,
        };
    }

    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'base' => 'secondary',
            'seasonal' => 'info',
            'weekend' => 'primary',
            'special' => 'warning',
            default => 'secondary',
        };
    }

    /**
     * Verifica se questa regola si applica a una data specifica
     */
    public function appliesTo(Carbon $date): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Verifica il range di date (se specificato)
        if ($this->start_date && $this->end_date) {
            if ($date->lt($this->start_date) || $date->gt($this->end_date)) {
                return false;
            }
        }

        // Verifica il giorno della settimana (se specificato)
        if ($this->days_of_week && count($this->days_of_week) > 0) {
            if (!in_array($date->dayOfWeek, $this->days_of_week)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Ottiene il prezzo per una data specifica considerando tutte le regole attive
     */
    public static function getPriceForDate(Carbon $date): float
    {
        $rules = static::active()
            ->orderBy('priority', 'desc')
            ->get();

        foreach ($rules as $rule) {
            if ($rule->appliesTo($date)) {
                return (float) $rule->price_per_night;
            }
        }

        // Prezzo di default se non ci sono regole
        return (float) Setting::get('default_price_per_night', 100);
    }

    /**
     * Calcola il totale per un periodo
     */
    public static function calculateTotal(Carbon $checkIn, Carbon $checkOut): array
    {
        $nights = $checkIn->diffInDays($checkOut);
        $subtotal = 0;
        $dailyPrices = [];

        $currentDate = $checkIn->copy();
        for ($i = 0; $i < $nights; $i++) {
            $price = static::getPriceForDate($currentDate);
            $dailyPrices[$currentDate->format('Y-m-d')] = $price;
            $subtotal += $price;
            $currentDate->addDay();
        }

        return [
            'nights' => $nights,
            'subtotal' => $subtotal,
            'daily_prices' => $dailyPrices,
            'average_per_night' => $nights > 0 ? $subtotal / $nights : 0,
        ];
    }
}
