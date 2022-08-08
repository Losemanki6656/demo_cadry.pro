<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadryRelative extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadry_id',
        'relative_id',
        'sort',
        'fullname',
        'birth_place',
        'post',
        'address'
    ];

    public function relative()
    {
        return $this->belongsTo(Relative::class,'relative_id');
    }

    public function birth_city()
    {
        return $this->belongsTo(City::class,'birth_city_id');
    }

    public function address_city()
    {
        return $this->belongsTo(City::class,'address_city_id');
    }

    public function cadry()
    {
        return $this->hasMany(Cadry::class,'id','cadry_id');
    }
}
