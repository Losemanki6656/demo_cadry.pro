<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    use HasFactory;

    protected $dates = ['date1','date2'];

    public function scopeFilter()
    {
        return self::query()
            ->where('organization_id',auth()->user()->userorganization->organization_id)
            ->where('status',true)
            ->whereDate( 'date2' , '>=' ,now() )
            ->with('cadry');
    }

    public function scopeOrgFilter()
    {
        return self::query()
            ->when(request('railway_id'), function ( $query, $railway_id) {
                    return $query->where('railway_id', $railway_id);
                    
            })->when(request('org_id'), function ( $query, $org_id) {
                    return $query->where('organization_id', $org_id);

            })->when(request('dep_id'), function ( $query, $dep_id) {
                    return $query->where('department_id', $dep_id);

            })
            ->where('status',true)
            ->whereDate( 'date2' , '>=' ,now() )
            ->with('cadry');
    }

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }
}
