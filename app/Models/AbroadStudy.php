<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbroadStudy extends Model
{
    use HasFactory;

    public function typeabroad()
    {
        return $this->belongsTo(Abroad::class,'type_abroad');
    }
}
