<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'cadry_id',
        'year',
        'month',
        'days'
    ];

    protected $casts = [
        'days' => 'array'
    ];

    // protected function data(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }
}
