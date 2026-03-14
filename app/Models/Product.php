<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasSlug, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'short_description', 'description',
        'base_price', 'sale_price', 'cost_price', 'sku', 'stock_quantity',
        'manages_stock', 'is_featured', 'is_active', 'is_variable', 'weight',
        'meta_title', 'meta_description', 'sort_order',
    ];

    protected $casts = [
        'base_price'     => 'decimal:2',
        'sale_price'     => 'decimal:2',
        'cost_price'     => 'decimal:2',
        'is_featured'    => 'boolean',
        'is_active'      => 'boolean',
        'is_variable'    => 'boolean',
        'manages_stock'  => 'boolean',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('name')->saveSlugsTo('slug');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true);
    }

    public function allVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->sale_price ?? $this->base_price;
    }

    public function getIsOnSaleAttribute(): bool
    {
        return !is_null($this->sale_price) && $this->sale_price < $this->base_price;
    }

    public function getPrimaryImageAttribute(): ?ProductImage
    {
        return $this->images->firstWhere('is_primary', true) ?? $this->images->first();
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        return $this->primaryImage?->image_url ?? "https://picsum.photos/seed/{$this->slug}/600/600";
    }

    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews->avg('rating') ?? 0, 1);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity <= 0) return 'out_of_stock';
        if ($this->stock_quantity <= 5) return 'low_stock';
        return 'in_stock';
    }

    public function getDiscountPercentAttribute(): int
    {
        if (!$this->is_on_sale) return 0;
        return (int) round((($this->base_price - $this->sale_price) / $this->base_price) * 100);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    public function scopeForCategory($query, string $slug)
    {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }
}
