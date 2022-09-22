<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_organization',
            'organization_id',
            'user_id');
    }

    public function railway()
    {
        return $this->belongsTo(Railway::class,'railway_id');
    }

    public function cadries()
    {
        return $this->hasMany(Cadry::class)->where(['status' => true]);
    }

    public function scopeFilter()
    {
        return self::query()
        ->when(request('railway_id'), function (Builder $query, $railway_id) {
                return $query->where('railway_id', $railway_id);
                
        })->when(request('org_id'), function (Builder $query, $org_id) {
                return $query->where('organization_id', $org_id);

        })->when(request('dep_id'), function (Builder $query, $dep_id) {
                return $query->where('department_id', $dep_id);

        });
    }

}
