<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

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

    public function discounted_price()
    {
        if ($this->discount > 0) {
            return $this->price - ($this->price * $this->discount / 100);
        }

        return $this->price;
    }
}
