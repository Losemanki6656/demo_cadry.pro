<?php

namespace App\Models;
use Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'railway_id',
        'organization_id',
        'name',
        'category_id',
        'staff_count',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cadries()
    {
        return  $this->hasMany(Cadry::class);
    }

    public function departments()
    {
        return  $this->hasMany(DepartmentStaff::class);
    }

    public function scopeFilter()
    {
        return self::query()
        ->when(request('org_id'), function ($query, $org_id) {
            return $query->where('organization_id', $org_id);

        })->when(request('dep_id'), function ($query, $dep_id) {
            return $query->where('department_id', $dep_id);

        })->when(request('railway_id'), function ($query, $railway_id) {
            return $query->where('railway_id', $railway_id);
        })->with('cadries');
    }

    public function scopeOrgFilter()
    {
        return self::where('organization_id', UserOrganization::where('user_id',Auth::user()->id)->value('organization_id'))->with('cadries');
    }
}
