<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technical extends Model
{
    use HasFactory;

    public function positions()
    {
        return $this->belongsToMany(Position::class, 'position_technicals');
    }
}
