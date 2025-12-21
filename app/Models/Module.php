<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'module_name',
        'module_status',
    ];

    protected $casts = [
        'module_status' => 'boolean',
    ];

    /**
     * Check if a module is enabled.
     */
    public static function isEnabled(string $moduleName): bool
    {
        $module = static::where('module_name', $moduleName)->first();
        return $module ? $module->module_status : false;
    }

    /**
     * Get all enabled modules as array.
     */
    public static function getEnabledModules(): array
    {
        return static::where('module_status', true)
            ->pluck('module_name')
            ->toArray();
    }
}
