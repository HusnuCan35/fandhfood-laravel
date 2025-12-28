<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    protected $fillable = ['name', 'icon', 'status'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_allergen');
    }
}
