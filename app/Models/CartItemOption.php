<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItemOption extends Model
{
    protected $fillable = [
        'item_id',
        'option_id',
    ];

    /**
     * Get the cart item that owns the option.
     */
    public function cartItem(): BelongsTo
    {
        return $this->belongsTo(CartItem::class, 'item_id');
    }

    /**
     * Get the product option.
     */
    public function productOption(): BelongsTo
    {
        return $this->belongsTo(ProductOption::class, 'option_id');
    }
}
