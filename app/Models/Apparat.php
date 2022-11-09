<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apparat extends Model
{
    use HasFactory;

    public function directions()
    {
        return $this->hasMany(TrainingDirection::class);
    }
}
