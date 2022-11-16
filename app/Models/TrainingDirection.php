<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingDirection extends Model
{
    use HasFactory;

    public function apparat()
    {
        return $this->belongsTo(Apparat::class);
    }
}
