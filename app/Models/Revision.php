<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsto(User::class, 'user_id');
    }

    // public function cadry()
    // {
    //     return $this->belongsTo(Cadry::class,'revisionable_id');
    // }
}
