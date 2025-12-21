<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'discount_id',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items in the cart.
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get the discount applied to the cart.
     */
    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    /**
     * Recalculate and update the total price.
     */
    public function recalculateTotal(): void
    {
        $total = 0;
        foreach ($this->items as $item) {
            // Use discounted price if product has an active campaign
            $productPrice = $item->product->discounted_price ?? $item->product->product_price;
            $itemTotal = $productPrice * $item->product_number;

            // Add option prices
            foreach ($item->options as $option) {
                $itemTotal += $option->productOption->option_price * $item->product_number;
            }

            $total += $itemTotal;
        }

        $this->update(['total_price' => $total]);
    }

    /**
     * Get item count in cart.
     */
    public function getItemCountAttribute(): int
    {
        return $this->items->sum('product_number');
    }
}
