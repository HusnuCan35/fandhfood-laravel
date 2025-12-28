<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableCall extends Model
{
    protected $fillable = ['table_id', 'type', 'status'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
