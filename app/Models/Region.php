<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function cadries()
    {
        return $this->hasMany(Cadry::class,'address_region_id')->where(['status' => true]);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
