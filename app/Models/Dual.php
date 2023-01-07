<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dual extends Model
{
    use HasFactory;

    public function profession()
    {
        return $this->belongsTo(Position::class,'position_id');
    }

    public function technical()
    {
        return $this->belongsTo(Technical::class);
    }

    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }
}
