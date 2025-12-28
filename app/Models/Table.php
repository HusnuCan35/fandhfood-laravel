<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'qr_code_path', 'status'];

    public function calls()
    {
        return $this->hasMany(TableCall::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
