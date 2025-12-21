<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'comment_text',
        'rating',
        'helpful',
        'not_helpful',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get the user that owns the comment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the comment.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Increment helpful count.
     */
    public function incrementHelpful(): void
    {
        $this->increment('helpful');
    }

    /**
     * Increment not helpful count.
     */
    public function incrementNotHelpful(): void
    {
        $this->increment('not_helpful');
    }

    /**
     * Scope a query to only include active comments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
