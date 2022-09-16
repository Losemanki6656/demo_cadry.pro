<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacationIntegration extends Model
{
    use HasFactory;

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    protected $dates = ['date1','date2','period1','period2'];

    public function scopeFilter()
    {
        return self::query()
            ->where('organization_id',auth()->user()->userorganization->organization_id)
            ->where('status_suc',false)
            ->with('cadry');
    }
}
