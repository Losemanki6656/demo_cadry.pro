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

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }
}
