<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationCadry extends Model
{
    use HasFactory;
    
    protected $dates = ['date1'];

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }
}
