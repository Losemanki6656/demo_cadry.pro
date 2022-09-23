<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Railway extends Model
{
    use HasFactory;

    public function cadries()
    {
        return $this->hasMany(Cadry::class)->where(['status' => true]);
    }
}
