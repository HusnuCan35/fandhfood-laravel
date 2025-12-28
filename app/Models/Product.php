<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_image',
        'category_id',
        'stock',
        'product_point',
        'status',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'product_point' => 'decimal:1',
        'status' => 'boolean',
    ];

    /**
     * Get the category that owns the product.
     */
    public function allergens()
    {
        return $this->belongsToMany(Allergen::class, 'product_allergen');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the option settings for the product.
     */
    public function optionSettings(): HasMany
    {
        return $this->hasMany(ProductOptionSetting::class);
    }

    /**
     * Get the comments for the product.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the cart items for the product.
     */
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope a query to only include in-stock products.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Get active campaign for this product.
     */
    public function getActiveCampaign(): ?Campaign
    {
        $now = now();

        return Campaign::where('status', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now)
            ->get()
            ->first(function ($campaign) {
                return $campaign->includesProduct($this->id, $this->category_id);
            });
    }

    /**
     * Get discounted price if campaign is active.
     */
    public function getDiscountedPriceAttribute(): ?float
    {
        $campaign = $this->getActiveCampaign();

        if (!$campaign) {
            return null;
        }

        $discount = $this->product_price * ($campaign->discount_percent / 100);
        return round($this->product_price - $discount, 2);
    }

    /**
     * Get campaign discount percentage.
     */
    public function getCampaignDiscountAttribute(): ?int
    {
        $campaign = $this->getActiveCampaign();
        return $campaign ? $campaign->discount_percent : null;
    }

    /**
     * Check if product has active campaign.
     */
    public function getHasCampaignAttribute(): bool
    {
        return $this->getActiveCampaign() !== null;
    }

    /**
     * Check if product has active campaign (method version).
     */
    public function hasActiveCampaign(): bool
    {
        return $this->getActiveCampaign() !== null;
    }

    /**
     * Get all active campaigns for this product.
     */
    public function getActiveCampaigns()
    {
        $now = now();

        return Campaign::where('status', true)
            ->where('starts_at', '<=', $now)
            ->where('ends_at', '>=', $now)
            ->get()
            ->filter(function ($campaign) {
                return $campaign->includesProduct($this->id, $this->category_id);
            });
    }

    /**
     * Get discounted price (method version, not attribute).
     */
    public function getDiscountedPrice(): float
    {
        $campaign = $this->getActiveCampaign();

        if (!$campaign) {
            return (float) $this->product_price;
        }

        $discount = $this->product_price * ($campaign->discount_percent / 100);
        return round($this->product_price - $discount, 2);
    }
}
