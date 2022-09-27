<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'railway_id',
        'organization_id',
        'name'
    ];
  
    public function cadries()
    {
        return $this->hasMany(Cadry::class);
    }

    public function railways()
    {
        return $this->belongsTo(Railway::class);
    }
    public function organizations()
    {
        return $this->belongsTo(Organization::class);
    }
    public function departmentcadry()
    {
        return $this->hasMany(DepartmentCadry::class);
    }

    public function departmentstaff()
    {
        return $this->hasMany(DepartmentStaff::class);
    }
    
}
