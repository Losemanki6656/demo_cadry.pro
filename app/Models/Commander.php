<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commander extends Model
{
    use HasFactory;

    protected $fillable = [
        'railway_id',
        'organization_id',
        'user_id',
        'cadry_id',
        'country_id',
        'commander_payment_id',
        'commander_pupose_id',
        'position',
        'command_number',
        'date_command',
        'date1',
        'date2',
        'days',
        'reason',
        'status'
    ];
}
