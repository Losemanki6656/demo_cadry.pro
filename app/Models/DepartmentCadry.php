<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Venturecraft\Revisionable\RevisionableTrait;

class DepartmentCadry extends Model
{
    use HasFactory,RevisionableTrait;

    protected $dates = ['work_date2','staff_date'];

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

    public function work_status()
    {
        return $this->belongsTo(WorkStatus::class);
    }
}
