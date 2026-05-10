<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'discount',
        'image',
        'category_id',
        'is_featured',
        'featured_order',
        'featured_image',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
        'price'          => 'float',
        'discount'       => 'float',
        'featured_order' => 'integer',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    
    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true)
                     ->orderBy('featured_order')
                     ->orderBy('created_at', 'desc');
    }


    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->where('category_id', $categoryId);
    }


    public function scopeDiscounted(Builder $query): Builder
    {
        return $query->where('discount', '>', 0);
    }

    public function getDiscountedPriceAttribute(): float
    {
        if ($this->discount > 0) {
            return round($this->price - ($this->price * $this->discount / 100), 2);
        }
        return $this->price;
    }


    public function getFeaturedImageUrlAttribute(): string
    {
        return asset('storage/' . ($this->featured_image ?? $this->image));
    }


    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image);
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->discount > 0;
    }
}
