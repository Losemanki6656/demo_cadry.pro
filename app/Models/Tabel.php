<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Tabel extends Model
{
    use HasFactory;

    protected $fillable = [
        'railway_id',
        'organization_id',
        'department_id',
        'cadry_id',
        'send_user_id',
        'cadry_user_id',
        'bux_user_id',
        'year',
        'month',
        'days',
        'fact',
        'selosmenix_prostov',
        'ocherednoy_otpusk',
        'otsusk_s_rodam',
        'bolezn',
        'neyavki_razr',
        'razr_admin',
        'progul',  
        'vixod_prazd',
        'tekush_pros',
        'opazjanie',
        'vsevo',
        'sdelno',
        'svixurochniy',
        'nochnoy',
        'prazdnichniy',
        'tabel_number',
        'ustanovleniy',
        'ekonomie',
        'vid_oplate',
        'sxema_rascheta',
        'sintecheskiy',
        'statya_rasxoda',
        'dop_priznak',
        'kod_primi',
        'prosent_iz_primi',
        'prosent_primi_iz',
        'dni_fact',
        'chasi_fact',
        'fact_rabot',
        'vixod_priznich',
        'status_cadry',
        'status_bux'
    ];
    

    protected $casts = [
        'days' => 'array'
    ];

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    // protected function data(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => json_decode($value, true),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }
}
