<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentStaff extends Model
{
    use HasFactory;

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function cadry()
    {
        return $this->hasMany(DepartmentCadry::class);
    }

    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }


}
