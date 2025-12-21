<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = [
        'branch_name',
        'branch_address',
        'branch_phone',
        'branch_lat',
        'branch_lng',
        'status',
    ];

    protected $casts = [
        'branch_lat' => 'decimal:8',
        'branch_lng' => 'decimal:8',
        'status' => 'boolean',
    ];

    /**
     * Scope a query to only include active branches.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
