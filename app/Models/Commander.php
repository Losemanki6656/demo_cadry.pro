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

    public function cadry()
    {
        return $this->belongsTo(Cadry::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function commander_payment()
    {
        return $this->belongsTo(CommanderPayment::class);
    }

    public function commander_pupose()
    {
        return $this->belongsTo(CommanderPupose::class);
    }
}
