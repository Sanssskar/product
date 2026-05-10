<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = [
        'title',
        'slug',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }


    public function featuredProducts(): HasMany
    {
        return $this->hasMany(Product::class)
                    ->where('is_featured', true)
                    ->orderBy('featured_order');
    }




    public function scopeWithProducts(Builder $query): Builder
    {
        return $query->has('products')->with('products');
    }


    public function scopeWithFeaturedProducts(Builder $query): Builder
    {
        return $query->has('featuredProducts')->with('featuredProducts');
    }



    public function getHasProductsAttribute(): bool
    {
        return $this->products()->exists();
    }
}
