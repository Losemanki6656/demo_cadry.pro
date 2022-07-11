<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadry_id',
        'sort',
        'date1',
        'date2',
        'institut',
        'speciality'
    ];
  
}
