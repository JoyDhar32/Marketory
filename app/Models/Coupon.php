<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'description', 'type', 'value',
        'minimum_order', 'maximum_uses', 'used_count',
        'is_active', 'expires_at',
    ];

    protected $casts = [
        'value'         => 'decimal:2',
        'minimum_order' => 'decimal:2',
        'is_active'     => 'boolean',
        'expires_at'    => 'datetime',
    ];

    public function getIsValidAttribute(): bool
    {
        if (!$this->is_active) return false;
        if ($this->expires_at && $this->expires_at->isPast()) return false;
        if ($this->maximum_uses && $this->used_count >= $this->maximum_uses) return false;
        return true;
    }

    public function calculateDiscount(float $subtotal): float
    {
        if ($this->type === 'percentage') {
            return round($subtotal * ($this->value / 100), 2);
        }
        return min((float) $this->value, $subtotal);
    }
}
