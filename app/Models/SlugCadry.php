<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlugCadry extends Model
{
    use HasFactory;

    public function railway()
    {
        return $this->belongsTo(Railway::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
