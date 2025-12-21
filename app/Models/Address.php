<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'address_type',
        'full_address',
        'district',
        'city',
        'building_no',
        'floor',
        'apartment_no',
        'directions',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get address type label in Turkish.
     */
    public function getTypeLabel(): string
    {
        return match ($this->address_type) {
            'home' => 'Ev',
            'work' => 'İş',
            'other' => 'Diğer',
            default => 'Diğer',
        };
    }

    /**
     * Get address type icon.
     */
    public function getTypeIcon(): string
    {
        return match ($this->address_type) {
            'home' => 'la-home',
            'work' => 'la-building',
            'other' => 'la-map-marker',
            default => 'la-map-marker',
        };
    }

    /**
     * Get formatted address string.
     */
    public function getFormattedAddress(): string
    {
        $parts = [$this->full_address];

        if ($this->building_no) {
            $parts[] = "No: {$this->building_no}";
        }
        if ($this->floor) {
            $parts[] = "Kat: {$this->floor}";
        }
        if ($this->apartment_no) {
            $parts[] = "Daire: {$this->apartment_no}";
        }
        if ($this->district && $this->city) {
            $parts[] = "{$this->district}, {$this->city}";
        }

        return implode(', ', $parts);
    }
}
