<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'discount_code',
        'discount_percent',
        'discount_amount',
        'min_order',
        'status',
        'expires_at',
    ];

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'min_order' => 'decimal:2',
        'status' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active and valid discounts.
     */
    public function scopeValid($query)
    {
        return $query->where('status', true)
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    /**
     * Check if discount is valid.
     */
    public function isValid(): bool
    {
        if (!$this->status) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount for a given amount.
     */
    public function calculateDiscount(float $amount): float
    {
        if ($amount < $this->min_order) {
            return 0;
        }

        if ($this->discount_percent > 0) {
            return $amount * ($this->discount_percent / 100);
        }

        return min($this->discount_amount, $amount);
    }
}
