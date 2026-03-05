<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LengthDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'min_nights',
        'discount_percent',
        'is_active',
    ];

    protected $casts = [
        'min_nights' => 'integer',
        'discount_percent' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Ottiene lo sconto applicabile per un numero di notti
     */
    public static function getDiscountForNights(int $nights): ?self
    {
        return static::active()
            ->where('min_nights', '<=', $nights)
            ->orderBy('min_nights', 'desc')
            ->first();
    }

    /**
     * Calcola lo sconto effettivo
     */
    public static function calculateDiscount(int $nights, float $subtotal): array
    {
        $discount = static::getDiscountForNights($nights);

        if (!$discount) {
            return [
                'discount' => null,
                'discount_percent' => 0,
                'discount_amount' => 0,
            ];
        }

        $discountAmount = $subtotal * ($discount->discount_percent / 100);

        return [
            'discount' => $discount,
            'discount_percent' => $discount->discount_percent,
            'discount_amount' => round($discountAmount, 2),
        ];
    }
}
