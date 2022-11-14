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
}
