<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'user_id',
        'order_total',
        'discount_details',
        'order_status',
        'payment_status',
        'payment_method',
        'address',
        'phone',
        'note',
        'leave_at_door',
        'no_bell',
        'eco_friendly',
        'courier_note',
        'delivery_time_type',
        'delivery_date',
        'delivery_hour',
    ];

    /**
     * Get the table associated with the order.
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class);
    }

    protected $casts = [
        'order_total' => 'decimal:2',
        'discount_details' => 'array',
        'leave_at_door' => 'boolean',
        'no_bell' => 'boolean',
        'eco_friendly' => 'boolean',
        'delivery_date' => 'date',
    ];

    /**
     * Get payment method label.
     */
    public function getPaymentMethodLabel(): string
    {
        return match ($this->payment_method) {
            'cash' => 'Nakit',
            'card_at_door' => 'Kapıda Kartla Ödeme',
            'meal_card' => 'Kapıda Yemek Kartı',
            default => 'Nakit',
        };
    }

    /**
     * Get payment method icon.
     */
    public function getPaymentMethodIcon(): string
    {
        return match ($this->payment_method) {
            'cash' => 'la-money-bill-wave',
            'card_at_door' => 'la-credit-card',
            'meal_card' => 'la-utensils',
            default => 'la-money-bill-wave',
        };
    }

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Check if order is pending.
     */
    public function isPending(): bool
    {
        return $this->order_status === 'pending';
    }

    /**
     * Check if order is completed.
     */
    public function isCompleted(): bool
    {
        return $this->order_status === 'completed';
    }
}
