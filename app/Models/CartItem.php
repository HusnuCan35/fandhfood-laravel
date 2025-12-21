<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_number',
        'product_note',
    ];

    /**
     * Get the cart that owns the item.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product for the cart item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the selected options for the cart item.
     */
    public function options(): HasMany
    {
        return $this->hasMany(CartItemOption::class, 'item_id');
    }

    /**
     * Get the total price for this item including options.
     */
    public function getTotalPriceAttribute(): float
    {
        $basePrice = $this->product->product_price * $this->product_number;

        $optionsPrice = $this->options->sum(function ($option) {
            return $option->productOption->option_price * $this->product_number;
        });

        return $basePrice + $optionsPrice;
    }
}
