<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentCadry extends Model
{
    use HasFactory;

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    public function depstaff()
    {
        return $this->belongsTo(DepartmentStaff::class,'department_staff_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
