<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductVariant extends Model
{
    protected $fillable = ['product_id', 'sku', 'price_modifier', 'stock_quantity', 'is_active'];

    protected $casts = [
        'price_modifier'  => 'decimal:2',
        'is_active'       => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variantAttributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'product_variant_attributes')
                    ->with('attributeType');
    }

    public function getEffectivePriceAttribute(): float
    {
        return (float) $this->product->base_price + (float) $this->price_modifier;
    }

    public function getLabelAttribute(): string
    {
        return $this->variantAttributes->map(fn($a) => $a->value)->join(' / ');
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) return 'out_of_stock';
        if ($this->stock_quantity <= 5) return 'low_stock';
        return 'in_stock';
    }
}
