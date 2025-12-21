<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Campaign extends Model
{
    protected $fillable = [
        'name',
        'description',
        'discount_percent',
        'product_ids',
        'category_ids',
        'starts_at',
        'ends_at',
        'is_flash',
        'status',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'category_ids' => 'array',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_flash' => 'boolean',
        'status' => 'boolean',
    ];

    /**
     * Check if campaign is currently active.
     */
    public function isActive(): bool
    {
        if (!$this->status) {
            return false;
        }

        $now = now();
        return $now->between($this->starts_at, $this->ends_at);
    }

    /**
     * Check if product is included in campaign.
     */
    public function includesProduct(int $productId, ?int $categoryId = null): bool
    {
        // Check specific products
        if ($this->product_ids && in_array($productId, $this->product_ids)) {
            return true;
        }

        // Check categories
        if ($this->category_ids && $categoryId && in_array($categoryId, $this->category_ids)) {
            return true;
        }

        // If no specific products or categories, applies to all
        if (empty($this->product_ids) && empty($this->category_ids)) {
            return true;
        }

        return false;
    }

    /**
     * Scope for active campaigns.
     */
    public function scopeActive($query)
    {
        $now = now();
        return $query->where('status', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now);
    }

    /**
     * Scope for flash sales.
     */
    public function scopeFlash($query)
    {
        return $query->where('is_flash', true);
    }
}
