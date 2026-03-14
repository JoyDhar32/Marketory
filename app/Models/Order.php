<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status',
        'billing_name', 'billing_email', 'billing_phone', 'billing_address',
        'billing_city', 'billing_state', 'billing_zip', 'billing_country',
        'shipping_name', 'shipping_address', 'shipping_city', 'shipping_state',
        'shipping_zip', 'shipping_country',
        'subtotal', 'discount_amount', 'shipping_amount', 'tax_amount', 'total',
        'coupon_code', 'payment_method', 'payment_status', 'payment_reference', 'stripe_payment_intent_id',
        'customer_notes', 'admin_notes', 'shipped_at', 'delivered_at',
    ];

    protected $casts = [
        'subtotal'        => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'total'           => 'decimal:2',
        'shipped_at'      => 'datetime',
        'delivered_at'    => 'datetime',
    ];

    public const STATUSES = ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded'];
    public const PAYMENT_STATUSES = ['pending', 'paid', 'failed', 'refunded'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending'    => 'warning',
            'confirmed'  => 'info',
            'processing' => 'primary',
            'shipped'    => 'secondary',
            'delivered'  => 'success',
            'cancelled'  => 'danger',
            'refunded'   => 'dark',
            default      => 'secondary',
        };
    }

    public static function generateOrderNumber(): string
    {
        $count = static::whereDate('created_at', today())->count();
        return 'MKT-' . now()->format('Ymd') . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }
}
