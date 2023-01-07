<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;


    public function technicals()
    {
        return $this->belongsToMany(Technical::class, 'position_technicals');
    }

    public function specialties()
    {
        return $this->hasMany(Specialty::class);
    }
}
