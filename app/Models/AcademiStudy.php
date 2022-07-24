<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademiStudy extends Model
{
    use HasFactory;

    public function academicname()
    {
        return $this->belongsTo(AcademicName::class,'institute');
    }
}
