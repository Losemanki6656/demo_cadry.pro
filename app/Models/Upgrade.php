<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    use HasFactory;

    public function scopeFilter()
    {
        return self::query()
            ->when(request('railway_id'), function ( $query, $railway_id) {
                    return $query->where('railway_id', $railway_id);
                    
            })->when(request('organization_id'), function ( $query, $organization_id) {
                    return $query->where('organization_id', $organization_id);

            });
    }

    public function scopeOrgFilter()
    {
        return self::query()
            ->where('organization_id', auth()->user()->userorganization->organization_id)
            ->when(request('data_qual'), function ( $query, $data_qual) {
                return $query->where('dataqual', $data_qual);

            })
            ->with(['cadry','apparat','training_direction']);
    }

    public function training_direction()
    {
        return $this->belongsTo(TrainingDirection::class);
    }

    public function apparat()
    {
        return $this->belongsTo(Apparat::class);
    }

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }



}
