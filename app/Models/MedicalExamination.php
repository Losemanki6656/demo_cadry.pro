<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalExamination extends Model
{
    use HasFactory;

    protected $dates = ['date1','date2'];

    
    protected $fillable = [
        'cadry_id',
        'date1',
        'date2',
        'result',
    ];

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }
}
