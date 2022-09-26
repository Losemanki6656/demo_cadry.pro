<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use DB;

class DepartmentStaff extends Model
{
    use HasFactory;

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
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

    public function scopeFilter()
    {
        $cadryGroupByQuery = DepartmentCadry::query()
        ->when(request('railway_id'), function ($query, $railway_id) {
            return $query->where('railway_id', $railway_id);     
        })->when(request('org_id'), function ($query, $org_id) {
            return $query->where('organization_id', $org_id);     
        })->when(request('dep_id'), function ($query, $dep_id) {
            return $query->where('department_id', $dep_id);     
        })->select([
                    'department_staff_id',
                    DB::raw('sum(stavka) as summ_stavka')
                ])->where('status', false)
                ->groupBy('department_staff_id');

        return self::query()
            ->when(request('railway_id'), function ($query, $railway_id) {
                return $query->where('railway_id', $railway_id);     
            })->when(request('org_id'), function ($query, $org_id) {
                return $query->where('organization_id', $org_id);     
            })->when(request('dep_id'), function ($query, $dep_id) {
                return $query->where('department_id', $dep_id);     
            })->select([
                'department_staff.*',
                'summ_stavka'
            ])
            ->leftjoinSub($cadryGroupByQuery, 't1', function ($join) {
                $join->on('t1.department_staff_id', '=', 'department_staff.id');
            });
    }
    
    public function scopeApiFilter()
    {
        $cadryGroupByQuery = DepartmentCadry::query()
        ->when(request('railway_id'), function ($query, $railway_id) {
            return $query->where('railway_id', $railway_id);     
        })->when(request('organization_id'), function ($query, $organization_id) {
            return $query->where('organization_id', $organization_id);     
        })->when(request('department_id'), function ($query, $department_id) {
            return $query->where('id', $department_id);     
        })->select([
                    'department_staff_id',
                    DB::raw('sum(stavka) as summ_stavka')
                ])->where('status_decret',false)
                ->groupBy('department_staff_id');

        return self::query()
            ->when(request('railway_id'), function ($query, $railway_id) {
                return $query->where('railway_id', $railway_id);     
            })->when(request('organization_id'), function ($query, $organization_id) {
                return $query->where('organization_id', $organization_id);     
            })->when(request('department_id'), function ($query, $department_id) {
                return $query->where('id', $department_id);     
            })->select([
                'department_staff.*',
                'summ_stavka'
            ])
            ->leftjoinSub($cadryGroupByQuery, 't1', function ($join) {
                $join->on('t1.department_staff_id', '=', 'department_staff.id');
            });
    }
    public function scopeCadryFilter()
    {
        $cadryGroupByQuery = DepartmentCadry::where('organization_id', auth()->user()->userorganization->organization_id)
            ->select([
                    'department_staff_id',
                    DB::raw('sum(stavka) as summ_stavka')
                ])->where('status', false)
                ->groupBy('department_staff_id');

        return self::where('organization_id', auth()->user()->userorganization->organization_id)
        ->select([
                'department_staff.*',
                'summ_stavka'
            ])
            ->leftjoinSub($cadryGroupByQuery, 't1', function ($join) {
                $join->on('t1.department_staff_id', '=', 'department_staff.id');
            });
    }
}
