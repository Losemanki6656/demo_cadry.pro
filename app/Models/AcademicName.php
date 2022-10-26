<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicName extends Model
{
    use HasFactory;

    public function academics()
    {
        return $this->hasMany(AcademiStudy::class,'institute');
    }
}
