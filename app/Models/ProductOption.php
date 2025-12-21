<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductOption extends Model
{
    protected $fillable = [
        'setting_id',
        'option_name',
        'option_price',
    ];

    protected $casts = [
        'option_price' => 'decimal:2',
    ];

    /**
     * Get the setting that owns the option.
     */
    public function setting(): BelongsTo
    {
        return $this->belongsTo(ProductOptionSetting::class, 'setting_id');
    }
}
