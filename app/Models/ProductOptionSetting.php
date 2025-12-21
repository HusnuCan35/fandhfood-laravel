<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductOptionSetting extends Model
{
    protected $table = 'product_options_settings';

    protected $fillable = [
        'product_id',
        'options_name',
        'options_title',
        'options_type',
    ];

    /**
     * Get the product that owns the option setting.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the options for the setting.
     */
    public function options(): HasMany
    {
        return $this->hasMany(ProductOption::class, 'setting_id');
    }

    /**
     * Check if this is a radio button type.
     */
    public function isRadio(): bool
    {
        return $this->options_type === 1;
    }

    /**
     * Check if this is a checkbox type.
     */
    public function isCheckbox(): bool
    {
        return $this->options_type === 0;
    }
}
