<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abroad extends Model
{
    use HasFactory;

    public function abroads()
    {
        return $this->hasMany(AbroadStudy::class,'type_abroad');
    }
}
